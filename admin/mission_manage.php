<?php
include '../config/db.php';
$missions = mysqli_query($con, "SELECT * FROM mission_vision ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Mission & Vision</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Manage Mission & Vision</h2>
    <a href="add_mission.php">➕ Add New</a>
    <table>
        <tr>
            <th>Type</th>
            <th>Icon</th>
            <th>Title</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while($m = mysqli_fetch_assoc($missions)) { ?>
        <tr>
            <td><?php echo ucfirst($m['type']); ?></td>
            <td><?php echo htmlspecialchars($m['icon']); ?></td>
            <td><?php echo htmlspecialchars($m['title']); ?></td>
            <td><?php echo htmlspecialchars($m['description']); ?></td>
            <td>
                <a href="edit_mission.php?id=<?php echo $m['id']; ?>">Edit</a> | 
                <a href="delete_mission.php?id=<?php echo $m['id']; ?>" onclick="return confirm('Delete this entry?');">Delete</a>
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
