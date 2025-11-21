<?php
// Include database and Twilio configuration
include 'config/db.php';
include 'config/twilio.php'; 
session_start();

// --- Helper to convert phone to E.164 format (India) ---
function to_e164_india($raw) {
    $digits = preg_replace('/\D+/', '', $raw);
    if (preg_match('/^[6-9]\d{9}$/', $digits)) return '+91' . $digits;
    if (preg_match('/^\+\d{8,15}$/', $raw)) return $raw;
    return false;
}

// --- Ensure user is logged in and necessary parameters are present ---
if (!isset($_SESSION['username']) || !isset($_GET['bulk_order']) || $_GET['bulk_order'] != 1 || !isset($_GET['customer_id'])) {
    header("Location: login_register.php");
    exit();
}

$user_id = (int)$_GET['customer_id'];
$username = $_SESSION['username'];
$error = '';
$message = '';
$success = false;
$updated_rows = 0;

// --- Get user info (email and phone) from registration table ---
$user_stmt = $con->prepare("SELECT email, phone FROM registration WHERE id=? LIMIT 1");
if (!$user_stmt) die("Prepare failed (user): " . $con->error);

$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
    die("User not found or mismatch.");
}

$user = $user_result->fetch_assoc();
$user_email = $user['email'];
$raw_phone = $user['phone'];
$e164_phone = to_e164_india($raw_phone);

if (!$e164_phone) {
    die("Invalid phone number format for OTP: " . htmlspecialchars($raw_phone));
}

// --- Function to log Twilio errors to pending orders ---
function log_twilio_error($con, $user_email, $errMsg) {
    $log_stmt = $con->prepare("
        UPDATE orders 
        SET otp_last_error = ?, otp_sent_at = NOW() 
        WHERE customer_email = ? 
        AND payment_method = 'GooglePay' 
        AND payment_status = 'otp_pending'
        AND (otp_last_error IS NULL OR otp_last_error != ?)
    ");
    if ($log_stmt) {
        $clean_errMsg = substr($errMsg, 0, 255); // Truncate to fit column size
        $log_stmt->bind_param("sss", $clean_errMsg, $user_email, $clean_errMsg); 
        $log_stmt->execute();
        $log_stmt->close();
    }
}


// --- OTP Resend Logic ---
$sent_flag = 'bulk_order_otp_sent_' . $user_id;
$resend_attempted = false;

if (isset($_POST['resend_otp'])) {
    unset($_SESSION[$sent_flag]); // Clear the flag to force a new OTP send
    $resend_attempted = true;
}

// --- OTP Sending Logic (Using the function from twilio.php) ---
if (!isset($_SESSION[$sent_flag])) {
    // Send OTP via Twilio Verify API
    $send_result = twilio_send_otp($e164_phone);

    if ($send_result['ok']) {
        $_SESSION[$sent_flag] = true;
        log_twilio_error($con, $user_email, null); // Clear error, set otp_sent_at
        
        $phone_masked = substr($raw_phone, 0, 2) . 'XXXXXX' . substr($raw_phone, -4);
        
        if ($resend_attempted) {
             $message = "A **new** verification code has been sent to your phone number: " . $phone_masked . ".";
        } else {
             $message = "A verification code has been sent to your phone number: " . $phone_masked . ".";
        }
    } else {
        $full_error = $send_result['error'] ?? 'Unknown Twilio Error during SEND';
        $error = "Could not send OTP. Error: " . $full_error;
        log_twilio_error($con, $user_email, $full_error);
    }
} else {
    $message = "A verification code was already sent. Please check your phone.";
}


// --- OTP Verification Logic (Using the function from twilio.php) ---
if (isset($_POST['verify_otp']) && empty($error)) {
    $user_otp = trim($_POST['otp'] ?? '');

    if (empty($user_otp) || !preg_match('/^\d{6}$/', $user_otp)) {
        $error = "Please enter a valid 6-digit OTP.";
    } else {
        // Check OTP via Twilio Verify API
        $check_result = twilio_check_otp($e164_phone, $user_otp);

        if ($check_result['ok']) {
            // OTP is correct!

            // 1. Update all pending GooglePay orders for this user
            // *** COLUMN 'otp_verified_at' REMOVED HERE ***
            $update_stmt = $con->prepare("
                UPDATE orders 
                SET payment_status = 'payment_received', otp_last_error = NULL 
                WHERE customer_email = ? 
                AND payment_method = 'GooglePay' 
                AND payment_status = 'otp_pending'
            ");
            
            if (!$update_stmt) die("Prepare failed (update): " . $con->error);
            $update_stmt->bind_param("s", $user_email); 
            $update_stmt->execute();
            $updated_rows = $update_stmt->affected_rows;
            $update_stmt->close();

            // 2. Clear OTP session flag
            unset($_SESSION[$sent_flag]);

            // 3. Set success flag to true to display the final message
            $success = true;

        } else {
            // Log the verification error
            $full_error = $check_result['error'] ?? 'Verification failed.';
            $error = "Invalid OTP or OTP expired. Please try again. Twilio Error: " . $full_error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify Bulk Order OTP</title>
<style>
:root {
    --primary-brown:#8D6E63;
    --secondary-brown:#5D4037;
    --light-brown:#D7CCC8;
    --text-dark:#212121;
    --text-light:#FFFFFF;
}
body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#D7CCC8;margin:0;padding:20px;color:var(--text-dark);display:flex;justify-content:center;align-items:center;min-height:100vh;}
.card{max-width:500px;width:100%;margin:auto;background:#deaa88;padding:25px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);text-align:center;}
h2{color:var(--secondary-brown);margin-bottom:20px;}
p.info{margin-bottom:20px;color:var(--primary-brown);font-weight:bold;}
.error{color:#D32F2F;background:#FFEBEE;border:1px solid #D32F2F;padding:10px;margin-bottom:15px;border-radius:5px;}
.message{color:#388E3C;background:#E8F5E9;border:1px solid #388E3C;padding:10px;margin-bottom:15px;border-radius:5px;}
.success{color:#00C853;background:#E8F5E9;border:1px solid #00C853;padding:20px;margin-bottom:20px;border-radius:5px;}
input[type="text"]{width:80%;padding:10px;margin:10px 0;border-radius:6px;border:1px solid #ccc;font-size:18px;text-align:center;max-width:300px;}
.form-actions { display: flex; justify-content: space-around; gap: 10px; margin-top: 20px;}
button,input[type="submit"], .btn-link{
    background-color:var(--secondary-brown);
    color:var(--text-light);
    border:none;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    font-size:16px;
    transition:background-color 0.3s ease;
    width:auto;
    text-decoration: none;
    display: inline-block;
}
button:hover,input[type="submit"]:hover, .btn-link:hover{background-color:#4E342E;}

.resend-btn {
    background-color: #A1887F; /* Lighter brown for secondary action */
    padding: 8px 15px;
    font-size: 14px;
    margin-top: 10px;
}
.resend-btn:hover {
    background-color: #8D6E63;
}
</style>
</head>
<body>
<div class="card">
    <?php if ($success): ?>
        <div class="success">
            <h2>Order(s) Placed Successfully!</h2>
            <p>Your payment has been successfully verified, and **<?php echo $updated_rows; ?>** item(s) have been ordered.</p>
            <p>Thank you for your purchase.</p>
            <div class="form-actions" style="margin-top: 0;">
                <a href="admin_product.php" class="btn-link">Continue Shopping</a>
            </div>
        </div>
    <?php else: ?>
        <h2>Verify Order Payment</h2>
        <p>Please enter the 6-digit verification code sent to your phone to confirm your GooglePay order(s).</p>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="message"><?php echo nl2br(htmlspecialchars($message)); ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" pattern="\d{6}" maxlength="6" required placeholder="123456">
            
            <div class="form-actions">
                <button type="submit" name="verify_otp">Verify Code</button>
            </div>
        </form>
        
        <form method="POST" style="margin-top: 15px;">
            <p style="margin: 10px 0 5px 0; font-size: 0.9em;">Did not receive the code?</p>
            <button type="submit" name="resend_otp" class="resend-btn">Resend New OTP</button>
        </form>

    <?php endif; ?>
</div>
</body>
</html>