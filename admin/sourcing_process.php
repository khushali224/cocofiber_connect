<?php
include 'config/db.php';

// --- Add Step ---
if (isset($_POST['add'])) {
    $step = mysqli_real_escape_string($con, $_POST['step']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);

    mysqli_query($con, "INSERT INTO sourcing_process (step_number, title, description) 
                        VALUES ('$step','$title','$desc')");
    header("Location: sourcing_process.php");
    exit;
}

// --- Update Step ---
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $step = mysqli_real_escape_string($con, $_POST['step']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);

    mysqli_query($con, "UPDATE sourcing_process 
                        SET step_number='$step', title='$title', description='$desc' 
                        WHERE id=$id");
    header("Location: sourcing_process.php");
    exit;
}

// --- Delete Step ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($con, "DELETE FROM sourcing_process WHERE id=$id");
    header("Location: sourcing_process.php");
    exit;
}

// --- Fetch for Editing ---
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = mysqli_query($con, "SELECT * FROM sourcing_process WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}

// --- Fetch All Steps ---
$process = mysqli_query($con, "SELECT * FROM sourcing_process ORDER BY step_number ASC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Process Steps</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-amber-800">Manage Process Steps</h1>

    <!-- Add / Edit Form -->
    <form method="POST" class="bg-white p-4 rounded-xl shadow mb-6 grid grid-cols-3 gap-4">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

      <input type="number" name="step" placeholder="Step #" required 
             value="<?= $editData['step_number'] ?? '' ?>"
             class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">

      <input type="text" name="title" placeholder="Title" required 
             value="<?= $editData['title'] ?? '' ?>"
             class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">

      <input type="text" name="description" placeholder="Description" required 
             value="<?= $editData['description'] ?? '' ?>"
             class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">

      <?php if ($editData): ?>
        <button type="submit" name="update" 
                class="col-span-3 bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition">
          ✏️ Update Step
        </button>
        <a href="sourcing_process.php" 
           class="col-span-3 text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
          Cancel
        </a>
      <?php else: ?>
        <button type="submit" name="add" 
                class="col-span-3 bg-amber-700 hover:bg-amber-800 text-white px-6 py-2 rounded-lg transition">
          ➕ Add Step
        </button>
      <?php endif; ?>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded-xl shadow">
        <thead>
          <tr class="bg-amber-200 text-left">
            <th class="p-3">Step</th>
            <th class="p-3">Title</th>
            <th class="p-3">Description</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = mysqli_fetch_assoc($process)): ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="p-3 font-semibold"><?= htmlspecialchars($p['step_number']); ?></td>
            <td class="p-3"><?= htmlspecialchars($p['title']); ?></td>
            <td class="p-3"><?= htmlspecialchars($p['description']); ?></td>
            <td class="p-3 space-x-3">
              <a href="?edit=<?= $p['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="?delete=<?= $p['id'] ?>" 
                 onclick="return confirm('Delete this step?');" 
                 class="text-red-600 hover:underline">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div style="text-align: center; margin-top:20px;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
    </div>
  </div>
</body>
</html>
