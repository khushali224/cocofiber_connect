<?php
include '../config/db.php';
if($_POST){
  $hq = $_POST['headquarters'];
  $main = $_POST['phone_main'];
  $support = $_POST['phone_support'];
  $fax = $_POST['fax'];
  $eg = $_POST['email_general'];
  $es = $_POST['email_support'];
  $sl = $_POST['email_sales'];

  $row = mysqli_fetch_assoc(mysqli_query($con,"SELECT id FROM contact_info LIMIT 1"));
  if($row){
    mysqli_query($con,"UPDATE contact_info SET headquarters='$hq', phone_main='$main', phone_support='$support', fax='$fax', email_general='$eg', email_support='$es', email_sales='$sl' WHERE id=".$row['id']);
  } else {
    mysqli_query($con,"INSERT INTO contact_info (headquarters,phone_main,phone_support,fax,email_general,email_support,email_sales) VALUES ('$hq','$main','$support','$fax','$eg','$es','$sl')");
  }
}
header("Location: contact_manage.php");
