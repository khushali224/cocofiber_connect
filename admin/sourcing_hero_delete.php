<?php
include '../config/db.php';

$id = intval($_GET['id']);
mysqli_query($con, "DELETE FROM sourcing_hero WHERE id=$id");

header("Location: sourcing_hero.php");
exit;
?>
