<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>Add Categorise
                        <a href="categories-view.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID</label>
                                <input type="text" class="form-control" name="id" id="id" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name</label><br/>
                                <input type="text" class="form-control" name="category_name" id="categoriesname" required>
                            </div>
                            
                            
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="categories-add" class="btn btn-primary">Create Categories</button>
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