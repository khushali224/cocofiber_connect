<?php
include '../config/db.php';

// Get ID
$id = $_GET['id'] ?? null;

// Fetch record
if ($id) {
    $res = mysqli_query($con, "SELECT * FROM sourcing_sections WHERE id=" . intval($id));
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
    } else {
        echo "Record not found!";
        exit;
    }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_name = mysqli_real_escape_string($con, $_POST['section_name']);
    $title = mysqli_real_escape_string($con, $_POST['title']);

    $sql = "UPDATE sourcing_sections SET section_name='$section_name', title='$title' WHERE id=" . intval($id);
    mysqli_query($con, $sql);

    header("Location: manage_sections.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Section</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2>Edit Section</h2>
    <form method="POST">
        <label>Section Name:</label><br>
        <input type="text" name="section_name" value="<?php echo htmlspecialchars($row['section_name']); ?>" required><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

        <button type="submit" class="btn-add">Update</button>
        <a href="manage_sections.php" class="btn-back">Cancel</a>
    </form>
</div>
</body>
</html>
