<?php
include '../config/db.php';

$id = $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM contact_info WHERE id=$id");
$contact = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hq = $_POST['headquarters'];
    $phone_main = $_POST['phone_main'];
    $phone_support = $_POST['phone_support'];
    $fax = $_POST['fax'];
    $email_general = $_POST['email_general'];
    $email_support = $_POST['email_support'];
    $email_sales = $_POST['email_sales'];

    $stmt = $con->prepare("UPDATE contact_info SET headquarters=?, phone_main=?, phone_support=?, fax=?, email_general=?, email_support=?, email_sales=? WHERE id=?");
    $stmt->bind_param("sssssssi", $hq, $phone_main, $phone_support, $fax, $email_general, $email_support, $email_sales, $id);
    $stmt->execute();

    header("Location: contact_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Contact Info</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Contact Information</h2>
  <form method="POST">
    <textarea name="headquarters" required><?= htmlspecialchars($contact['headquarters']) ?></textarea><br>
    <input type="text" name="phone_main" value="<?= htmlspecialchars($contact['phone_main']) ?>"><br>
    <input type="text" name="phone_support" value="<?= htmlspecialchars($contact['phone_support']) ?>"><br>
    <input type="text" name="fax" value="<?= htmlspecialchars($contact['fax']) ?>"><br>
    <input type="email" name="email_general" value="<?= htmlspecialchars($contact['email_general']) ?>"><br>
    <input type="email" name="email_support" value="<?= htmlspecialchars($contact['email_support']) ?>"><br>
    <input type="email" name="email_sales" value="<?= htmlspecialchars($contact['email_sales']) ?>"><br>
    <button type="submit">Update</button>
  </form>
  <div style="margin-top:20px;">
    <a href="contact_manage.php" class="btn-back">← Back</a>
  </div>
</div>
</body>
</html>
