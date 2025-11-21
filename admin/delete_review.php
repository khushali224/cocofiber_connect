<?php
include '../config/db.php';
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($con, "DELETE FROM review WHERE id=$id");
}
header("Location: review_manage.php");
exit;
