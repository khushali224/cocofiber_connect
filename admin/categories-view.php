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
                    </h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered border-straipe">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Categories Name</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $category= "SELECT * FROM categories";
                                $category_run = mysqli_query($con, $category);

                                if(mysqli_num_rows($category_run) > 0)
                                {
                                    foreach($category_run as $item)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                        
                                            <td><?= $item['category_name']; ?></td>
                                            <td>
                                                <a href="categories-edit.php?id=<?= $item['id']; ?>" class="btn btn-info">Upadate</a>
                                            </td>
                                            <td>
                                                <form action="code.php" method="POST">
                                                <button type="submit" name="categories_delete" value="<?= $item['id']; ?>" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td colspan="8">No Record Found</td>
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