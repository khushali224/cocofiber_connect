<?php
session_start();
include 'config/db.php';

// Helper: escape output safely
function h($str) { return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }

// 1) Validate order id
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($order_id <= 0) {
    echo "<div style='text-align:center; padding:20px; color:red;'>❌ Invalid order ID.</div>";
    exit;
}

// 2) Fetch order (prepared statement)
$order_sql = "
    SELECT 
        id,
        item_name,
        item_image,
        item_price,
        customer_name,
        customer_email,
        customer_phone,
        customer_address,
        quantity,
        payment_method,
        googlepay_id,  /* ⬅️ FIX: Changed from 'upi_id' to 'googlepay_id' 
                            to match usage in the HTML section below */
        payment_status,
        created_at
    FROM orders
    WHERE id = ?
    LIMIT 1
";

if (!$order_stmt = mysqli_prepare($con, $order_sql)) {
    // This will now correctly report the error if 'googlepay_id' is also missing
    echo "<div style='color:red; text-align:center; padding:20px;'>❌ Database Error (prepare order): " . h(mysqli_error($con)) . "</div>";
    exit;
}

mysqli_stmt_bind_param($order_stmt, "i", $order_id);
mysqli_stmt_execute($order_stmt);
$order_result = mysqli_stmt_get_result($order_stmt);

if (!$order_result || mysqli_num_rows($order_result) === 0) {
    echo "<div style='text-align:center; padding:20px; color:red;'>❌ Order not found.</div>";
    exit;
}
$order = mysqli_fetch_assoc($order_result);
mysqli_stmt_close($order_stmt);

// 3) Assign product fields from snapshot in order
$product_name  = $order['item_name'];
$product_image = $order['item_image'];

// 4) Use created_at as order date
$display_date = $order['created_at'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #D7CCC8;
      padding: 30px;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #5D4037;
      margin-bottom: 20px;
    }
    .order-img {
      text-align: center;
      margin-bottom: 20px;
    }
    .order-img img {
      max-width: 250px;
      border-radius: 10px;
      border: 1px solid #ccc;
    }
    .details p {
      font-size: 16px;
      margin: 6px 0;
    }
    .details strong {
      color: #4E342E;
    }
    .btn-back {
      display: inline-block;
      margin-top: 20px;
      background-color: #5D4037;
      color: #fff;
      padding: 10px 16px;
      border-radius: 5px;
      text-decoration: none;
      text-align: center;
    }
    .btn-back:hover {
      background-color: #3E2723;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>✅ Order Placed Successfully!</h2>

  <div class="order-img">
    <img src="uploads/<?php echo h($product_image); ?>" alt="Product Image">
  </div>

  <div class="details">
    <p><strong>Order ID:</strong> <?php echo (int)$order['id']; ?></p>
    <p><strong>Product Name:</strong> <?php echo h($product_name); ?></p>
    <p><strong>Total Price:</strong> ₹<?php echo number_format((float)$order['item_price'], 2); ?></p>
    <p><strong>Quantity:</strong> <?php echo (int)$order['quantity']; ?></p>
    <p><strong>Payment Method:</strong> <?php echo h($order['payment_method']); ?></p>
    <p><strong>Payment Status:</strong> <?php echo h($order['payment_status']); ?></p>

    <?php if ($order['payment_method'] === 'UPI' && !empty($order['googlepay_id'])): ?>
      <p><strong>UPI ID:</strong> <?php echo h($order['googlepay_id']); ?></p>
    <?php endif; ?>

    <hr>

    <p><strong>Customer Name:</strong> <?php echo h($order['customer_name']); ?></p>
    <p><strong>Email:</strong> <?php echo h($order['customer_email']); ?></p>
    <p><strong>Phone:</strong> <?php echo h($order['customer_phone']); ?></p>
    <p><strong>Address:</strong> <?php echo nl2br(h($order['customer_address'])); ?></p>
    <p><strong>Order Date:</strong> <?php echo h($display_date); ?></p>
  </div>

  <div style="text-align: center;">
    <a href="admin_product.php" class="btn-back">← Continue  Shopping</a>
  </div>
</div>

</body>
</html>