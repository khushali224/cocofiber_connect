<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $message = $_POST['message'];
    $rating = $_POST['rating'];

    // Upload image
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/".$image);
    }

    $stmt = $con->prepare("INSERT INTO review (name, designation, message, image, rating) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssssi", $name, $designation, $message, $image, $rating);
    $stmt->execute();

    header("Location: review_manage.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Review</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Add Review</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="text" name="designation" placeholder="Designation" required><br>
    <textarea name="message" placeholder="Message" required></textarea><br>
    <input type="number" name="rating" min="1" max="5" value="5" required><br>
    <input type="file" name="image"><br>
    <button type="submit">Save</button>
  </form>
  <a href="review_manage.php" class="btn-back">← Back</a>
</div>
</body>
</html>
