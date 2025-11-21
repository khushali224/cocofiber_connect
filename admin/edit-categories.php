<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Category
                        <a href="view-categories.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $category_id = $_GET['id'];
                        $category_query = "SELECT * FROM categories WHERE id='$category_id' LIMIT 1";
                        $category_run = mysqli_query($con, $category_query);

                        if (mysqli_num_rows($category_run) > 0) {
                            $row = mysqli_fetch_array($category_run);
                    ?>
                            <form action="code.php" method="POST">
                                <input type="hidden" name="category_id" value="<?= $row['id']; ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" value="<?= $row['category_name']; ?>" required>
                                    </div>
                                   
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" name="categories_update" class="btn btn-primary">Update Category</button>
                                    </div>
                                </div>
                            </form>
                        <?php
                        } else {
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
