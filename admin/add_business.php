<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = $_POST['day'];
    $hours = $_POST['hours'];

    $stmt = $con->prepare("INSERT INTO business_hours (day, hours) VALUES (?,?)");
    $stmt->bind_param("ss", $day, $hours);
    $stmt->execute();

    header("Location: business_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Business Hours</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Business Hours</h2>
  <form method="POST">
    <input type="text" name="day" placeholder="Day (e.g. Monday)" required><br>
    <input type="text" name="hours" placeholder="Hours (e.g. 9:00 AM - 6:00 PM)" required><br>
    <button type="submit">Save</button>
  </form>
  <div style="margin-top:20px;">
    <a href="business_manage.php" class="btn-back">← Back</a>
  </div>
</div>
</body>
</html>
