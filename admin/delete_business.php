<?php
include '../config/db.php';
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($con, "DELETE FROM business_hours WHERE id=$id");
}
header("Location: business_manage.php");
exit;
