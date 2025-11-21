<?php
session_start();
include('config/db.php');

// Initialize variables
$id = "";
$name = "";
$title = "";
$rating = "";
$review = "";

// Handle Add/Edit Form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    if (!empty($_POST['id'])) {
        // Update
        $id = (int)$_POST['id'];
        $stmt = $con->prepare("UPDATE reviews SET name=?, title=?, rating=?, review=? WHERE id=?");
        $stmt->bind_param("ssisi", $name, $title, $rating, $review, $id);
        $stmt->execute();
    } else {
        // Insert
        $stmt = $con->prepare("INSERT INTO reviews (name, title, rating, review) VALUES (?,?,?,?)");
        $stmt->bind_param("ssis", $name, $title, $rating, $review);
        $stmt->execute();
    }
    header("Location: reviews_manage.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($con, "DELETE FROM reviews WHERE id=$id");
    header("Location: reviews_manage.php");
    exit;
}

// Handle Edit (prefill form)
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = mysqli_query($con, "SELECT * FROM reviews WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $name = $row['name'];
        $title = $row['title'];
        $rating = $row['rating'];
        $review = $row['review'];
    }
}

$reviews = mysqli_query($con, "SELECT * FROM reviews ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Customer Reviews</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
  <h2>Manage Customer Reviews</h2>

  <!-- Add/Edit Form -->
  <form method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <input type="text" name="name" placeholder="Customer Name" value="<?= htmlspecialchars($name) ?>" required>
    <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($title) ?>" required>
    <select name="rating" required>
      <option value="">Select Rating</option>
      <option value="5" <?= $rating==5?"selected":"" ?>>5 - Excellent</option>
      <option value="4" <?= $rating==4?"selected":"" ?>>4 - Very Good</option>
      <option value="3" <?= $rating==3?"selected":"" ?>>3 - Good</option>
      <option value="2" <?= $rating==2?"selected":"" ?>>2 - Fair</option>
      <option value="1" <?= $rating==1?"selected":"" ?>>1 - Poor</option>
    </select>
    <textarea name="review" placeholder="Write review..." required><?= htmlspecialchars($review) ?></textarea>
    <button type="submit"><?= $id ? "Update Review" : "Add Review" ?></button>
  </form>

  <!-- Reviews Table -->
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Title</th>
      <th>Rating</th>
      <th>Review</th>
      <th>Actions</th>
    </tr>
    <?php while($row=mysqli_fetch_assoc($reviews)) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= $row['rating'] ?> ★</td>
        <td><?= htmlspecialchars($row['review']) ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>">Edit</a> | 
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this review?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>
