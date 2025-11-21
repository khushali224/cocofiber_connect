<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>Add Product
                        <a href="product-view.php" class="btn btn-danger float-end">Back</a>
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
                                <select class="col-md-8" value="CocoFiber" name="category_name">
                                    <option name="category_name" id="Coir Disk" value="Coir Disk">Coir Disk</option>
                                    <option name="category_name" id="Coir Blocks" value="Coir Blocks">Coir Blocks</option>
                                    <option name="category_name" id="Coir Pots" value="Coir Pots">Coir Pots</option>
                                    <option name="category_name" id="Coir Mats" value="Coir Mats">Coir Mats</option>
                                    <option name="category_name" id="Coir Rope" value="Coir Rope">Coir Rope</option>
                                    <option name="category_name" id="Coir Geo Textiles" value="Coir Geo Textiles">Coir Geo Textiles</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" name="pname" id="productname" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
								<textarea class="form-control" rows="3" cols="50" name="description" id="description" required></textarea> 
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" id="price" required>
                            </div>
                            <label for="focusedinput" class="col-sm-3 control-label">CocoFiber Product Image</label>
                            <div class="col-sm-2">
                                <input type="file" name="image" id="image" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Status</label>
                                <input type="checkbox" name="status">
                            </div>
                            
                            
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="products_add" class="btn btn-primary">Create Product</button>
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