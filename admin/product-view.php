<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Product
                    </h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered border-straipe">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Catagory Name</th>
                                    <th>Coco Fiber Product Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $products = "SELECT * FROM products";
                                $products_run = mysqli_query($con, $products);

                                if(mysqli_num_rows($products_run) > 0)
                                {
                                    foreach($products_run as $item)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['category_name']; ?></td>
                                            <td><?= $item['pname']; ?></td>
                                            <td><?= $item['description']; ?></td>
                                            <td><?= $item['price']; ?></td>
                                            <!-- <td><?= $item['image']; ?></td> -->
                                             <td> <img src="../uploads/<?= $item['image']; ?>" width="50px" height="50px" alt=""></td>
                                             <td><?= $item['status']; ?></td>
                                            <td>
                                                <a href="product-edit.php?id=<?= $item['id']; ?>" class="btn btn-info">Edit</a>
                                            </td>
                                            <td>
                                                <form action="code.php" method="POST">
                                                <button type="submit" name="products_delete" value="<?= $item['id']; ?>" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="8">No Record Found</td>
                                        </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/script.php');
?>