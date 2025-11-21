<?php
include '../config/db.php';

// Initialize variables
$id = $_GET['id'] ?? null;
$add = isset($_GET['add']);
$section_name = '';
$title = '';

// If editing, fetch existing record
if ($id) {
    $res = mysqli_query($con, "SELECT * FROM sourcing_sections WHERE id=" . intval($id));
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $section_name = $row['section_name'];
        $title = $row['title'];
    }
}

// Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section_name = mysqli_real_escape_string($con, $_POST['section_name']);
    $title = mysqli_real_escape_string($con, $_POST['title']);

    if ($id) {
        // Update existing record
        $sql = "UPDATE sourcing_sections SET section_name='$section_name', title='$title' WHERE id=" . intval($id);
        mysqli_query($con, $sql);
    } else {
        // Insert new record
        $sql = "INSERT INTO sourcing_sections (section_name, title) VALUES ('$section_name', '$title')";
        mysqli_query($con, $sql);
    }

    header("Location: manage_sections.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $id ? "Edit Section" : "Add New Section"; ?></title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
    <h2><?php echo $id ? "Edit Section" : "Add New Section"; ?></h2>
    <form method="POST">
        <label>Section Name:</label><br>
        <input type="text" name="section_name" value="<?php echo htmlspecialchars($section_name); ?>" required><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required><br><br>

        <button type="submit" class="btn-add"><?php echo $id ? "Update" : "Add"; ?></button>
        <a href="manage_sections.php" class="btn-back">Cancel</a>
    </form>
</div>
</body>
</html>
