<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $image = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    mysqli_query($con, "INSERT INTO how_it_works (image, title, description) VALUES ('$image', '$title', '$description')");
    header("Location: how_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add How It Works Step</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Step</h2>
  <form method="post" enctype="multipart/form-data">
    <label>Image:</label>
    <input type="file" name="image" required><br><br>
    <label>Title:</label>
    <input type="text" name="title" required><br><br>
    <label>Description:</label>
    <textarea name="description" required></textarea><br><br>
    <button type="submit">Save</button>
  </form>
  <br>
  <a href="how_manage.php">← Back to Home</a>
</div>
</body>
</html>
