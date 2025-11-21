<?php
include '../config/db.php';

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    $imgName = "";
    if(!empty($_FILES['image']['name'])){
        $imgName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$imgName");
    }

    mysqli_query($con, "INSERT INTO hero_section (title,subtitle,image) VALUES ('$title','$subtitle','$imgName')");
    header("Location: hero_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Hero</title><link rel="stylesheet" href="css/admin.css"></head>
<body>
<div class="container">
  <h2>Add Hero</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="subtitle" placeholder="Subtitle"></textarea>
    <input type="file" name="image">
    <input type="submit" name="submit" value="Save">
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
