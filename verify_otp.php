<?php
include 'config/db.php';
include 'config/twilio.php';
session_start();

$order_id = $_GET['order_id'] ?? null;
if (!$order_id || !ctype_digit($order_id)) {
    die("Invalid order id.");
}

// Load order details
$stmt = mysqli_prepare($con, "SELECT id, customer_phone, payment_status FROM orders WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$order) {
    die("Order not found.");
}

// Only allow OTP flow if pending
if ($order['payment_status'] !== 'otp_pending') {
    echo "<script>alert('⚠️ This order is not waiting for OTP.'); window.location='view_buy_products.php?id=$order_id';</script>";
    exit;
}

$errMsg = "";

// Convert phone to E.164 format (assume +91 if missing)
$rawPhone = preg_replace('/\D+/', '', $order['customer_phone']);
$phoneE164 = preg_match('/^\+/', $order['customer_phone']) ? $order['customer_phone'] : '+91' . $rawPhone;

// Send OTP automatically once per session per order
if (!isset($_SESSION['otp_sent_for']) || $_SESSION['otp_sent_for'] != $order_id) {
    $send = twilio_send_otp($phoneE164);
    if (!$send['ok']) {
        // Log failure to DB
        $err = $send['error'];
        $stmtErr = mysqli_prepare($con, "UPDATE orders SET otp_last_error = ?, otp_sent_at = NOW() WHERE id = ?");
        mysqli_stmt_bind_param($stmtErr, "si", $err, $order_id);
        mysqli_stmt_execute($stmtErr);
        mysqli_stmt_close($stmtErr);

        die("❌ Failed to send OTP: " . htmlspecialchars($send['error']));
    }

    // Update DB with timestamp
    $stmtSent = mysqli_prepare($con, "UPDATE orders SET otp_sent_at = NOW(), otp_last_error = NULL WHERE id = ?");
    mysqli_stmt_bind_param($stmtSent, "i", $order_id);
    mysqli_stmt_execute($stmtSent);
    mysqli_stmt_close($stmtSent);

    $_SESSION['otp_sent_for'] = $order_id;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['otp_code'] ?? '');
    if (!$code) {
        $errMsg = "Please enter the OTP code sent to your phone.";
    } else {
        // Verify via Twilio
        $check = twilio_check_otp($phoneE164, $code);

        if ($check['ok']) {
            // ✅ Mark order as paid
            $stmt2 = mysqli_prepare($con, "UPDATE orders SET payment_status = 'paid', otp_last_error = NULL WHERE id = ?");
            mysqli_stmt_bind_param($stmt2, "i", $order_id);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            unset($_SESSION['otp_sent_for']); // clear session flag

            echo "<script>alert('✅ Payment approved successfully!'); window.location='view_buy_products.php?id=$order_id';</script>";
            exit;
        } else {
            // ❌ Log failure
            $err = $check['error'];
            $stmtFail = mysqli_prepare($con, "UPDATE orders SET otp_last_error = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmtFail, "si", $err, $order_id);
            mysqli_stmt_execute($stmtFail);
            mysqli_stmt_close($stmtFail);

            $errMsg = "❌ OTP verification failed: " . htmlspecialchars($check['error']);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Verify OTP - Payment Approval</title>
  <style>
    body{font-family:system-ui,Segoe UI,Arial,sans-serif;background:#f6f5f4;margin:0;padding:24px;}
    .wrap{max-width:420px;margin:40px auto;background:#fff;border-radius:12px;box-shadow:0 6px 24px rgba(0,0,0,.08);padding:24px;}
    h2{margin:0 0 12px 0}
    .muted{color:#666;margin-bottom:16px}
    input[type="text"]{width:100%;padding:12px 14px;border:1px solid #ccc;border-radius:8px;font-size:16px;letter-spacing:2px;text-align:center}
    button{margin-top:14px;width:100%;padding:12px 14px;border:none;border-radius:10px;background:#5D4037;color:#fff;font-weight:600;cursor:pointer}
    .error{color:#b00020;margin-top:12px}
    .hint{font-size:13px;color:#777;margin-top:8px}
    .resend{display:block;margin-top:12px;text-align:center}
    a.resend{color:#5D4037;text-decoration:none;font-weight:600}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Enter OTP</h2>
    <div class="muted">
      We’ve sent a 6-digit OTP to your mobile number ending with 
      ****<?php echo htmlspecialchars(substr($rawPhone, -4)); ?>.
    </div>

    <?php if (!empty($errMsg)): ?>
      <div class="error"><?php echo $errMsg; ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="otp_code" maxlength="6" pattern="\d{4,8}" placeholder="••••••" autofocus required>
      <button type="submit">Verify & Approve Payment</button>
    </form>

    <div class="hint">
      Didn’t receive it? 
      <a class="resend" href="resend_otp.php?order_id=<?php echo (int)$order_id; ?>">Resend OTP</a>
    </div>
  </div>
</body>
</html>
