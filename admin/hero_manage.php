<?php
include '../config/db.php';
$res = mysqli_query($con, "SELECT * FROM hero_section ORDER BY id DESC");
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
  <a href="hero_add.php">➕ Add Hero</a>
  <table>
    <tr><th>Title</th><th>Subtitle</th><th>Image</th><th>Action</th></tr>
    <?php while($row = mysqli_fetch_assoc($res)) { ?>
    <tr>
      <td><?php echo htmlspecialchars($row['title']); ?></td>
      <td><?php echo htmlspecialchars($row['subtitle']); ?></td>
      <td>
        <?php if(!empty($row['image'])) { ?>
          <img src="../uploads/<?php echo $row['image']; ?>" width="120">
        <?php } else { echo "No Image"; } ?>
      </td>
      <td>
        <a href="hero_edit.php?id=<?php echo $row['id']; ?>">Edit</a> | 
        <a href="hero_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this hero section?');">Delete</a>
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
