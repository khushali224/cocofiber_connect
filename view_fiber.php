<?php
include 'header.php';
include 'config/db.php';
session_start();

$username = $_SESSION['submitted_by'] ?? '';

if (!$username) {
    echo "<script>alert('No recent submission found.'); window.location.href = 'seller.php';</script>";
    exit;
}

// Fetch listings by this user
$result = mysqli_query($con, "SELECT * FROM fiber WHERE username = '$username' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fiber Listings</title>
  <link rel="stylesheet" href="css/main.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f3e5ab;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #4e342e;
    }

    .listing-card {
      background-color: #fff3e0;
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 900px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .listing-card img {
      float: right;
      width: 150px;
      height: 150px;
      object-fit: cover;
      margin-left: 20px;
      border-radius: 8px;
    }

    .back-btn {
      display: inline-block;
      margin: 30px auto;
      background: #795548;
      color: #fff;
      padding: 12px 24px;
      border-radius: 6px;
      text-decoration: none;
      text-align: center;
      display: block;
      width: 180px;
    }

    .back-btn:hover {
      background-color: #5d4037;
    }
  </style>
</head>
<body>

<h2>Your Submitted Fiber Listings</h2>

<?php
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='listing-card'>
                <img src='{$row['image']}' alt='Fiber Image'>
                <p><strong>Name:</strong> {$row['username']}</p>
                <p><strong>Email:</strong> {$row['email']}</p>
                <p><strong>Phone:</strong> {$row['phone_no']}</p>
                <p><strong>Fiber Type:</strong> {$row['fiber_type']}</p>
                <p><strong>Quantity:</strong> {$row['quantity_kg']} kg</p>
                <p><strong>Price:</strong> $ {$row['price_per_kg']} /kg</p>
                <p><strong>Location:</strong> {$row['location']}</p>
                <p><strong>Description:</strong> {$row['description']}</p>
            </div>";
    }
} else {
    echo "<p style='text-align:center;'>No listings found for $username.</p>";
}
?>

<a href="seller.php" class="back-btn">Back to Form</a>

</body>
</html>
