<?php
include 'config/db.php';
session_start();

// ✅ Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$username = $_SESSION['username'];

// ✅ Get user_id from registration table
$user_query = mysqli_query($con, "SELECT id FROM registration WHERE username = '$username' LIMIT 1");
if (!$user_query || mysqli_num_rows($user_query) == 0) {
    die("User not found.");
}
$user = mysqli_fetch_assoc($user_query);
$user_id = $user['id'];

// ✅ Get cart item ID
$id = $_GET['id'] ?? null;

if ($id) {
    // Delete the cart item only if it belongs to the logged-in user
    $stmt = mysqli_prepare($con, "DELETE FROM cart WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Redirect back to cart page
header("Location: cart.php");
exit();
?>
