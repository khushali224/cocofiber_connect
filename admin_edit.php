<?php
include("config.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
  $product = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $min_order = $_POST['min_order'];
  $rating = $_POST['rating'];
  
  mysqli_query($conn, "UPDATE products SET
    title='$title',
    description='$description',
    price='$price',
    min_order='$min_order',
    rating='$rating'
    WHERE id = $id");
    
  header("Location: admin_products.php");
}
?>

<h2>Edit Product</h2>
<form method="POST">
  <label>Title:</label>
  <input type="text" name="title" value="<?php echo $product['title']; ?>"><br>

  <label>Description:</label>
  <textarea name="description"><?php echo $product['description']; ?></textarea><br>

  <label>Price:</label>
  <input type="text" name="price" value="<?php echo $product['price']; ?>"><br>

  <label>Min Order:</label>
  <input type="text" name="min_order" value="<?php echo $product['min_order']; ?>"><br>

  <label>Rating:</label>
  <input type="text" name="rating" value="<?php echo $product['rating']; ?>"><br>

  <button type="submit" name="update">Update Product</button>
</form>
