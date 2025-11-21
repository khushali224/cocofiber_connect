<?php

include('config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    
    
    <div class="row mt-4">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4> Manage Review</h4>
            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <head>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Delete</th>
                            
                        </tr>
                    </head>
                    <body>
                        <?php
                        
                            $query = "SELECT * FROM contact_review";
                            $query_run = mysqli_query($con,$query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    
                                    ?>
                                    
                                    <tr>
                                        
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['title']; ?></td>
                                        <td><?= $row['rating']; ?></td>
                                        <td><?= $row['review']; ?></td>
                                
                                        <td>
                                            <form action="code.php" method="POST">
                                            <button type="submit" name="reviews_delete" value="<?=$row['id']; ?>" class="btn btn-danger">Delete</button>
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