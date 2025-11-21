<?php
include '../config/db.php';
$id = intval($_GET['id']);

if($id > 0){
    mysqli_query($con, "DELETE FROM hero_section WHERE id=$id");
}

header("Location: hero_manage.php");
exit();
?>
