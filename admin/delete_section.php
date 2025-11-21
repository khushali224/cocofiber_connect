<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($con, "DELETE FROM sourcing_sections WHERE id=$id");
}

header("Location: manage_sections.php");
exit;
?>
