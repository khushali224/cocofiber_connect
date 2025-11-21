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

// ✅ Fetch cart items for this user
$result = mysqli_query($con, "SELECT * FROM cart WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <style>
    /* Global Styles */
* {
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
    background-color: #EFEBE9;
    color: #212121;
}
a { text-decoration: none; color: inherit; }

/* Cart Styles */
.cart-container { max-width: 1000px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 10px; }
.cart-item { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ccc; padding: 10px 0; }
.cart-item img { height: 80px; width: 80px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
.cart-details { flex: 1; display: flex; align-items: center; }
.cart-actions { display: flex; gap: 10px; }
.cart-actions a { padding: 6px 10px; background-color: #8D6E63; color: white; border-radius: 4px; text-decoration: none; }
.cart-actions a:hover { background-color: #5D4037; }
.btn-back, .btn-buyall { display: inline-block; margin-top: 20px; background-color: #5D4037; color: #fff; padding: 10px 16px; border-radius: 5px; text-decoration: none; text-align: center; }
.btn-back:hover, .btn-buyall:hover { background-color: #3E2723; }
  </style>
</head>
<body>

<div class="cart-container">
  <h2>Your Cart Items</h2>

  <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="cart-item">
        <div class="cart-details">
          <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
          <div>
            <h4><?php echo htmlspecialchars($row['pname']); ?></h4>
            <p>Price: ₹<?php echo $row['price']; ?></p>
            <p>Quantity: <?php echo $row['quantity']; ?></p>
          </div>
        </div>
        <div class="cart-actions">
          <a href="remove_cart.php?id=<?php echo $row['id']; ?>">Remove</a>
          <a href="buy.php?id=<?php echo $row['product_id']; ?>">Buy</a>
        </div>
      </div>
    <?php endwhile; ?>

    <div style="text-align: center;">
      <a href="buy_All.php" class="btn-buyall">🛒 Buy All Items</a>
    </div>

  <?php else: ?>
    <p>Your cart is empty.</p>
  <?php endif; ?>

  <div style="text-align: center;">
    <a href="admin_product.php" class="btn-back">← Continue Shopping</a>
  </div>
</div>

</body>
</html>
