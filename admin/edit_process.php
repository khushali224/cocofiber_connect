<?php
include '../config/db.php';
$id = $_GET['id'] ?? null;
$data = ['step_number'=>'','title'=>'','description'=>''];

if ($id) {
    $res = mysqli_query($con,"SELECT * FROM sourcing_process WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $step_number = $_POST['step_number'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($id) {
        mysqli_query($con,"UPDATE sourcing_process SET step_number='$step_number',title='$title',description='$description' WHERE id=$id");
    } else {
        mysqli_query($con,"INSERT INTO sourcing_process(step_number,title,description) VALUES('$step_number','$title','$description')");
    }
    header("Location: manage_process.php");
}
?>
<form method="POST">
  <label>Step Number</label>
  <input type="number" name="step_number" value="<?= $data['step_number']; ?>"><br>
  <label>Title</label>
  <input type="text" name="title" value="<?= $data['title']; ?>"><br>
  <label>Description</label>
  <textarea name="description"><?= $data['description']; ?></textarea><br>
  <button type="submit">Save</button>
</form>
