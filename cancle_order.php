<?php
include 'config/db.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

// Check if POST request and order_id is set
if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $username = $_SESSION['username'];

    // Verify that the order belongs to the logged-in user
    $checkQuery = "SELECT id FROM orders WHERE id = ? AND customer_name = ?";
    if ($stmt = $con->prepare($checkQuery)) {
        $stmt->bind_param("is", $order_id, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Delete the order permanently
            $deleteQuery = "DELETE FROM orders WHERE id = ? AND customer_name = ?";
            if ($delStmt = $con->prepare($deleteQuery)) {
                $delStmt->bind_param("is", $order_id, $username);
                $delStmt->execute();
                $delStmt->close();

                $_SESSION['msg'] = "✅ Order cancelled successfully!";
            } else {
                $_SESSION['msg'] = "❌ Failed to prepare delete statement!";
            }
        } else {
            $_SESSION['msg'] = "❌ Invalid order or not authorized!";
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "❌ Failed to prepare select statement!";
    }
} else {
    $_SESSION['msg'] = "❌ No order selected!";
}

// Redirect back to allbuy.php
header("Location: allbuy.php");
exit();
?>
