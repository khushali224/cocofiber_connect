<?php
include 'config/db.php';
session_start();

// ✅ Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$username = $_SESSION['username'];

// ✅ Get the user_id from registration table
$user_query = mysqli_query($con, "SELECT id FROM registration WHERE username = '$username' LIMIT 1");
if (!$user_query || mysqli_num_rows($user_query) == 0) {
    die("User not found.");
}
$user = mysqli_fetch_assoc($user_query);
$user_id = $user['id'];

// ✅ Fetch wishlist items for this logged-in user
$stmt = mysqli_prepare($con, "SELECT * FROM wishlist WHERE user_id = ?");
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($con));
}
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Wishlist</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f4f2ef; }
    .wishlist-container { max-width: 1000px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0,0,0,0.1); }
    h2 { text-align: center; margin-bottom: 20px; color: #5D4037; }
    .wishlist-item { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; padding: 12px 0; }
    .wishlist-item img { height: 80px; width: 80px; object-fit: cover; border-radius: 8px; margin-right: 20px; }
    .wishlist-details { flex: 1; display: flex; align-items: center; }
    .wishlist-details h4 { margin: 0; font-size: 16px; color: #3E2723; }
    .wishlist-details p { margin: 4px 0 0; color: #555; }
    .wishlist-actions { display: flex; gap: 10px; }
    .wishlist-actions a { padding: 6px 12px; background-color: #8D6E63; color: white; border-radius: 4px; text-decoration: none; font-size: 14px; }
    .wishlist-actions a:hover { background-color: #5D4037; }
    .btn-back { display: inline-block; margin-top: 20px; background-color: #5D4037; color: #fff; padding: 10px 16px; border-radius: 5px; text-decoration: none; text-align: center; }
    .btn-back:hover { background-color: #3E2723; }
    .empty-msg { text-align: center; color: #777; font-size: 16px; margin: 30px 0; }
  </style>
</head>
<body>

<div class="wishlist-container">
  <h2>Your Wishlist</h2>
  <?php if ($result->num_rows > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="wishlist-item">
        <div class="wishlist-details">
          <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
          <div>
            <h4><?php echo htmlspecialchars($row['pname']); ?></h4>
            <p>Price: ₹<?php echo htmlspecialchars($row['price']); ?></p>
          </div>
        </div>
        <div class="wishlist-actions">
          <a href="remove_wishlist.php?id=<?php echo $row['id']; ?>">Remove</a>
          <a href="add_to_cart.php?id=<?php echo $row['product_id']; ?>">Add to Cart</a>
          <a href="buy.php?id=<?php echo $row['product_id']; ?>">Buy</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="empty-msg">Your wishlist is empty.</p>
  <?php endif; ?>
  
  <div style="text-align: center;">
    <a href="admin_product.php" class="btn-back">← Continue Shopping</a>
  </div>
</div>

</body>
</html>
