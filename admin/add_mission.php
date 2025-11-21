<?php
include '../config/db.php';

if(isset($_POST['submit'])){
    $type  = mysqli_real_escape_string($con, $_POST['type']);
    $icon  = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc  = mysqli_real_escape_string($con, $_POST['description']);

    $sql = "INSERT INTO mission_vision (type,icon,title,description) 
            VALUES ('$type','$icon','$title','$desc')";
    mysqli_query($con, $sql);

    header("Location: mission_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Mission / Vision</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Add Mission / Vision</h2>
    <form method="POST">
        <label>Type</label>
        <select name="type" required>
            <option value="mission">Mission</option>
            <option value="vision">Vision</option>
        </select>

        <label>Icon</label>
        <input type="text" name="icon" placeholder="🌍 or fa-icon" required>

        <label>Title</label>
        <input type="text" name="title" placeholder="Enter title" required>

        <label>Description</label>
        <textarea name="description" placeholder="Enter description" required></textarea>

        <input type="submit" name="submit" value="Save">
    </form>
        <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
