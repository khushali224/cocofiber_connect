<?php
include '../config/db.php';
session_start();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: values_manage.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch existing value
$result = mysqli_query($con, "SELECT * FROM core_values WHERE id = $id");
if (mysqli_num_rows($result) == 0) {
    header("Location: values_manage.php");
    exit();
}

$value = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

    $update = mysqli_query($con, "UPDATE core_values SET title='$title', description='$description' WHERE id=$id");

    if ($update) {
        $_SESSION['msg'] = "Value updated successfully!";
        header("Location: values_manage.php");
        exit();
    } else {
        $error = "Failed to update value!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Core Value</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<div class="container">
<h2>Edit Core Value</h2>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo htmlspecialchars($value['title']); ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="5" required><?php echo htmlspecialchars($value['description']); ?></textarea><br><br>

    <button type="submit">Update</button>
    <a href="values_manage.php" class="btn-back">Cancel</a>
</form>
</div>
</body>
</html>
