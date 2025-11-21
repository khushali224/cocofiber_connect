<?php
include '../config/db.php';

$id = $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM business_hours WHERE id=$id");
$bh = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = $_POST['day'];
    $hours = $_POST['hours'];

    $stmt = $con->prepare("UPDATE business_hours SET day=?, hours=? WHERE id=?");
    $stmt->bind_param("ssi", $day, $hours, $id);
    $stmt->execute();

    header("Location: business_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Business Hours</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Business Hours</h2>
  <form method="POST">
    <input type="text" name="day" value="<?= htmlspecialchars($bh['day']) ?>" required><br>
    <input type="text" name="hours" value="<?= htmlspecialchars($bh['hours']) ?>" required><br>
    <button type="submit">Update</button>
  </form>
  <div style="margin-top:20px;">
    <a href="business_manage.php" class="btn-back">← Back</a>
  </div>
</div>
</body>
</html>
