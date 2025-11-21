<?php
include('includes/header.php');
include('includes/navbar-top.php');
include('../config/db.php'); // adjust if needed
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>View Fiber</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered border-straipe">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone No</th>
                                    <th>Fiber Type</th>
                                    <th>Quantity (kg)</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Price ($/kg)</th>
                                    <th>Location</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM fiber ORDER BY created_at DESC";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $item) {
                                        ?>
                                        <tr>
                                            <td><?= $item['id']; ?></td>
                                            <td><?= htmlspecialchars($item['username']); ?></td>
                                            <td><?= htmlspecialchars($item['email']); ?></td>
                                            <td><?= htmlspecialchars($item['phone_no']); ?></td>
                                            <td><?= htmlspecialchars($item['fiber_type']); ?></td>
                                            <td><?= $item['quantity_kg']; ?></td>
                                            <td><?= htmlspecialchars($item['description']); ?></td>
                                            <td>
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="../<?= $item['image']; ?>" width="60" height="60" alt="Fiber Image">
                                                <?php else: ?>
                                                    N/A
                                                <?php endif; ?>
                                            </td>
                                            <td>$<?= number_format($item['price_per_kg'], 2); ?></td>
                                            <td><?= htmlspecialchars($item['location']); ?></td>
                                            <td><?= date('d-m-Y', strtotime($item['created_at'])); ?></td>
                                            <td>
                                                <a href="delete-fiber.php?id=<?= $item['id']; ?>" onclick="return confirm('Delete this fiber listing?')" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='12' class='text-center'>No Fiber Listings Found</td></tr>";
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
