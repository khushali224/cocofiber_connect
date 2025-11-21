<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Product
                        <a href="product-view.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php
                    if(isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                        $products = "SELECT * FROM products WHERE id='$id' LIMIT 1";
                        $products_run = mysqli_query($con, $products);

                        if(mysqli_num_rows($products_run) > 0)
                        {
                            $row = mysqli_fetch_array($products_run);
                            ?>

                            <form action="code.php" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <label class="form-label">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" value="<?= $row['category_name'] ?>" id="category_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="pname" value="<?= $row['pname'] ?>" id="productname" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3" cols="50" name="description" value="<?= $row['description'] ?>" id="description" required></textarea> 
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="number" class="form-control" name="price"  value="<?= $row['price'] ?>" id="price" required>
                                    </div>
                                    <label for="focusedinput" class="col-sm-2 control-label">Coffee Image</label>
                                            <div class="col-sm-6">
                                                <input type="file" name="image" id="image"><br/><br/>
                                                <label for="">Current Image</label>
                                                <input type="hidden" name="old_image" value="<?= $row['image'] ?>">
                                                <img src="../uploads/<?= $row['image'] ?>" alt="" width="50px" height="50px">
                                            </div>
                                    <div class="col-md-6 mb-3">
                                <label for="">Status</label>
                                <input type="checkbox" name="status">
                            </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" name="products_update" class="btn btn-primary">Update product</button>
                                    </div>
                                </div>
                            </form>

                            <?php
                        }
                        else
                        {
                            ?>
                            <h4>No Record Found</h4>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/script.php');
?>