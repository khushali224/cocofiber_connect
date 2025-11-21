<?php
include '../config/db.php';
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($con, "DELETE FROM contact_info WHERE id=$id");
}
header("Location: contact_manage.php");
exit;
