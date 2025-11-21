<?php
include '../config/db.php';
$reviews = mysqli_query($con, "SELECT * FROM review ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Reviews</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Manage Customer Reviews</h2>
  <a href="add_review.php">➕ Add New</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Designation</th>
      <th>Message</th>
      <th>Rating</th>
      <th>Image</th>
      <th>Action</th>
    </tr>
    <?php while($r = mysqli_fetch_assoc($reviews)) { ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['name']) ?></td>
      <td><?= htmlspecialchars($r['designation']) ?></td>
      <td><?= htmlspecialchars($r['message']) ?></td>
      <td><?= $r['rating'] ?> ⭐</td>
      <td>
        <?php if ($r['image']) { ?>
          <img src="../uploads/<?= $r['image'] ?>" width="50" height="50" style="border-radius:50%;">
        <?php } ?>
      </td>
      <td>
        <a href="edit_review.php?id=<?= $r['id'] ?>">Edit</a> | 
        <a href="delete_review.php?id=<?= $r['id'] ?>" onclick="return confirm('Delete this review?');">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <div style="text-align:center; margin-top:20px;">
    <a href="home.php" class="btn-back">← Back to Home</a>
  </div>
</div>
</body>
</html>
