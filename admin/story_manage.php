<?php
include '../config/db.php';
$stories = mysqli_query($con, "SELECT * FROM company_story ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Our Story</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Our Story</h2>
    <a href="add_story.php">➕ Add Story</a>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php while($s = mysqli_fetch_assoc($stories)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($s['title']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($s['description'])); ?></td>
            <td>
                <?php if(!empty($s['image'])) { ?>
                    <img src="../uploads/<?php echo $s['image']; ?>" width="120">
                <?php } else { echo "No Image"; } ?>
            </td>
            <td>
                <a href="edit_story.php?id=<?php echo $s['id']; ?>">Edit</a> | 
                <a href="delete_story.php?id=<?php echo $s['id']; ?>" onclick="return confirm('Delete this story?');">Delete</a>
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
