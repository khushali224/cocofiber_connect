<?php
include '../config/db.php';
$values = mysqli_query($con, "SELECT * FROM core_values");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Core Values</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
<h2>Core Values</h2>
<a href="add_value.php">Add Value</a>
<table>
<tr><th>Title</th><th>Description</th><th>Action</th></tr>
<?php while($v = mysqli_fetch_assoc($values)) { ?>
<tr>
  <td><?php echo $v['title']; ?></td>
  <td><?php echo $v['description']; ?></td>
  <td>
    <a href="edit_value.php?id=<?php echo $v['id']; ?>">Edit</a> | 
    <a href="delete_value.php?id=<?php echo $v['id']; ?>">Delete</a>
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
