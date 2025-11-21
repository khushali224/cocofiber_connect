<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Category
                        <a href="view-categories.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="category_name" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="categories_add" class="btn btn-primary">Save Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
include('includes/script.php');
?>
