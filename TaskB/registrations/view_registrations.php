<?php
require '../config/db_connect.php';

$sql = "SELECT StudentId, EventID, RegistrationDate, AttendanceStatus FROM Registration";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Registrations</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; text-align: left;}
        table, th, td { border: 1px solid #ccc; }
        th { background-color: #f7f7f7; color: var(--primary); padding: 12px; }
        td { padding: 10px; }
        .action-link { margin-right: 10px; color: var(--primary); text-decoration: none; font-weight: 600;}
        .action-link:hover { text-decoration: underline; }
        .delete-btn { color: #d9534f; }
        .msg { background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 1000px;">
        <header>
            <h1>Event Registrations</h1>
            <p>View and manage student registrations.</p>
        </header>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'created'): ?>
            <div class="msg">Registration successfully created!</div>
        <?php elseif(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="msg">Registration successfully updated!</div>
        <?php elseif(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="msg">Registration successfully deleted!</div>
        <?php endif; ?>

        <a href="registration_form.html" class="back-link" style="display:inline-block; margin-bottom: 15px;">Add Registration</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Event ID</th>
                        <th>Date Registered</th>
                        <th>Attendance Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['StudentId']); ?></td>
                            <td><?php echo htmlspecialchars($row['EventID']); ?></td>
                            <td><?php echo htmlspecialchars($row['RegistrationDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['AttendanceStatus']); ?></td>
                            <td>
                                <a href="update_registration.php?student_id=<?php echo urlencode($row['StudentId']); ?>&event_id=<?php echo urlencode($row['EventID']); ?>" class="action-link">Edit</a>
                                <a href="delete_registration.php?student_id=<?php echo urlencode($row['StudentId']); ?>&event_id=<?php echo urlencode($row['EventID']); ?>" class="action-link delete-btn" onclick="return confirm('Are you sure you want to delete this registration?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="margin-top:20px; padding: 20px; background: #f9f9f9; text-align: center;">No registrations found in the database. Go ahead and add one.</p>
        <?php endif; ?>

        <br>
        <a href="../index.php" class="back-link" style="margin-top: 2rem;">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
