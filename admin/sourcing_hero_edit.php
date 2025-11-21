<?php
include '../config/db.php';

$id = intval($_GET['id']);
$item = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM sourcing_hero WHERE id=$id"));

if (!$item) {
    die("Hero item not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);

    // Handle image upload
    $image_name = $item['image']; // Keep existing image by default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = 'hero_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image_name);
    }

    mysqli_query($con, "UPDATE sourcing_hero 
                        SET title='$title', subtitle='$subtitle', image='$image_name' 
                        WHERE id=$id");

    header("Location: sourcing_hero.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Hero</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Hero Item</h2>
  <form method="POST" enctype="multipart/form-data" class="form">
    <label>Title</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($item['title']); ?>" required>

    <label>Subtitle</label>
    <textarea name="subtitle" required><?php echo htmlspecialchars($item['subtitle']); ?></textarea>

    <label>Current Image</label><br>
    <?php if ($item['image']): ?>
        <img src="../uploads/<?php echo htmlspecialchars($item['image']); ?>" width="100" alt="Hero Image">
    <?php else: ?>
        No Image
    <?php endif; ?>
    <br><br>

    <label>Change Image</label>
    <input type="file" name="image" accept="image/*">

    <button type="submit">Update</button>
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
