<?php
include 'config/db.php';
include 'config/twilio.php';
session_start();

// --- Helper to convert phone to E.164 format (India) ---
function to_e164_india($raw) {
    $digits = preg_replace('/\D+/', '', $raw);
    if (preg_match('/^[6-9]\d{9}$/', $digits)) return '+91' . $digits;
    if (preg_match('/^\+\d{8,15}$/', $raw)) return $raw;
    return false;
}

// --- Ensure user is logged in ---
if (!isset($_SESSION['username'])) {
    header("Location: login_register.php");
    exit();
}
$username = $_SESSION['username'];

// --- Get user info from registration table ---
$user_stmt = $con->prepare("SELECT id, username, email, phone FROM registration WHERE username=? LIMIT 1");
if (!$user_stmt) die("Prepare failed (user): " . $con->error);

$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
if ($user_result->num_rows === 0) die("User not found");

$user = $user_result->fetch_assoc();
$user_id    = $user['id'];
$user_name  = $user['username'];
$user_email = $user['email'];
$user_phone = $user['phone'];
$user_stmt->close();

// --- Fetch all cart items ---
$cart_stmt = $con->prepare("
    SELECT c.id AS cart_id, c.product_id, c.quantity, p.pname, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
if (!$cart_stmt) die("Prepare failed (cart): " . $con->error);

$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();
if ($cart_result->num_rows === 0) die("Your cart is empty. Add products first.");

// --- Handle form submission ---
if (isset($_POST['place_order'])) {
    $customer_name    = trim($_POST['customer_name'] ?? '');
    $customer_email   = trim($_POST['customer_email'] ?? '');
    $customer_phone   = trim($_POST['customer_phone'] ?? '');
    $customer_address = trim($_POST['customer_address'] ?? '');
    $payment_method   = trim($_POST['payment_method'] ?? '');
    $googlepay_id     = trim($_POST['googlepay_id'] ?? '');

    if (!$customer_name || !$customer_email || !$customer_phone || !$customer_address || !$payment_method) {
        die("All fields are required.");
    }

    // --- Prepare order insert ---
    $order_stmt = $con->prepare("
        INSERT INTO orders 
        (item_name, item_image, item_price, customer_name, customer_email, customer_phone, customer_address, quantity, payment_method, googlepay_id, payment_status, otp_sent_at, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$order_stmt) die("Prepare failed (orders): " . $con->error);

    $payment_status = ($payment_method === 'GooglePay') ? 'otp_pending' : 'cod_pending';

    while ($row = $cart_result->fetch_assoc()) {
        $item_name   = $row['pname'];
        $item_image  = $row['image'];
        $quantity    = $row['quantity'];
        $total_price = $row['price'] * $quantity;
        $otp_sent_at = null;

        $order_stmt->bind_param(
            "ssdssssissss",
            $item_name,
            $item_image,
            $total_price,
            $customer_name,
            $customer_email,
            $customer_phone,
            $customer_address,
            $quantity,
            $payment_method,
            $googlepay_id,
            $payment_status,
            $otp_sent_at
        );

        if (!$order_stmt->execute()) die("Insert failed: " . $order_stmt->error);
    }
    $order_stmt->close();

    // --- Clear cart ---
    $del_stmt = $con->prepare("DELETE FROM cart WHERE user_id=?");
    $del_stmt->bind_param("i", $user_id);
    $del_stmt->execute();
    $del_stmt->close();

    // --- Redirect based on payment method ---
    if ($payment_method === 'GooglePay') {
        // Redirect to merged OTP verification page for bulk orders
        header("Location: verify_bulk_otp.php?bulk_order=1&customer_id=" . $user_id);
        exit();
    } else {
        echo "<script>alert('Order placed successfully!'); window.location='orders.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buy All Products</title>
<style>
:root {
    --primary-brown:#8D6E63;
    --secondary-brown:#5D4037;
    --light-brown:#D7CCC8;
    --text-dark:#212121;
    --text-light:#FFFFFF;
}
body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#D7CCC8;margin:0;padding:20px;color:var(--text-dark);}
h2{text-align:center;color:var(--primary-brown);margin-bottom:30px;}
.card{max-width:900px;margin:auto;background:#deaa88;padding:25px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);}
.cart-item{display:flex;gap:20px;margin-bottom:20px;background:#fff;padding:15px;border-radius:8px;align-items:center;}
.cart-item img{width:100px;height:100px;object-fit:cover;border-radius:5px;border:1px solid #eee;}
.cart-item-details{flex:1;}
.cart-item-details h4{margin:0;color:var(--secondary-brown);}
.cart-item-details p{margin:5px 0;font-size:14px;}
input[type="text"],input[type="email"],input[type="tel"],textarea,select{width:100%;padding:8px;margin-top:4px;border-radius:6px;border:1px solid #ccc;font-size:15px;box-sizing:border-box;}
textarea{resize:vertical;height:100px;}
button,input[type="submit"]{background-color:var(--secondary-brown);color:var(--text-light);border:none;padding:10px 20px;border-radius:6px;cursor:pointer;margin-top:10px;font-size:15px;transition:background-color 0.3s ease;display:block;margin-left:auto;margin-right:auto;}
button:hover,input[type="submit"]:hover{background-color:#4E342E;}
#upi-field{margin-top:10px;padding:10px;background-color:#f1edea;border-left:4px solid var(--primary-brown);}
label{margin-top:10px;display:block;}
.total-summary{text-align:right;font-size:1.1em;margin-top:15px;font-weight:bold;color:var(--secondary-brown);}
</style>
</head>
<body>
<h2>Buy All Products in Cart</h2>

<div class="card">
    <?php
    // Fetch cart items again for display
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
    while ($row = $cart_result->fetch_assoc()) {
        $total = $row['price'] * $row['quantity'];
        $grand_total += $total;
    ?>
    <div class="cart-item">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
        <div class="cart-item-details">
            <h4><?php echo htmlspecialchars($row['pname']); ?></h4>
            <p>Price per Unit: ₹<?php echo number_format($row['price'],2); ?></p>
            <p>Quantity: <?php echo $row['quantity']; ?></p>
            <p>Total: ₹<?php echo number_format($total,2); ?></p>
        </div>
    </div>
    <?php } ?>
    <p class="total-summary">Grand Total: ₹<?php echo number_format($grand_total,2); ?></p>

    <form method="POST">
        <label>Your Name:</label>
        <input type="text" name="customer_name" value="<?php echo htmlspecialchars($user_name); ?>" required>

        <label>Your Email:</label>
        <input type="email" name="customer_email" value="<?php echo htmlspecialchars($user_email); ?>" required>

        <label>Your Phone No:</label>
        <input type="tel" name="customer_phone" value="<?php echo htmlspecialchars($user_phone); ?>" pattern="[0-9]{10}" maxlength="10" required>

        <label>Address:</label>
        <textarea name="customer_address" required></textarea>

        <label>Payment Method:</label>
        <select name="payment_method" required onchange="toggleUPI(this.value)">
            <option value="">-- Select --</option>
            <option value="Cash on Delivery">Cash on Delivery</option>
            <option value="GooglePay">GooglePay</option>
        </select>

        <div id="upi-field" style="display:none;">
            <label>UPI ID:</label>
            <input type="text" name="googlepay_id" placeholder="Enter your UPI ID">
        </div>

        <button type="submit" name="place_order">Place Order for All Items</button>
    </form>
</div>

<script>
function toggleUPI(value) {
    document.getElementById('upi-field').style.display = value === 'GooglePay' ? 'block' : 'none';
}
</script>
</body>
</html>
