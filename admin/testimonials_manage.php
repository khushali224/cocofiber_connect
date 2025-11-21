<?php
include '../config/db.php';
$test = mysqli_query($con, "SELECT * FROM testimonials");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Testimonials</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Testimonials</h2>
    <a href="add_testimonial.php">➕ Add Testimonial</a>
    <table>
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Message</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php while($t = mysqli_fetch_assoc($test)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($t['name']); ?></td>
            <td><?php echo htmlspecialchars($t['role']); ?></td>
            <td><?php echo htmlspecialchars($t['message']); ?></td>
            <td>
                <?php if(!empty($t['image'])) { ?>
                    <img src="../uploads/<?php echo $t['image']; ?>" width="80">
                <?php } ?>
            </td>
            <td>
                <a href="edit_testimonial.php?id=<?php echo $t['id']; ?>">Edit</a> | 
                <a href="delete_testimonial.php?id=<?php echo $t['id']; ?>" onclick="return confirm('Delete this testimonial?');">Delete</a>
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
