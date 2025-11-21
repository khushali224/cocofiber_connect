<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hq = $_POST['headquarters'];
    $phone_main = $_POST['phone_main'];
    $phone_support = $_POST['phone_support'];
    $fax = $_POST['fax'];
    $email_general = $_POST['email_general'];
    $email_support = $_POST['email_support'];
    $email_sales = $_POST['email_sales'];

    $stmt = $con->prepare("INSERT INTO contact_info (headquarters, phone_main, phone_support, fax, email_general, email_support, email_sales) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $hq, $phone_main, $phone_support, $fax, $email_general, $email_support, $email_sales);
    $stmt->execute();

    header("Location: contact_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Contact Info</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Contact Information</h2>
  <form method="POST">
    <textarea name="headquarters" placeholder="Headquarters" required></textarea><br>
    <input type="text" name="phone_main" placeholder="Main Phone"><br>
    <input type="text" name="phone_support" placeholder="Support Phone"><br>
    <input type="text" name="fax" placeholder="Fax"><br>
    <input type="email" name="email_general" placeholder="General Email"><br>
    <input type="email" name="email_support" placeholder="Support Email"><br>
    <input type="email" name="email_sales" placeholder="Sales Email"><br>
    <button type="submit">Save</button>
  </form>
  <div style="margin-top:20px;">
    <a href="contact_manage.php" class="btn-back">← Back</a>
  </div>
</div>
</body>
</html>
