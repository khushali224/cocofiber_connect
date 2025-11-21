<?php
include '../config/db.php';
$id = intval($_GET['id']);

$res = mysqli_query($con, "SELECT * FROM testimonials WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if(!$data){ die("Testimonial not found!"); }

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $msg  = mysqli_real_escape_string($con, $_POST['message']);

    // If new image uploaded
    if(!empty($_FILES['image']['name'])){
        $imgName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$imgName");
        $update = "UPDATE testimonials SET name='$name', role='$role', message='$msg', image='$imgName' WHERE id=$id";
    } else {
        $update = "UPDATE testimonials SET name='$name', role='$role', message='$msg' WHERE id=$id";
    }

    mysqli_query($con, $update);
    header("Location: testimonials_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Testimonial</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Edit Testimonial</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>
        <input type="text" name="role" value="<?php echo htmlspecialchars($data['role']); ?>" required>
        <textarea name="message" required><?php echo htmlspecialchars($data['message']); ?></textarea>
        <p>Current Image:</p>
        <?php if(!empty($data['image'])) { ?>
            <img src="../uploads/<?php echo $data['image']; ?>" width="100"><br>
        <?php } ?>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Update">
    </form>
        <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
