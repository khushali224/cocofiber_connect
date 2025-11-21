<?php
include('config/db.php');  // Make sure this connects to cocofiber_connect DB
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Normalize input
    $email = strtolower(trim($_POST['email']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Please enter a valid email address.";
    } else {
        $email = mysqli_real_escape_string($con, $email);

        // Check if email exists (case-insensitive)
        $sql = "SELECT * FROM registration WHERE LOWER(TRIM(email))='$email' LIMIT 1";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Generate reset token
            $token  = bin2hex(random_bytes(16));
            $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

            // Save token + expiry
            $update = mysqli_query($con, 
                "UPDATE registration 
                 SET reset_token='$token', reset_expire='$expire' 
                 WHERE email='$email'");

            if ($update) {
                // Build reset link
                $reset_link = "http://localhost/cocofiber_connect/reset_password.php?token=03084c6048a28722917b84e77132c5eb" . $token;

                $subject = "Password Reset Request - CocoFiber Connect";
                $body = "Hi " . $user['username'] . ",\n\n"
                      . "We received a request to reset your password.\n"
                      . "Click the link below to reset it:\n\n"
                      . $reset_link . "\n\n"
                      . "This link will expire in 1 hour.\n\n"
                      . "If you didn’t request this, please ignore this email.";
                $headers = "From: no-reply@cocofiberconnect.com";

                // Try sending mail
                if (mail($email, $subject, $body, $headers)) {
                    $message = "✅ A password reset link has been sent to <b>$email</b>.";
                } else {
                    // Fallback for local/offline dev
                    $message = "⚠️ Email could not be sent (mail server not configured).<br>
                                Use this link to reset your password:<br>
                                <a href='$reset_link'>$reset_link</a>";
                }
            } else {
                $message = "❌ Error saving reset token.";
            }
        } else {
            $message = "❌ Email not found in our records.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="css/style1.css">
  <style>
    .container { max-width: 400px; margin: 50px auto; padding: 20px; border-radius: 8px; background: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    h2 { text-align:center; margin-bottom:20px; }
    .msg { text-align:center; margin:10px; font-weight:bold; }
    .error { color:red; }
    .success { color:green; }
    .warning { color:orange; }
    .input-box { margin-bottom:15px; }
    .input-box input { width:100%; padding:10px; border:1px solid #ccc; border-radius:5px; }
    .btn { width:100%; padding:10px; background:#8B5A2B; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:16px; }
    .btn:hover { background:#A0522D; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Forgot Password</h2>
    <?php if ($message): ?>
      <p class="msg 
        <?= (strpos($message,'✅')!==false) ? 'success' : 
            ((strpos($message,'⚠️')!==false) ? 'warning' : 'error') ?>">
        <?= $message ?>
      </p>
    <?php endif; ?>

    <form method="POST">
      <div class="input-box">
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>
      <button type="submit" class="btn">Send Reset Link</button>
    </form>
  </div>
</body>
</html>
