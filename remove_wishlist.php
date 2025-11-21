<?php
include 'config/db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    mysqli_query($con, "DELETE FROM wishlist WHERE id = $id");
}

header("Location: wishlist.php");
exit();
?>
