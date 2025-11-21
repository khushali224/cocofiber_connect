<?php
include '../config/db.php';
if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    mysqli_query($con, "INSERT INTO core_values (title,description) VALUES ('$title','$desc')");
    header("Location: values_manage.php");
}
?>
<html>
    <head>
            <link rel="stylesheet" href="css/admin.css">
</head>
<form method="POST">
    <input type="text" name="title" placeholder="Value Title">
    <textarea name="description" placeholder="Description"></textarea>
    <input type="submit" name="submit" value="Save">
</form>
    <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</html>
