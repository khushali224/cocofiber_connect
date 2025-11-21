<?php
include 'config/db.php';
session_start();

// Security check: Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

// 1. Validate incoming data
$cart_item_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$new_quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if ($cart_item_id > 0 && $new_quantity > 0) {
    // 2. Prepare the UPDATE statement to prevent SQL injection
    $stmt = $con->prepare("UPDATE cart SET quantity = ? WHERE id = ?");

    if ($stmt) {
        // 'ii' stands for two integer parameters: quantity and id
        $stmt->bind_param("ii", $new_quantity, $cart_item_id);

        if ($stmt->execute()) {
            // Success: Redirect back to the cart page
            header("Location: cart.php?update=success");
            exit();
        } else {
            // Failure
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database Error: Could not prepare statement.";
    }
} else {
    // Invalid input
    header("Location: cart.php?error=invalid_input");
    exit();
}

// Close the database connection
mysqli_close($con);
?>