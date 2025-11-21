
<?php
include 'config/db.php';
include 'config/twilio.php';
session_start();

// --- Helpers ---
function to_e164_india($raw) {
    $digits = preg_replace('/\D+/', '', $raw);
    if (preg_match('/^[6-9]\d{9}$/', $digits)) {
        return '+91' . $digits;
    }
    if (preg_match('/^\+\d{8,15}$/', $raw)) return $raw;
    return false;
}

$product_id = $_GET['id'] ?? null;
if (!$product_id || !ctype_digit($product_id)) {
    die("Invalid product");
}

// Fetch product safely
$stmt = mysqli_prepare($con, "SELECT id, pname, image, price FROM products WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$product) {
    die("Product not found");
}

if (isset($_POST['place_order'])) {
    $customer_name    = trim($_POST['customer_name'] ?? '');
    $customer_email   = trim($_POST['customer_email'] ?? '');
    $customer_phone   = trim($_POST['customer_phone'] ?? '');
    $customer_address = trim($_POST['customer_address'] ?? '');
    $quantity         = max(1, (int)($_POST['quantity'] ?? 1));
    $payment_method   = trim($_POST['payment_method'] ?? '');
    $googlepay_id     = trim($_POST['googlepay_id'] ?? '');

    if ($quantity > 10) {
        echo "<script>alert('Out of Stock! You can only buy up to 10 units at once.'); window.history.back();</script>";
        exit;
    }

    if (!$customer_name || !$customer_email || !$customer_phone || !$customer_address || !$payment_method) {
        die("All fields are required.");
    }

    $item_name   = $product['pname'];
    $item_image  = $product['image'];
    $unit_price  = (float)$product['price'];
    $total_price = $unit_price * $quantity;

    $payment_status = ($payment_method === 'GooglePay') ? 'otp_pending' : 'cod_pending';

    $stmt = mysqli_prepare($con, "INSERT INTO orders 
        (item_name, item_image, item_price, customer_name, customer_email, customer_phone, customer_address, quantity, payment_method, googlepay_id, payment_status, otp_sent_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("SQL Error: " . mysqli_error($con));
    }

    $now = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param(
        $stmt,
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
        $now
    );

    if (!mysqli_stmt_execute($stmt)) {
        die("DB Error: " . mysqli_error($con));
    }

    $order_id = mysqli_insert_id($con);
    mysqli_stmt_close($stmt);

    // If GooglePay, send OTP
    if ($payment_method === 'GooglePay') {
        $phoneE164 = to_e164_india($customer_phone);
        if (!$phoneE164) {
            echo "<script>alert('Invalid mobile number. Please enter a valid 10-digit Indian mobile.'); window.history.back();</script>";
            exit;
        }

        $otpRes = twilio_send_otp($phoneE164);
        if (!$otpRes['ok']) {
            $err = substr($otpRes['error'], 0, 240);
            $stmt2 = mysqli_prepare($con, "UPDATE orders SET otp_last_error = CONCAT(IFNULL(otp_last_error,''),' | ', ?) WHERE id = ?");
            mysqli_stmt_bind_param($stmt2, "si", $err, $order_id);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);

            echo "<script>alert('Could not send OTP: ".htmlspecialchars($err)."'); window.history.back();</script>";
            exit;
        }

        header("Location: verify_otp.php?order_id=" . $order_id);
        exit;
    }

    // COD orders → success immediately
    echo "<script>alert('Order placed successfully!'); window.location='view_buy_products.php?id=$order_id';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Buy Product</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    :root { --primary-brown:#8D6E63; --secondary-brown:#5D4037; --light-brown:#D7CCC8; --text-dark:#212121; --text-light:#FFFFFF; }
    body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;background-color:#D7CCC8;margin:0;padding:20px;color:var(--text-dark);}
    h2{text-align:center;color:var(--primary-brown);margin-bottom:30px;}
    .card{max-width:800px;margin:auto;background:#deaa88;padding:25px;border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,0.1);display:flex;gap:20px;flex-wrap:wrap;justify-content:center;}
    .card img{max-width:300px;height:auto;border-radius:8px;border:2px solid var(--light-brown);}
    .card-body{flex:1;min-width:300px;}
    .card-body h3{color:var(--secondary-brown);margin-bottom:10px;}
    .card-body p{font-size:16px;margin-bottom:15px;}
    input[type="text"],input[type="email"],input[type="tel"],input[type="number"],textarea,select{width:100%;padding:8px;margin-top:4px;border-radius:6px;border:1px solid #ccc;font-size:15px;box-sizing:border-box;}
    textarea{resize:vertical;height:100px;}
    button,input[type="submit"]{background-color:var(--secondary-brown);color:var(--text-light);border:none;padding:10px 20px;border-radius:6px;cursor:pointer;margin-top:10px;font-size:15px;transition:background-color 0.3s ease;display:block;margin-left:auto;margin-right:auto;}
    button:hover,input[type="submit"]:hover{background-color:#4E342E;}
    #upi-field{margin-top:10px;padding:10px;background-color:#f1edea;border-left:4px solid var(--primary-brown);}
    label{margin-top:10px; display:block;}
  </style>
</head>
<body>

<h2>Order Now</h2>

<div class="card">
  <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
  <div class="card-body">
    <h3><?php echo htmlspecialchars($product['pname']); ?></h3>
    <p>Price per Unit: ₹<span id="unit-price"><?php echo number_format((float)$product['price'], 2); ?></span></p>

    <form method="POST">
      <label>Your Name:</label>
      <input type="text" name="customer_name" required>

      <label>Your Email:</label>
      <input type="email" name="customer_email" required>

      <label>Your Phone No:</label>
      <input type="tel" name="customer_phone" pattern="[0-9]{10}" maxlength="10" required placeholder="Enter 10-digit mobile number">

      <label>Address:</label>
      <textarea name="customer_address" required></textarea>

      <label>Quantity:</label>
      <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" required oninput="updateTotal()">

      <p><strong>Total Price: ₹<span id="total-price"><?php echo number_format((float)$product['price'], 2); ?></span></strong></p>

      <label>Payment Method:</label>
      <select name="payment_method" required onchange="toggleUPI(this.value)">
        <option value="">-- Select --</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
        <option value="GooglePay">GooglePay</option>
      </select>

      <!-- GooglePay UPI Field -->
      <div id="upi-field" style="display:none;">
        <label>UPI ID:</label>
        <input type="text" name="googlepay_id" placeholder="Enter your UPI ID">
      </div>

      <button type="submit" name="place_order">Place Order</button>
    </form>
  </div>
</div>

<script>
function toggleUPI(value) {
    document.getElementById('upi-field').style.display = value === 'GooglePay' ? 'block' : 'none';
}

function updateTotal() {
  const unitPrice = parseFloat(document.getElementById('unit-price').textContent.replace(/,/g,''));
  let quantity = parseInt(document.getElementById('quantity').value) || 1;

  if (quantity > 10) {
    alert("Out of Stock! You can only order up to 10 units.");
    quantity = 10;
    document.getElementById('quantity').value = 10;
  }

  const total = unitPrice * quantity;
  document.getElementById('total-price').textContent = total.toFixed(2);
}
</script>
</body>
</html>
```
