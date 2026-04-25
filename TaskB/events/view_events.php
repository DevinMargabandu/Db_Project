<?php
require '../config/db_connect.php';

// READ: Fetch all events
$sql = "SELECT EventID, EventName, EventDate, Location, Description, Capacity, ClubID FROM Event";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Events</title>
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
            <h1>Event Schedule</h1>
            <p>View all upcoming events.</p>
        </header>

        <a href="event_form.html" class="back-link" style="display:inline-block; margin-bottom: 15px;">➕ Schedule New Event</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Capacity</th>
                        <th>Club ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['EventID']); ?></td>
                            <td><?php echo htmlspecialchars($row['EventName']); ?></td>
                            <td><?php echo htmlspecialchars($row['EventDate']); ?></td>
                            <td><?php echo htmlspecialchars($row['Location']); ?></td>
                            <td><?php echo htmlspecialchars($row['Capacity']); ?></td>
                            <td><?php echo htmlspecialchars($row['ClubID']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="margin-top:20px; padding: 20px; background: #f9f9f9; text-align: center;">No events found in the database. Go ahead and add one!</p>
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
