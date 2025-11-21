<?php
include '../config/db.php';

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];

    // upload image
    $imgName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/$imgName");

    $sql = "INSERT INTO company_story (title, image, description) VALUES ('$title','$imgName','$desc')";
    mysqli_query($con, $sql);
    header("Location: story_manage.php");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/admin.css">
</head>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit" name="submit">Save</button>
</form>

  <div style="text-align: center;">
    <a href="home.php" class="btn-back">← Back to Home</a>
  </div>
</html>