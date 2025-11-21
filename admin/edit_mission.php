<?php
include '../config/db.php';
$id = intval($_GET['id']);

$res = mysqli_query($con, "SELECT * FROM mission_vision WHERE id=$id");
$data = mysqli_fetch_assoc($res);

if(!$data){ die("Record not found!"); }

if(isset($_POST['submit'])){
    $type  = mysqli_real_escape_string($con, $_POST['type']);
    $icon  = mysqli_real_escape_string($con, $_POST['icon']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc  = mysqli_real_escape_string($con, $_POST['description']);

    $sql = "UPDATE mission_vision 
            SET type='$type', icon='$icon', title='$title', description='$desc' 
            WHERE id=$id";
    mysqli_query($con, $sql);

    header("Location: mission_manage.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Mission / Vision</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Edit Mission / Vision</h2>
    <form method="POST">
        <label>Type</label>
        <select name="type" required>
            <option value="mission" <?php if($data['type']=="mission") echo "selected"; ?>>Mission</option>
            <option value="vision" <?php if($data['type']=="vision") echo "selected"; ?>>Vision</option>
        </select>

        <label>Icon</label>
        <input type="text" name="icon" value="<?php echo htmlspecialchars($data['icon']); ?>" required>

        <label>Title</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($data['title']); ?>" required>

        <label>Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($data['description']); ?></textarea>

        <input type="submit" name="submit" value="Update">
    </form>
        <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
