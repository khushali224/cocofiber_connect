<?php
include '../config/db.php';
$id = $_GET['id'];
$res = mysqli_query($con, "SELECT * FROM company_story WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];

    if(!empty($_FILES['image']['name'])){
        $imgName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$imgName");
        $update = "UPDATE company_story SET title='$title', description='$desc', image='$imgName' WHERE id=$id";
    } else {
        $update = "UPDATE company_story SET title='$title', description='$desc' WHERE id=$id";
    }

    mysqli_query($con, $update);
    header("Location: story_manage.php");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="css/admin.css">
</head>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo $data['title']; ?>"><br>
    <textarea name="description"><?php echo $data['description']; ?></textarea><br>
    <input type="file" name="image"><br>
    <button type="submit" name="submit">Update</button>
</form>
    <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</html>