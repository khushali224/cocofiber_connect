<?php
include '../config/db.php';
session_start();

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: values_manage.php");
    exit();
}

$id = intval($_GET['id']);

// Delete the value
$delete = mysqli_query($con, "DELETE FROM core_values WHERE id = $id");

if ($delete) {
    $_SESSION['msg'] = "Value deleted successfully!";
} else {
    $_SESSION['msg'] = "Failed to delete value!";
}

header("Location:values_manage.php");
exit();
?>
