<?php

include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Users</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Users</li>
    </ol>
    <div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Registered User</h4>
            <div class="card-body">

                <table class="table table-bordered">
                    <head>
                        <tr>
                            <th>Id</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone No</th>
                            <th>Delete</th>
                        </tr>
                    </head>
                    <body>
                        <?php
                            $query = "SELECT * FROM registration";
                            $query_run = mysqli_query($con,$query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                            <td><?= $row['phone'];?></td>
                                        <td>
                                            <form action="code.php" method="POST">
                                            <button type="submit" name="user_delete" value="<?=$row['id']; ?>" class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <tr>
                                        <td colspan="6">No Record Found</td>
                                    </tr>
                                <?php
                            }
                        ?>
                        
                    </body>
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