<?php
include '../config/db.php';
$contacts = mysqli_query($con, "SELECT * FROM contact_info ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Contact Info</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
  <h2>Manage Contact Information</h2>
  <a href="add_contact.php">➕ Add New</a>
  <table>
    <tr>
      <th>ID</th>
      <th>Headquarters</th>
      <th>Main Phone</th>
      <th>Support Phone</th>
      <th>Fax</th>
      <th>Emails</th>
      <th>Action</th>
    </tr>
    <?php while($c = mysqli_fetch_assoc($contacts)) { ?>
    <tr>
      <td><?= $c['id'] ?></td>
      <td><?= htmlspecialchars($c['headquarters']) ?></td>
      <td><?= htmlspecialchars($c['phone_main']) ?></td>
      <td><?= htmlspecialchars($c['phone_support']) ?></td>
      <td><?= htmlspecialchars($c['fax']) ?></td>
      <td>
        General: <?= htmlspecialchars($c['email_general']) ?><br>
        Support: <?= htmlspecialchars($c['email_support']) ?><br>
        Sales: <?= htmlspecialchars($c['email_sales']) ?>
      </td>
      <td>
        <a href="edit_contact.php?id=<?= $c['id'] ?>">Edit</a> | 
        <a href="delete_contact.php?id=<?= $c['id'] ?>" onclick="return confirm('Delete this entry?');">Delete</a>
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
