<?php
include 'includes/header.php';
include 'config/db.php';

// Fetch all inquiries
$query = "SELECT * FROM sourcing_inquiries ORDER BY submitted_at DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Sourcing Inquiries</title>
    <link rel="stylesheet" href="css/buy.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #8B5A2B;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f8f8f8;
        }
        h2 {
            text-align: center;
            margin: 20px 0;
            color: #5a362a;
        }
    </style>
</head>
<body>
    <h2>All Sourcing Inquiries</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Company Name</th>
            <th>Contact Person</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Monthly Volume</th>
            <th>Additional Requirement</th>
            <th>Submitted At</th>
        </tr>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact_person']); ?></td>
                    <td><?php echo htmlspecialchars($row['email_address']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($row['estimated_monthly_volume']); ?></td>
                    <td><?php echo htmlspecialchars($row['additional_requirement']); ?></td>
                    <td><?php echo $row['submitted_at']; ?></td>
                </tr>
            <?php } ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align:center; color:red;">No inquiries found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
