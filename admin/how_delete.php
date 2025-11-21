<?php
include '../config/db.php';
$id = intval($_GET['id']);

if($id > 0){
    mysqli_query($con, "DELETE FROM how_it_works WHERE id=$id");
}

header("Location: how_manage.php");
exit();
?>
