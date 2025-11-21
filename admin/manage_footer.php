<?php
include '../config/db.php';
session_start();


// --- Handle Contact Info Update ---
if (isset($_POST['update_contact'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    $exists = mysqli_query($con, "SELECT id FROM contact_footer LIMIT 1");
    if (mysqli_num_rows($exists) > 0) {
        mysqli_query($con, "UPDATE contact_footer SET email='$email', phone='$phone', address='$address' WHERE id=1");
    } else {
        mysqli_query($con, "INSERT INTO contact_footer (email, phone, address) VALUES ('$email','$phone','$address')");
    }
    $msg = "Contact info updated!";
}

// --- Handle Social Link CRUD ---
// Add
if (isset($_POST['add_social'])) {
    $platform = mysqli_real_escape_string($con, $_POST['platform']);
    $url = mysqli_real_escape_string($con, $_POST['url']);
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    mysqli_query($con, "INSERT INTO social_links (platform, url, icon) VALUES ('$platform','$url','$icon')");
    $msg = "Social link added!";
}

// Delete
if (isset($_GET['delete_social'])) {
    $id = intval($_GET['delete_social']);
    mysqli_query($con, "DELETE FROM social_links WHERE id=$id");
    $msg = "Social link deleted!";
}

// Update
if (isset($_POST['update_social'])) {
    $id = intval($_POST['id']);
    $platform = mysqli_real_escape_string($con, $_POST['platform']);
    $url = mysqli_real_escape_string($con, $_POST['url']);
    $icon = mysqli_real_escape_string($con, $_POST['icon']);
    mysqli_query($con, "UPDATE social_links SET platform='$platform', url='$url', icon='$icon' WHERE id=$id");
    $msg = "Social link updated!";
}

// Fetch data
$contact = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM contact_info LIMIT 1"));
$socials = mysqli_query($con, "SELECT * FROM social_links ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Footer | Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        body {font-family: Arial, sans-serif; background:#f8f5f0; margin:0; padding:0;}
        .container {max-width:900px; margin:20px auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 3px 10px rgba(0,0,0,0.1);}
        h2, h3 {color:#8B5E3C; margin-bottom:15px;}
        table {border-collapse: collapse; width: 100%; margin-top: 10px;}
        th, td {border:1px solid #ccc; padding:8px; text-align:left; vertical-align: middle;}
        th {background:#8B5E3C; color:#fff;}
        input[type=text], input[type=url] {width:100%; padding:6px; margin:3px 0; border:1px solid #ccc; border-radius:4px;}
        button {background:#5D4037; color:white; padding:6px 12px; border:none; border-radius:4px; cursor:pointer; margin-top:5px;}
        button:hover {background:#8B5E3C;}
        a {text-decoration:none; color:#5D4037; font-weight:bold; margin-left:5px;}
        a:hover {color:#8B5E3C;}
        .msg {color:green; margin-bottom:10px;}
        form {margin-bottom:15px;}
        .btn-back {display:inline-block; margin-top:20px; background:#8B5E3C; color:#fff; padding:6px 12px; border-radius:4px;}
        .btn-back:hover {background:#5D4037;}
    </style>
</head>
<body>
<div class="container">
    <h2>Manage Footer</h2>
    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

    <!-- Contact Info -->
    <h3>Contact Info</h3>
    <form method="post">
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($contact['email'] ?? ''); ?>" required>
        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($contact['phone'] ?? ''); ?>" required>
        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($contact['address'] ?? ''); ?>" required>
        <div style="text-align:center;">
            <button type="submit" name="update_contact">Update Contact Info</button>
        </div>
    </form>

    <!-- Social Links -->
    <h3>Social Links</h3>

    <!-- Add new -->
    <form method="post">
        <label>Platform Name:</label>
        <input type="text" name="platform" required>
        <label>URL:</label>
        <input type="url" name="url" required>
        <label>Icon Path:</label>
        <input type="text" name="icon" placeholder="css/facebook.png" required>
        <div style="text-align:center;">
            <button type="submit" name="add_social">Add Social Link</button>
        </div>
    </form>

    <!-- Existing Social Links -->
    <table>
        <tr>
            <th>ID</th>
            <th>Platform</th>
            <th>URL</th>
            <th>Icon</th>
            <th>Action</th>
        </tr>
        <?php while($s = mysqli_fetch_assoc($socials)) { ?>
        <tr>
            <form method="post">
                <td><?php echo $s['id']; ?><input type="hidden" name="id" value="<?php echo $s['id']; ?>"></td>
                <td><input type="text" name="platform" value="<?php echo htmlspecialchars($s['platform']); ?>"></td>
                <td><input type="url" name="url" value="<?php echo htmlspecialchars($s['url']); ?>"></td>
                <td><input type="text" name="icon" value="<?php echo htmlspecialchars($s['icon']); ?>"></td>
                <td style="white-space: nowrap;">
                    <button type="submit" name="update_social">Update</button>
                    <a href="?delete_social=<?php echo $s['id']; ?>" onclick="return confirm('Delete this social link?')">Delete</a>
                </td>
            </form>
        </tr>
        <?php } ?>
    </table>

    <div style="text-align:center;">
        <a href="home.php" class="btn-back">← Back to Home</a>
    </div>
</div>
</body>
</html>
