<?php
require '../config/db_connect.php';

if (isset($_GET['student_id']) && isset($_GET['event_id'])) {
    $studentId = intval($_GET['student_id']);
    $eventID = intval($_GET['event_id']);

    $stmt = $conn->prepare("DELETE FROM Registration WHERE StudentId = ? AND EventID = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $studentId, $eventID);
        if ($stmt->execute()) {
            header("Location: view_registrations.php?msg=deleted");
            exit();
        }

        echo "<h2>Error deleting record: " . htmlspecialchars($stmt->error) . "</h2>";
        $stmt->close();
    } else {
        echo "<h2>Error preparing statement: " . htmlspecialchars($conn->error) . "</h2>";
    }
}

$conn->close();
echo "<br><a href='view_registrations.php'>Back to Registration List</a>";
?>
