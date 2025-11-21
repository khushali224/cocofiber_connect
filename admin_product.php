<?php
include 'header.php';
include 'config/db.php';
session_start();

// Input values
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($con, $_GET['category']) : '';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';

// Filter logic
$filters = [];

if ($search) {
  $filters[] = "(pname LIKE '%$search%' OR category_name LIKE '%$search%')";
}
if ($category) {
  $filters[] = "category_name = '$category'";
}
if ($price_range) {
  list($min_price, $max_price) = explode('-', $price_range);
  $filters[] = "price BETWEEN $min_price AND $max_price";
}

$search_query = !empty($filters) ? "WHERE " . implode(" AND ", $filters) : '';
$query = "SELECT * FROM products $search_query";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - View Coconut Fiber Products</title>
  
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
:root {
  --primary-brown: #8D6E63;
  --secondary-brown: #5D4037;
  --light-brown: #D7CCC8;
  --text-dark: #212121;
  --text-light: #FFFFFF;
  --error-red: #c0392b;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f8f5f2;
  margin: 0;
  padding: 20px;
  color: var(--text-dark);
}

h2 {
  text-align: center;
  color: var(--primary-brown);
  margin-bottom: 30px;
}

.card {
  max-width: 800px;
  margin: auto;
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  justify-content: center;
}

.card img {
  max-width: 300px;
  height: auto;
  border-radius: 8px;
  border: 2px solid var(--light-brown);
}

.card-body {
  flex: 1;
  min-width: 300px;
}

.card-body h3 {
  color: var(--secondary-brown);
  margin-bottom: 10px;
}

.card-body p {
  font-size: 16px;
  margin-bottom: 15px;
}

input[type="text"],
input[type="email"],
input[type="tel"],
input[type="number"],
textarea,
select {
  width: 100%;
  padding: 8px;
  margin-top: 4px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 15px;
  box-sizing: border-box;
}

textarea {
  resize: vertical;
  height: 80px;
}

button,
input[type="button"],
input[type="submit"] {
  background-color: var(--secondary-brown);
  color: var(--text-light);
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 10px;
  font-size: 15px;
  transition: background-color 0.3s ease;
}

button:hover,
input[type="button"]:hover,
input[type="submit"]:hover {
  background-color: var(--secondary-brown);
}

#upi-field,
#otp-section {
  margin-top: 10px;
  padding: 10px;
  background-color: #f1edea;
  border-left: 4px solid var(--primary-brown);
}
.nav-tabs {
  display: flex;
  justify-content: center;
  background-color: #5D4037;
  padding: 10px 0;
  margin-bottom: 20px;
}
.nav-tabs a {
  color: #fff;
  text-decoration: none;
  padding: 10px 20px;
  margin: 0 10px;
  font-weight: bold;
  border-radius: 5px;
  background-color: #8D6E63;
  transition: background-color 0.3s ease;
}
.nav-tabs a:hover {
  background-color: #4E342E;
}
    .top-nav, .header-bar, .tab-nav, .search-bar {
      font-family: Arial, sans-serif;
    }
    .top-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #8b5e3c;
      color: white;
      padding: 10px 20px;
    }
    .top-nav .logo {
      font-size: 22px;
      font-weight: bold;
    }
    .nav-icons a {
      color: white;
      text-decoration: none;
      margin-right: 200px;
      font-size: 18px;
    }
    .search-bar {
      text-align: center;
      margin: 20px 0;
    }
    .search-bar input[type="text"],
    .search-bar select {
      padding: 8px;
      margin: 5px;
      width: 200px;
    }
    .search-bar input[type="submit"] {
      padding: 8px 14px;
      background-color: #8b5e3c;
      color: white;
      border: none;
      cursor: pointer;
    }
    h2 {
      text-align: center;
      margin-top: 20px;
    }
    .product-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      padding: 20px;
    }
    .card {
      width: 300px;
      border: 1px solid #ccc;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      background: #D7CCC8;
    }
    .card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
    }
    .card-body {
      padding: 10px;
    }
    .product-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
    }
    .desc {
      font-size: 14px;
      margin-bottom: 8px;
    }
    .price {
      color: green;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .btn-group a {
      display: inline-block;
      padding: 6px 12px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
    }
    .btn-buy {
      background-color: #800000;
      color: white;
    }
    .btn-list {
      background-color: #deaa88;
      color: white;
    }
    .btn-card {
      background-color: #965a3e;
      color: white;
    }
    .btn-buy:hover, .btn-card:hover, .btn-list:hover {
      opacity: 0.9;
    }
    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background-color: #dba986;
      flex-wrap: wrap;
    }
    .header-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #5a362a;
      flex: 1 100%;
      text-align: center;
      margin-bottom: 10px;
    }
    .icon-links {
      display: flex;
      gap: 20px;
      margin-left: auto;
    }
    .icon-links a {
      color: white;
      text-decoration: none;
      font-size: 1.2rem;
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .no-products {
      text-align: center;
      font-size: 18px;
      color: red;
    }
    .tab-nav {
      display: flex;
      justify-content: center;
      border-bottom: 1px solid #ccc;
      margin-bottom: 20px;
    }
    .tab-nav a {
      padding: 12px 20px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
      position: relative;
      margin: 0 15px;
    }
    .tab-nav a.active {
      color: #800000;
    }
    .tab-nav a.active::after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 0;
      right: 0;
      height: 3px;
      background-color: #800000;
      border-radius: 2px;
    }
  </style>
</head>
<body>

<div class="header-bar">
  <h1 class="header-title">Coconut Fiber Products</h1>
  <div class="icon-links">
    <a href="wishlist.php"><i class="bx bx-heart"></i> Wishlist</a>
    <a href="view_cart.php"><i class="bx bx-cart"></i> Cart</a>
    <a href="allbuy.php"><i class="bx bx-shopping-bag"></i> All Order</a>
  </div>
</div>

<!-- Sub Navigation Tabs -->
<div class="tab-nav">
  <a href="seller.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'seller.php' ? 'active' : ''; ?>">Sell Fiber</a>
  <a href="admin_product.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin_product.php' ? 'active' : ''; ?>">Purchase Products</a>
</div>

<!-- Filter and Search Bar -->
<div class="search-bar">
  <form method="GET" action="">
    <input type="text" name="search" placeholder="Search by name or category" value="<?php echo htmlspecialchars($search); ?>">

    <!-- Category Filter -->
    <select name="category">
      <option value="">All Categories</option>
      <?php
      $category_query = mysqli_query($con, "SELECT DISTINCT category_name FROM products");
      while ($cat = mysqli_fetch_assoc($category_query)) {
        $selected = ($category == $cat['category_name']) ? 'selected' : '';
        echo "<option value='{$cat['category_name']}' $selected>{$cat['category_name']}</option>";
      }
      ?>
    </select>

    <!-- Price Filter -->
    <select name="price_range">
      <option value="">All Prices</option>
      <option value="0-50" <?php if($price_range == '0-50') echo 'selected'; ?>>₹0 - ₹50</option>
      <option value="50-100" <?php if($price_range == '50-100') echo 'selected'; ?>>₹50 - ₹100</option>
      <option value="100-200" <?php if($price_range == '100-200') echo 'selected'; ?>>₹100 - ₹200</option>
   <option value="200-250" <?php if($price_range == '200-250') echo 'selected'; ?>>₹200 - ₹250</option>
    </select>

    <input type="submit" value="Filter">
  </form>
</div>

<!-- Product Grid -->
<div class="product-grid">
  <?php if (mysqli_num_rows($result) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="card">
        <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>">
        <div class="card-body">
          <div class="product-title">
            <?php echo htmlspecialchars($row['pname']); ?>
            <span class="rating">★ 4.5</span>
          </div>
          <div class="desc"><?php echo htmlspecialchars($row['description']); ?></div>
          <div class="price">₹<?php echo htmlspecialchars($row['price']); ?></div>
          <div class="btn-group">
            <a href="buy.php?id=<?php echo $row['id']; ?>" class="btn btn-buy">Buy</a>
            <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-card" onclick="return confirm('Are you sure you want to add this product to your cart?');">Add to cart</a>
            <a href="add_to_wishlist.php?id=<?php echo $row['id']; ?>" class="btn btn-list">Wishlist</a>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php else: ?>
    <div class="no-products">No products found.</div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
