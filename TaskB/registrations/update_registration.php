<?php
require '../config/db_connect.php';

$studentId = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
$eventID = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
$registration = null;
$errorMsg = null;

if ($studentId > 0 && $eventID > 0) {
    $stmt = $conn->prepare("SELECT * FROM Registration WHERE StudentId = ? AND EventID = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $studentId, $eventID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $registration = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        $errorMsg = "Error preparing registration lookup: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = intval($_POST['StudentId']);
    $eventID = intval($_POST['EventID']);
    $registrationDate = $_POST['RegistrationDate'];
    $attendanceStatus = trim($_POST['AttendanceStatus']);

    $updateStmt = $conn->prepare(
        "UPDATE Registration
         SET RegistrationDate = ?, AttendanceStatus = ?
         WHERE StudentId = ? AND EventID = ?"
    );

    if ($updateStmt) {
        $updateStmt->bind_param("ssii", $registrationDate, $attendanceStatus, $studentId, $eventID);
        if ($updateStmt->execute()) {
            header("Location: view_registrations.php?msg=updated");
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
    <title>Update Registration</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Registration</h1>
            <p>Modify an existing student registration.</p>
        </header>

        <?php if ($errorMsg): ?>
            <p style="color:#d9534f; background:#f9d6d5; padding:10px; border-radius:4px;"><?php echo htmlspecialchars($errorMsg); ?></p>
        <?php endif; ?>

        <?php if ($registration): ?>
            <form action="update_registration.php?student_id=<?php echo $studentId; ?>&event_id=<?php echo $eventID; ?>" method="POST">
                <div class="form-group">
                    <label>Student ID (Not Editable)</label>
                    <input type="number" name="StudentId" value="<?php echo htmlspecialchars($registration['StudentId']); ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Event ID (Not Editable)</label>
                    <input type="number" name="EventID" value="<?php echo htmlspecialchars($registration['EventID']); ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                </div>

                <div class="form-group">
                    <label>Registration Date</label>
                    <input type="date" name="RegistrationDate" value="<?php echo htmlspecialchars($registration['RegistrationDate']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Attendance Status</label>
                    <select name="AttendanceStatus">
                        <?php
                        $statuses = array('Registered', 'Attended', 'No-Show', 'Waitlisted');
                        foreach ($statuses as $status) {
                            $selected = $registration['AttendanceStatus'] === $status ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($status) . '" ' . $selected . '>' . htmlspecialchars($status) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <button type="submit">Update Registration</button>
            </form>
        <?php else: ?>
            <p>Registration not found. <a href="view_registrations.php">Go back</a></p>
        <?php endif; ?>

        <br>
        <a href="view_registrations.php" class="back-link">Cancel and Back to Registrations</a>
    </div>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
