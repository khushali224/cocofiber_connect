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

// ✅ Get product ID
$product_id = $_GET['id'] ?? null;
if (!$product_id) {
    die("Invalid product.");
}

// ✅ Check if product already in cart for this user
$check = mysqli_query($con, "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('Product already in cart'); window.location='cart.php';</script>";
    exit();
}

// ✅ Get product details
$product_result = mysqli_query($con, "SELECT * FROM products WHERE id = $product_id");
if (!$product_result || mysqli_num_rows($product_result) == 0) {
    die("Product not found.");
}
$product = mysqli_fetch_assoc($product_result);

// ✅ Insert into cart
$insert = "INSERT INTO cart (user_id, product_id, pname, image, price, quantity)
           VALUES ($user_id, $product_id, '{$product['pname']}', '{$product['image']}', '{$product['price']}', 1)";

if (mysqli_query($con, $insert)) {
    echo "<script>alert('Added to cart'); window.location='view_cart.php';</script>";
} else {
    echo "Error: " . mysqli_error($con);
}
?>
