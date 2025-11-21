<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Categories
                        <a href="add-categories.php" class="btn btn-primary float-end">Add Category</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th> 
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $categories = "SELECT * FROM categories";
                                $categories_run = mysqli_query($con, $categories);

                                if (mysqli_num_rows($categories_run) > 0) {
                                    foreach ($categories_run as $item) {
                                ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= $item['category_name']; ?></td>
                                            <td>
                                                <a href="edit-categories.php?id=<?= $item['id']; ?>" class="btn btn-success">Edit</a>
                                            </td>
                                            <td>
                                                <form action="code.php" method="POST">
                                                    <button type="submit" name="categories_delete" value="<?= $item['id']; ?>" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">No Record Found</td>
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
