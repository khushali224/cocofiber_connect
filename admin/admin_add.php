<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    <div class="row mt-4">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Admin</h4>
                    <a href="view-register.php" class="btn btn-danger float-end">Back</a>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="">Role as</label>
                                <select name="role_as" required class="fore-control">
                                    <option value="">--Select Role--</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="text" class="form-label">Phone No.</label>
                                <input type="phone" name="phone" class="form-control">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <button type="submit" name="add_admin" class="btn btn-primary">Add Admin</button>
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