<?php
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);

    mysqli_query($con, "INSERT INTO sourcing_benefits (icon, title, description) VALUES ('$icon','$title','$desc')");
    header("Location: sourcing_benefits.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Benefit</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Benefit</h2>
  <form method="POST">
    <label>Icon (emoji or class name)</label><br>
    <input type="text" name="icon" placeholder="🌱 or fa-leaf" required><br><br>

    <label>Title</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required></textarea><br><br>

    <button type="submit">Save</button>
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
