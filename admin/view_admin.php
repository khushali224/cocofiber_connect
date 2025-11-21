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
                    <h4>Registered Admin</h4>
                    <a href="admin_add.php" class="btn btn-primary float-end">Add Admin</a>
                </div>
                <div class="card-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Phone No</th>
                                <th>Password</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM admins";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['role_as'] == 'admin') {
                                                echo "Admin";
                                            } else {
                                                echo ucfirst($row['role_as']);
                                            }
                                            ?>
                                        </td>
                                        <td><?= $row['phone']; ?></td>
                                        <td>********</td> <!-- ✅ Hide password -->
                                        <td>
                                            <a href="admin_edit.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            <form action="code.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                                <button type="submit" name="admin_delete" value="<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center">No Record Found</td>
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

<?php
include('includes/footer.php');
include('includes/script.php');
?>
