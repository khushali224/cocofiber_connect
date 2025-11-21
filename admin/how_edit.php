<?php
include '../config/db.php';

$id = intval($_GET['id']);
$row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM how_it_works WHERE id=$id"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $image = $row['image']; // keep old image by default

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $image = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    mysqli_query($con, "UPDATE how_it_works SET image='$image', title='$title', description='$description' WHERE id=$id");
    header("Location: how_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Step</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Step</h2>
  <form method="post" enctype="multipart/form-data">
    <label>Current Image:</label><br>
    <?php if ($row['image']) { ?>
      <img src="../uploads/<?php echo $row['image']; ?>" width="100"><br><br>
    <?php } ?>
    <label>Change Image:</label>
    <input type="file" name="image"><br><br>

    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>
    <label>Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>
    <button type="submit">Update</button>
  </form>
  <br>
  <a href="how_manage.php">← Back to Home</a>
</div>
</body>
</html>
