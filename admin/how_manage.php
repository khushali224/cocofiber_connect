<?php
include '../config/db.php';
$items = mysqli_query($con, "SELECT * FROM how_it_works ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage How It Works</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>How It Works</h2>
  <a href="how_add.php">➕ Add Step</a>
  <table>
    <tr><th>Image</th><th>Title</th><th>Description</th><th>Action</th></tr>
    <?php while($row = mysqli_fetch_assoc($items)) { ?>
    <tr>
      <td>
        <?php if($row['image']) { ?>
          <img src="../uploads/<?php echo $row['image']; ?>" width="80">
        <?php } else { echo "No Image"; } ?>
      </td>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['description']); ?></td>
      <td>
        <a href="how_edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="how_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this step?');">Delete</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
