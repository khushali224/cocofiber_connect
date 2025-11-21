<?php
session_start();
include('../config/db.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="row mt-4">
        <div class="col-md-12">
            
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h4>Manage Orders</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM orders ORDER BY id DESC";
                            $query_run = mysqli_query($con, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr class="text-center">
                                        <td><?= $row['id']; ?></td>
                                        <td><?= htmlspecialchars($row['customer_name']); ?></td>
                                        <td><?= htmlspecialchars($row['customer_email']); ?></td>
                                        <td><?= htmlspecialchars($row['customer_phone']); ?></td>
                                        <td><?= htmlspecialchars($row['item_name']); ?></td>
                                        <td>
                                            <img src="../uploads/<?= htmlspecialchars($row['item_image']); ?>" 
                                                 alt="Product" width="60" height="60" style="border-radius:6px;">
                                        </td>
                                        <td>₹<?= number_format($row['item_price'], 2); ?></td>
                                        <td><?= $row['quantity']; ?></td>
                                        <td><?= htmlspecialchars($row['payment_method']); ?></td>
                                        <td>
                                            <?php if ($row['payment_status'] === 'paid'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php elseif ($row['payment_status'] === 'failed'): ?>
                                                <span class="badge bg-danger">Failed</span>
                                            <?php elseif ($row['payment_status'] === 'otp_pending' || $row['payment_status'] === 'cod_pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php else: ?>
                                                <?= htmlspecialchars($row['payment_status']); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <!-- Delete Button -->
                                            <form action="code.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');" style="display:inline-block;">
                                                <button type="submit" name="order_delete" value="<?= $row['id']; ?>" 
                                                        class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="12" class="text-center">No Orders Found</td>
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
