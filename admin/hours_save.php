<?php
include '../config/db.php';
if($_POST['hours']){
  foreach($_POST['hours'] as $id=>$h){
    mysqli_query($con,"UPDATE business_hours SET hours='$h' WHERE id=$id");
  }
}
header("Location: hours_manage.php");
-