<?php
include '../config/db.php';

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $msg  = mysqli_real_escape_string($con, $_POST['message']);

    // Handle image upload
    $imgName = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if(!empty($imgName)){
        move_uploaded_file($tmp, "../uploads/$imgName");
    } else {
        $imgName = ""; // in case no image uploaded
    }

    $sql = "INSERT INTO testimonials (name,role,message,image) 
            VALUES ('$name','$role','$msg','$imgName')";
    mysqli_query($con, $sql);

    header("Location: testimonials_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Testimonial</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Add Testimonial</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Customer Name" required>
        <input type="text" name="role" placeholder="Role/Job" required>
        <textarea name="message" placeholder="Message" required></textarea>
        <input type="file" name="image" required>
        <input type="submit" name="submit" value="Save">
    </form>
        <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
