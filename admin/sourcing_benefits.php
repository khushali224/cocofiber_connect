<?php
include 'config/db.php';
$benefits = mysqli_query($con, "SELECT * FROM sourcing_benefits ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Benefits</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Manage Benefits</h2>
  <a href="sourcing_benefits_add.php">➕ Add Benefit</a>
  <table>
    <tr><th>Icon</th><th>Title</th><th>Description</th><th>Action</th></tr>
    <?php while($row = mysqli_fetch_assoc($benefits)) { ?>
    <tr>
      <td style="font-size:24px;"><?php echo htmlspecialchars($row['icon']); ?></td>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['description']); ?></td>
      <td>
        <a href="sourcing_benefits_edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="sourcing_benefits_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this benefit?');">Delete</a>
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
