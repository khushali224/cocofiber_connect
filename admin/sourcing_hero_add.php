<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);

    // Handle image upload
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = 'hero_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image_name);
    }

    mysqli_query($con, "INSERT INTO sourcing_hero (title, subtitle, image) VALUES ('$title','$subtitle','$image_name')");

    header("Location: sourcing_hero.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Hero</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Hero Item</h2>
  <form method="POST" enctype="multipart/form-data" class="form">
    <label>Title</label>
    <input type="text" name="title" required>

    <label>Subtitle</label>
    <textarea name="subtitle" required></textarea>

    <label>Image</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Save</button>
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
