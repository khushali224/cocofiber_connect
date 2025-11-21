<?php
include '../config/db.php';

$id = $_GET['id'];
$result = mysqli_query($con, "SELECT * FROM review WHERE id=$id");
$review = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

    $image = $review['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    }

    $stmt = $con->prepare("UPDATE review SET name=?, designation=?, message=?, image=?, rating=? WHERE id=?");
    $stmt->bind_param("ssssii", $name, $designation, $message, $image, $rating, $id);
    $stmt->execute();

    header("Location: review_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Review</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Edit Review</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" value="<?= htmlspecialchars($review['name']) ?>" required><br>
    <input type="text" name="designation" value="<?= htmlspecialchars($review['designation']) ?>" required><br>
    <textarea name="message" required><?= htmlspecialchars($review['message']) ?></textarea><br>
    <input type="number" name="rating" min="1" max="5" value="<?= $review['rating'] ?>" required><br>
    <input type="file" name="image"><br>
    <?php if ($review['image']) { ?>
      <img src="../uploads/<?= $review['image'] ?>" width="60" height="60" style="border-radius:50%;">
    <?php } ?>
    <br>
    <button type="submit">Update</button>
  </form>
  <a href="review_manage.php" class="btn-back">← Back</a>
</div>
</body>
</html>
