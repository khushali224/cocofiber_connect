<?php
include 'config/db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    die("Invalid product.");
}

$username = $_SESSION['username'];

// Get user_id from registration table
$user_query = mysqli_query($con, "SELECT id FROM registration WHERE username = '$username' LIMIT 1");
if (mysqli_num_rows($user_query) == 0) {
    die("User not found.");
}
$user = mysqli_fetch_assoc($user_query);
$user_id = $user['id'];

// Check if already in wishlist
$check = mysqli_query($con, "SELECT * FROM wishlist WHERE product_id = $product_id AND user_id = $user_id");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Product already in wishlist'); window.location='wishlist.php';</script>";
    exit();
}

// Get product data
$product_query = mysqli_query($con, "SELECT * FROM products WHERE id = $product_id");
if (mysqli_num_rows($product_query) == 0) {
    die("Product not found.");
}
$product = mysqli_fetch_assoc($product_query);

// Insert into wishlist
$insert = "INSERT INTO wishlist (user_id, product_id, pname, image, price)
           VALUES ($user_id, $product_id, '{$product['pname']}', '{$product['image']}', '{$product['price']}')";

if (mysqli_query($con, $insert)) {
    echo "<script>alert('Added to wishlist'); window.location='wishlist.php';</script>";
} else {
    echo "Error: " . mysqli_error($con);
}
?>
