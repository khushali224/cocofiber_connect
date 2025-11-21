<?php
include '../config/db.php';
$id = intval($_GET['id']);
mysqli_query($con, "DELETE FROM mission_vision WHERE id=$id");
header("Location: mission_manage.php");
exit();
?>
