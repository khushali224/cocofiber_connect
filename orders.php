<?php
// Include database configuration
include 'config/db.php';
session_start();

// --- Ensure user is logged in ---
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}
$username = $_SESSION['username'];

// --- Get user info from registration table ---
// We need the user's email to fetch orders from the 'orders' table
$user_stmt = $con->prepare("SELECT id, email FROM registration WHERE username=? LIMIT 1");
if (!$user_stmt) die("Prepare failed (user): " . $con->error);

$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
    // Should not happen if login is correct
    session_destroy();
    die("User not found. Please log in again.");
}

$user = $user_result->fetch_assoc();
$user_id = $user['id'];
$user_email = $user['email'];
$user_stmt->close();

// --- Fetch all orders for the user's email, ordered by creation date (newest first) ---
$orders_stmt = $con->prepare("
    SELECT id, item_name, item_image, item_price, quantity, payment_method, payment_status, created_at, googlepay_id
    FROM orders
    WHERE customer_email = ?
    ORDER BY created_at DESC
");
if (!$orders_stmt) die("Prepare failed (orders): " . $con->error);

$orders_stmt->bind_param("s", $user_email);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();

$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Orders</title>
<style>
:root {
    --primary-brown:#8D6E63;
    --secondary-brown:#5D4037;
    --light-brown:#D7CCC8;
    --text-dark:#212121;
    --text-light:#FFFFFF;
    --status-pending: #FF9800;
    --status-received: #4CAF50;
    --status-cod: #2196F3;
}
body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#D7CCC8;margin:0;padding:20px;color:var(--text-dark);}
h2{text-align:center;color:var(--primary-brown);margin-bottom:30px;}
.container{max-width:1100px;margin:auto;background:#deaa88;padding:25px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);}
.order-table{width:100%;border-collapse:collapse;margin-top:20px;}
.order-table th,.order-table td{padding:12px 15px;text-align:left;border-bottom:1px solid #c7a48d;}
.order-table th{background-color:var(--secondary-brown);color:var(--text-light);font-size:14px;text-transform:uppercase;}
.order-table tr:nth-child(even) {background-color: #f7e6dc;}
.order-table img{width:60px;height:60px;object-fit:cover;border-radius:4px;}
.status-tag {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    color: var(--text-light);
}
.status-cod_pending { background-color: var(--status-cod); }
.status-otp_pending { background-color: var(--status-pending); }
.status-payment_received { background-color: var(--status-received); }
.total-summary{text-align:right;font-size:1.3em;margin-top:20px;padding-top:10px;border-top:2px solid var(--secondary-brown);font-weight:bold;color:var(--secondary-brown);}
.no-orders { text-align: center; padding: 50px; color: var(--secondary-brown); font-size: 1.1em; }
.btn-link{
    background-color:var(--secondary-brown);
    color:var(--text-light);
    border:none;
    padding:10px 20px;
    border-radius:6px;
    cursor:pointer;
    margin-top:20px;
    font-size:16px;
    transition:background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
}
.btn-link:hover{background-color:#4E342E;}
</style>
</head>
<body>
<div class="container">
    <h2>Your Purchase History</h2>

    <?php if ($orders_result->num_rows > 0): ?>
    <table class="order-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $orders_result->fetch_assoc()): 
            $total_price = $row['item_price']; // item_price holds the calculated total price for that line item
            $grand_total += $total_price;
            
            // Format status for display
            $status_class = strtolower(str_replace(' ', '_', $row['payment_status']));
            $status_display = ucwords(str_replace('_', ' ', $row['payment_status']));
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                <td><img src="uploads/<?php echo htmlspecialchars($row['item_image']); ?>" alt="<?php echo htmlspecialchars($row['item_name']); ?>"></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>₹<?php echo number_format($total_price, 2); ?></td>
                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                <td><span class="status-tag status-<?php echo $status_class; ?>"><?php echo $status_display; ?></span></td>
                <td><?php echo date("Y-m-d H:i", strtotime($row['created_at'])); ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <p class="total-summary">Total Value of All Orders: ₹<?php echo number_format($grand_total, 2); ?></p>

    <?php else: ?>
        <div class="no-orders">
            <p>You have not placed any orders yet.</p>
        </div>
    <?php endif; ?>

    <div style="text-align: center;">
        <a href="index.php" class="btn-link">Continue Shopping</a>
    </div>
</div>
</body>
</html>