<?php
include 'config/db.php';

$id = $_GET['id'];
mysqli_query($con, "DELETE FROM sourcing_benefits WHERE id=$id");
header("Location: sourcing_benefits.php");
exit;
?>
