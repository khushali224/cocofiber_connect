<?php
include('config/db.php');
session_start();

$message = "";
$token = $_GET['token'] ?? '';

if ($token === '') {
    die("Invalid reset link.");
}

$query = mysqli_query($con, "SELECT * FROM registration WHERE reset_token='$token' AND reset_expire > NOW() LIMIT 1");

if ($query && mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = trim($_POST['password']);
        $confirm  = trim($_POST['confirm_password']);

        if ($password !== $confirm) {
            $message = "❌ Passwords do not match.";
        } elseif (strlen($password) < 6) {
            $message = "❌ Password must be at least 6 characters.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = mysqli_query($con, "UPDATE registration 
                                          SET password='$hash', reset_token=NULL, reset_expire=NULL 
                                          WHERE id=" . $user['id']);
            if ($update) {
                $message = "✅ Password reset successful. <a href='login.php'>Login here</a>";
            } else {
                $message = "❌ Error updating password.";
            }
        }
    }
} else {
    die("❌ Reset link is invalid or expired.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <link rel="stylesheet" href="css/style1.css">
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <?php if ($message): ?>
      <p style="text-align:center; font-weight:bold;"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="input-box">
        <input type="password" name="password" placeholder="New Password" required>
      </div>
      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn">Reset Password</button>
    </form>
  </div>
</body>
</html>
