<?php
require '../config/db_connect.php';

if (isset($_GET['id'])) {
    $eventID = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM Event WHERE EventID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $eventID);
        if ($stmt->execute()) {
            header("Location: view_events.php?msg=deleted");
            exit();
        }

        echo "<h2>Error deleting record: " . htmlspecialchars($stmt->error) . "</h2>";
        $stmt->close();
    } else {
        echo "<h2>Error preparing statement: " . htmlspecialchars($conn->error) . "</h2>";
    }
}

$conn->close();
echo "<br><a href='view_events.php'>Back to Event List</a>";
?>
