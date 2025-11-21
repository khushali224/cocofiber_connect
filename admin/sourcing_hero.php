<?php
include '../config/db.php';

// Fetch hero entries
$items = mysqli_query($con, "SELECT * FROM sourcing_hero ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Hero Section</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Hero Section</h2>
  <a href="sourcing_hero_add.php">➕ Add Hero</a>
  <table>
    <tr>
      <th>Image</th>
      <th>Title</th>
      <th>Subtitle</th>
      <th>Action</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($items)) { ?>
    <tr>
      <td>
        <?php if($row['image']) { ?>
          <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" width="80" alt="Hero Image">
        <?php } else { echo "No Image"; } ?>
      </td>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['subtitle']); ?></td>
      <td>
        <a href="sourcing_hero_edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="sourcing_hero_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this hero item?');">Delete</a>
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
