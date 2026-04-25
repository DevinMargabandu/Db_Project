<?php
require '../config/db_connect.php';

// READ: Fetch all students from the database
$sql = "SELECT StudentID, FirstName, LastName, Email, Major, GradYear FROM Student";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
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
    <div class="container" style="max-width: 900px;">
        <header>
            <h1>Student Directory</h1>
            <p>This page READS from the database, and provides links to UPDATE or DELETE.</p>
        </header>

        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="msg">Student record successfully updated!</div>
        <?php elseif(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="msg">Student record successfully deleted!</div>
        <?php endif; ?>

        <a href="student_form.html" class="back-link" style="display:inline-block; margin-bottom: 15px;">➕ Add New Student</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Major</th>
                        <th>Grad Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['StudentID']); ?></td>
                            <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                            <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo htmlspecialchars($row['Major']); ?></td>
                            <td><?php echo htmlspecialchars($row['GradYear']); ?></td>
                            <td>
                                <!-- Pass the StudentID through the URL to identify which student to edit or delete -->
                                <a href="update_student.php?id=<?php echo urlencode($row['StudentID']); ?>" class="action-link">Edit</a>
                                <a href="delete_student.php?id=<?php echo urlencode($row['StudentID']); ?>" class="action-link delete-btn" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="margin-top:20px; padding: 20px; background: #f9f9f9; text-align: center;">No students found in the database. Go ahead and add one!</p>
        <?php endif; ?>

        <br>
        <a href="../index.html" class="back-link" style="margin-top: 2rem;">← Back to Dashboard</a>
    </div>
</body>
</html>
<?php 
if(isset($conn)){
    $conn->close(); 
}
?>
