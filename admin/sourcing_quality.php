<?php
include 'config/db.php';

// --- Add Record ---
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    mysqli_query($con, "INSERT INTO sourcing_quality (title, description) VALUES ('$title','$desc')");
    header("Location: sourcing_quality.php");
    exit;
}

// --- Update Record ---
if (isset($_POST['update'])) {
    $id = (int) $_POST['id'];
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $desc = mysqli_real_escape_string($con, $_POST['description']);
    mysqli_query($con, "UPDATE sourcing_quality SET title='$title', description='$desc' WHERE id=$id");
    header("Location: sourcing_quality.php");
    exit;
}

// --- Delete Record ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($con, "DELETE FROM sourcing_quality WHERE id=$id");
    header("Location: sourcing_quality.php");
    exit;
}

// --- Fetch for Editing ---
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $res = mysqli_query($con, "SELECT * FROM sourcing_quality WHERE id=$id");
    $editData = mysqli_fetch_assoc($res);
}

// --- Fetch All Records ---
$quality = mysqli_query($con, "SELECT * FROM sourcing_quality ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Manage Quality Standards</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-amber-800">Manage Quality Standards</h1>

    <!-- Add / Edit Form -->
    <form method="POST" class="bg-white p-4 rounded-xl shadow mb-6 grid grid-cols-2 gap-4">
      <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">

      <input type="text" name="title" placeholder="Title" required
             value="<?= $editData['title'] ?? '' ?>"
             class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">

      <input type="text" name="description" placeholder="Description" required
             value="<?= $editData['description'] ?? '' ?>"
             class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">

      <?php if ($editData): ?>
        <button type="submit" name="update"
                class="col-span-2 bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition">
          ✏️ Update Quality
        </button>
        <a href="sourcing_quality.php"
           class="col-span-2 text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
          Cancel
        </a>
      <?php else: ?>
        <button type="submit" name="add"
                class="col-span-2 bg-amber-700 hover:bg-amber-800 text-white px-6 py-2 rounded-lg transition">
          ➕ Add Quality
        </button>
      <?php endif; ?>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded-xl shadow">
        <thead>
          <tr class="bg-amber-200 text-left">
            <th class="p-3">Title</th>
            <th class="p-3">Description</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($q = mysqli_fetch_assoc($quality)): ?>
          <tr class="border-b hover:bg-gray-50">
            <td class="p-3 font-semibold"><?= htmlspecialchars($q['title']); ?></td>
            <td class="p-3"><?= htmlspecialchars($q['description']); ?></td>
            <td class="p-3 space-x-3">
              <a href="?edit=<?= $q['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
              <a href="?delete=<?= $q['id'] ?>"
                 onclick="return confirm('Delete this record?');"
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
