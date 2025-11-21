<?php
include '../config/db.php';
$id = intval($_GET['id']);

mysqli_query($con, "DELETE FROM testimonials WHERE id=$id");
header("Location: testimonials_manage.php");
exit();
?>
