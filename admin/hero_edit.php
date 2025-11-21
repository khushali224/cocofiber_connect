<?php
include '../config/db.php';
$id = intval($_GET['id']);
$res = mysqli_query($con, "SELECT * FROM hero_section WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if(!$data){ die("Hero not found!"); }

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];

    if(!empty($_FILES['image']['name'])){
        $imgName = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$imgName");
    } else {
        $imgName = $data['image'];
    }

    mysqli_query($con, "UPDATE hero_section 
                        SET title='$title', subtitle='$subtitle', image='$imgName' 
                        WHERE id=$id");

    header("Location: hero_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Hero</title><link rel="stylesheet" href="css/admin.css"></head>
<body>
<div class="container">
  <h2>Edit Hero</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>
    <textarea name="subtitle"><?php echo htmlspecialchars($data['subtitle']); ?></textarea>
    <input type="file" name="image">
    <?php if(!empty($data['image'])) { ?>
      <p>Current Image:</p>
      <img src="../uploads/<?php echo $data['image']; ?>" width="150">
    <?php } ?>
    <input type="submit" name="submit" value="Update">
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
