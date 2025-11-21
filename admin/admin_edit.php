<?php
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Admin</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Admin</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Admin</h4>
                </div>
                <div class="card-body">

                    <?php
                    if(isset($_GET['id']))
                    {
                        $user_id = $_GET['id'];
                        $users = "SELECT * FROM `admins` WHERE id='$user_id' ";
                        $users_run = mysqli_query($con, $users);

                        if(mysqli_num_rows($users_run) > 0)
                        {
                            foreach($users_run as $user)
                            {
                            ?>

                            <form action="code.php" method="POST">
                                <input type="hidden" name="user_id" value="<?=$user['id'];?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="username" value="<?= $user['username'];?>" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" name="email" value="<?= $user['email'];?>" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="">Role as</label>
                                        <select name="role_as" required class="fore-control">
                                            <option value="">--Select Role--</option>
                                            <option value="admin" <?= $user['role_as'] == 'admin' ? 'selected':''; ?> >Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <lable class="text">Mobile </lable>
                                        <input type="text" name="phone" value="<?= isset($uses['phone']) ? htmlspecialchars($uses['phone']) : ''; ?>" class="form-control">
                                     </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" value="<?= $user['password'];?>" class="form-control">
                                    </div>
                                   
                                    
                                    <div class="col-md-6 mb-3">
                                        <button type="submit" name="update_admin" class="btn btn-primary">Upadate Admin</button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php
                            }
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