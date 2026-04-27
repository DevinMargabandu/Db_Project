<?php
require '../config/db_connect.php';

$eventID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$event = null;
$errorMsg = null;

if ($eventID > 0) {
    $stmt = $conn->prepare("SELECT * FROM Event WHERE EventID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $event = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        $errorMsg = "Error preparing event lookup: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToUpdate = intval($_POST['EventID']);
    $eventName = trim($_POST['EventName']);
    $eventDate = $_POST['EventDate'];
    $location = trim($_POST['Location']);
    $description = trim($_POST['Description']);
    $capacity = intval($_POST['Capacity']);
    $clubID = intval($_POST['ClubID']);

    $updateStmt = $conn->prepare(
        "UPDATE Event
         SET EventName = ?, EventDate = ?, Location = ?, Description = ?, Capacity = ?, ClubID = ?
         WHERE EventID = ?"
    );

    if ($updateStmt) {
        $updateStmt->bind_param("ssssiii", $eventName, $eventDate, $location, $description, $capacity, $clubID, $idToUpdate);
        if ($updateStmt->execute()) {
            header("Location: view_events.php?msg=updated");
            exit();
        }

        $errorMsg = "Error updating database: " . $updateStmt->error;
        $updateStmt->close();
    } else {
        $errorMsg = "Error preparing update statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Event</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Event</h1>
            <p>Modify event information in the database.</p>
        </header>

        <?php if ($errorMsg): ?>
            <p style="color:#d9534f; background:#f9d6d5; padding:10px; border-radius:4px;"><?php echo htmlspecialchars($errorMsg); ?></p>
        <?php endif; ?>

        <?php if ($event): ?>
            <form action="update_event.php?id=<?php echo $eventID; ?>" method="POST">
                <div class="form-group">
                    <label>Event ID (Not Editable)</label>
                    <input type="number" name="EventID" value="<?php echo htmlspecialchars($event['EventID']); ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="EventName" value="<?php echo htmlspecialchars($event['EventName']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Event Date</label>
                    <input type="date" name="EventDate" value="<?php echo htmlspecialchars($event['EventDate']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="Location" value="<?php echo htmlspecialchars($event['Location']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="Description" rows="3"><?php echo htmlspecialchars($event['Description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Capacity</label>
                    <input type="number" name="Capacity" value="<?php echo htmlspecialchars($event['Capacity']); ?>" min="1" required>
                </div>

                <div class="form-group">
                    <label>Hosting Club ID</label>
                    <input type="number" name="ClubID" value="<?php echo htmlspecialchars($event['ClubID']); ?>" min="1" required>
                </div>

                <button type="submit">Update Event</button>
            </form>
        <?php else: ?>
            <p>Event not found. <a href="view_events.php">Go back</a></p>
        <?php endif; ?>

        <br>
        <a href="view_events.php" class="back-link">Cancel and Back to Events</a>
    </div>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
