<?php
include 'config/db.php';

$id = $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM sourcing_benefits WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);

    mysqli_query($con, "UPDATE sourcing_benefits SET icon='$icon', title='$title', description='$desc' WHERE id=$id");
    header("Location: sourcing_benefits.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Benefit</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Benefit</h2>
  <form method="POST">
    <label>Icon</label><br>
    <input type="text" name="icon" value="<?php echo htmlspecialchars($row['icon']); ?>" required><br><br>

    <label>Title</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

    <label>Description</label><br>
    <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>

    <button type="submit">Update</button>
  </form>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
