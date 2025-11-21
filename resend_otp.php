<?php
include 'config/db.php';
include 'config/twilio.php';
session_start();

$order_id = $_GET['order_id'] ?? null;
if (!$order_id || !ctype_digit($order_id)) die("Invalid request");

$stmt = mysqli_prepare($con, "SELECT id, customer_phone, payment_status FROM orders WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

if (!$order) die("Order not found");
if ($order['payment_status'] !== 'otp_pending') {
    echo "<script>alert('This order is not waiting for OTP.'); window.location='view_buy_products.php?id=$order_id';</script>";
    exit;
}

$phoneE164 = preg_match('/^\+/', $order['customer_phone'])
    ? $order['customer_phone']
    : '+91' . preg_replace('/\D+/', '', $order['customer_phone']);

$send = twilio_send_otp($phoneE164);
if ($send['ok']) {
    $_SESSION['otp_sent_for'] = $order_id;
    echo "<script>alert('📲 OTP resent successfully!'); window.location='verify_otp.php?order_id=$order_id';</script>";
} else {
    echo "<script>alert('❌ Failed to resend OTP: " . addslashes($send['error']) . "'); window.location='verify_otp.php?order_id=$order_id';</script>";
}
