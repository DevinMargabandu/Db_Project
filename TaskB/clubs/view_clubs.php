<?php
require '../config/db_connect.php';

// READ: Fetch all clubs
$sql = "SELECT ClubID, ClubName, ContactInfo, PresidentID, Field FROM Club";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Clubs</title>
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
            <h1>Club Directory</h1>
            <p>View all registered clubs.</p>
        </header>

        <a href="club_form.html" class="back-link" style="display:inline-block; margin-bottom: 15px;">➕ Create New Club</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Club ID</th>
                        <th>Club Name</th>
                        <th>Contact Email</th>
                        <th>President ID</th>
                        <th>Associated Field</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ClubID']); ?></td>
                            <td><?php echo htmlspecialchars($row['ClubName']); ?></td>
                            <td><?php echo htmlspecialchars($row['ContactInfo']); ?></td>
                            <td><?php echo htmlspecialchars($row['PresidentID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Field']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="margin-top:20px; padding: 20px; background: #f9f9f9; text-align: center;">No clubs found in the database. Go ahead and add one!</p>
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
