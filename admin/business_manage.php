<?php
include '../config/db.php';
$hours = mysqli_query($con, "SELECT * FROM business_hours ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Business Hours</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Manage Business Hours</h2>
  <a href="add_business.php">➕ Add New</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Day</th>
      <th>Hours</th>
      <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($hours)) { ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['day']) ?></td>
      <td><?= htmlspecialchars($row['hours']) ?></td>
      <td>
        <a href="edit_business.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="delete_business.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this entry?');">Delete</a>
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
