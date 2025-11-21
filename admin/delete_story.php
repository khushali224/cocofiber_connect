<?php
include '../config/db.php';
$id = intval($_GET['id']);
mysqli_query($con, "DELETE FROM company_story WHERE id=$id");
header("Location:story_manage.php");
exit();
?>
