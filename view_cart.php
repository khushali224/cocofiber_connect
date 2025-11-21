<?php
include 'config/db.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}

$username = $_SESSION['username'];

// Get user ID
$user_stmt = $con->prepare("SELECT id FROM registration WHERE username=? LIMIT 1");
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
if ($user_result->num_rows === 0) die("User not found");
$user = $user_result->fetch_assoc();
$user_id = $user['id'];
$user_stmt->close();

// Fetch cart items
$cart_stmt = $con->prepare("
    SELECT c.id AS cart_id, c.product_id, c.quantity, p.pname, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Cart</title>
<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin:0; padding:20px; color:#333; }
.cart-container { max-width: 1000px; margin: 0 auto; background:#fff; padding:30px; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1);}
h2 { text-align:center; color:#5D4037; margin-bottom:30px;}
table { width: 100%; border-collapse: collapse; margin-bottom:30px;}
th, td { padding:15px; border:1px solid #ddd; text-align:center; vertical-align: middle;}
th { background-color:#8b5e3c; color:white; text-transform:uppercase; font-size:0.9em; }
tr:nth-child(even) { background-color:#f9f9f9; }
img { height: 80px; width: 80px; object-fit:cover; border-radius:5px; border:1px solid #eee; }
a.remove-link { text-decoration:none; color:#d9534f; font-weight:bold; transition: color 0.2s; }
a.remove-link:hover { color:#c9302c; }
select.quantity-select { padding:8px; border:1px solid #ccc; border-radius:4px; width:70px; cursor:pointer; text-align:center; }
.grand-total-row td { background-color:#f0e6da; font-size:1.2em; font-weight:bold; color:#5D4037; border-top:3px solid #8b5e3c; }
.cart-actions { display:flex; justify-content:space-between; align-items:center; padding:10px 0; }
.cart-actions a { display:inline-block; padding:12px 25px; border-radius:5px; text-decoration:none; font-size:1.1em; font-weight:bold; transition:background-color 0.2s; text-align:center; }
.continue-btn { background-color:#6c757d; color:white; }
.continue-btn:hover { background-color:#5a6268; }
.buy-all-btn { background-color:#8b5e3c; color:white; }
.buy-all-btn:hover { background-color:#800000; }
</style>
</head>
<body>
<div class="cart-container">
<h2>My Shopping Cart</h2>

<table id="cart-table">
<tr>
    <th>Image</th>
    <th>Product</th>
    <th>Price (per unit)</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php
if ($cart_result && $cart_result->num_rows > 0) {
    while ($row = $cart_result->fetch_assoc()) {
        $item_id = $row['cart_id'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $total = $price * $quantity;
        $grand_total += $total;
?>
<tr data-price="<?php echo $price; ?>" data-id="<?php echo $item_id; ?>" class="cart-item">
    <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>"></td>
    <td><?php echo htmlspecialchars($row['pname']); ?></td>
    <td class="item-price">₹<?php echo number_format($price, 2); ?></td>
    <td>
        <select class="quantity-select" onchange="updateCartItem(this.value, <?php echo $item_id; ?>)">
            <?php for($i=1;$i<=10;$i++): ?>
                <option value="<?php echo $i; ?>" <?php echo ($i==$quantity)?'selected':''; ?>>
                    <?php echo $i; ?>
                </option>
            <?php endfor; ?>
        </select>
    </td>
    <td class="item-total" data-total-value="<?php echo $total; ?>">₹<?php echo number_format($total,2); ?></td>
    <td>
        <a href="remove_cart.php?id=<?php echo $item_id; ?>" class="remove-link" onclick="return confirm('Remove this item from your cart?');">Remove</a>
    </td>
</tr>
<?php
    }
} else {
    echo '<tr><td colspan="6" style="padding:30px;font-size:1.1em;color:#6c757d;">Your cart is empty. Add products now!</td></tr>';
}
?>

<tr class="grand-total-row">
    <td colspan="4"><strong>Grand Total</strong></td>
    <td colspan="2"><strong id="grand-total-display">₹<?php echo number_format($grand_total,2); ?></strong></td>
</tr>
</table>

<div class="cart-actions">
    <a href="admin_product.php" class="continue-btn">Continue Shopping</a>
    <?php if($grand_total>0): ?>
        <a href="buy_All.php" class="buy-all-btn" id="buy-all-btn-link">Proceed to Buy All (₹<?php echo number_format($grand_total,2); ?>)</a>
    <?php else: ?>
        <a href="admin_product.php" class="buy-all-btn" style="background:#6c757d; cursor:not-allowed;">No items to purchase</a>
    <?php endif; ?>
</div>

</div>

<script>
function calculateGrandTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.cart-item').forEach(row=>{
        grandTotal += parseFloat(row.querySelector('.item-total').getAttribute('data-total-value'));
    });
    const formattedTotal = '₹' + grandTotal.toFixed(2);
    document.getElementById('grand-total-display').innerText = formattedTotal;
    const buyBtn = document.getElementById('buy-all-btn-link');
    if(buyBtn) buyBtn.innerText = 'Proceed to Buy All (' + formattedTotal + ')';
}

function updateCartItem(newQty, itemId) {
    const row = document.querySelector(`.cart-item[data-id="${itemId}"]`);
    const price = parseFloat(row.getAttribute('data-price'));
    const newTotal = price * newQty;
    row.querySelector('.item-total').innerText = '₹' + newTotal.toFixed(2);
    row.querySelector('.item-total').setAttribute('data-total-value', newTotal);
    calculateGrandTotal();

    // Send AJAX to update server
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_quantity.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(`id=${itemId}&quantity=${newQty}`);
}

document.addEventListener('DOMContentLoaded', calculateGrandTotal);
</script>
</body>
</html>
