<?php
include 'config/db.php';
session_start();

// Check login
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch orders for this user (match by email or username if needed)
$query = "SELECT id, item_name, item_image, item_price, quantity, created_at 
          FROM orders 
          WHERE customer_name = ? 
          ORDER BY created_at DESC";
$stmt = $con->prepare($query);
if (!$stmt) {
    die("SQL Error: " . $con->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Orders</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f8f8f8; }
    table { width: 95%; margin: 20px auto; border-collapse: collapse; background: #fff; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
    th, td { padding: 12px; border: 1px solid #ccc; text-align: center; }
    img { height: 60px; border-radius: 6px; }
    th { background-color: #8b5e3c; color: white; }
    h2 { text-align:center; margin-top:20px; }
    .cancel-btn {
        background-color: #c0392b;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .cancel-btn:hover {
        background-color: #922b21;
    }
    .msg {
        text-align: center;
        margin: 10px;
        font-weight: bold;
        color: green;
    }
    
    .btn-back, .btn-buyall {
      display: inline-block;
      margin-top: 20px;
      background-color: #5D4037;
      color: #fff;
      padding: 10px 16px;
      border-radius: 5px;
      text-decoration: none;
      text-align: center;
    }

    .btn-back:hover, .btn-buyall:hover {
      background-color: #3E2723;
    }
  </style>
</head>
<body>

  <h2>Your Orders</h2>

  <?php if (isset($_SESSION['msg'])) { ?>
      <div class="msg"><?php echo htmlspecialchars($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
  <?php } ?>

  <table>
    <tr>
      <th>Image</th>
      <th>Product</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Order Date</th>
      <th>Action</th>
    </tr>

    <?php if ($result->num_rows > 0) { 
      while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><img src="uploads/<?php echo htmlspecialchars($row['item_image']); ?>" alt=""></td>
          <td><?php echo htmlspecialchars($row['item_name']); ?></td>
          <td>₹<?php echo htmlspecialchars($row['item_price']); ?></td>
          <td><?php echo htmlspecialchars($row['quantity']); ?></td>
          <td><?php echo date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
          <td>
            <form method="POST" action="cancle_order.php" onsubmit="return confirm('Are you sure you want to cancel this order?');">
              <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
              <button type="submit" class="cancel-btn">Cancel</button>
            </form>
          </td>
        </tr>
    <?php } } else { ?>
        <tr><td colspan="6">You have not purchased anything yet.</td></tr>
    <?php } ?>
  </table>
<div style="text-align: center;">
    <a href="admin_product.php" class="btn-back">← Continue to Shopping</a>
  </div>
</body>
</html>
