<?php
require '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = intval($_POST['EventID']);
    $eventName = trim($_POST['EventName']);
    $eventDate = $_POST['EventDate'];
    $location = trim($_POST['Location']);
    $description = trim($_POST['Description']);
    $capacity = intval($_POST['Capacity']);
    $clubID = intval($_POST['ClubID']);

    $stmt = $conn->prepare(
        "INSERT INTO Event (EventID, EventName, EventDate, Location, Description, Capacity, ClubID)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt === false) {
        die("<h2>Error preparing statement: " . htmlspecialchars($conn->error) . "</h2>");
    }

    $stmt->bind_param("issssii", $eventID, $eventName, $eventDate, $location, $description, $capacity, $clubID);

    if ($stmt->execute()) {
        header("Location: view_events.php?msg=created");
        exit();
    }

    echo "<h2>Error executing event insertion: " . htmlspecialchars($stmt->error) . "</h2>";
    echo "<a href='event_form.html'>Go Back</a>";

    $stmt->close();
    $conn->close();
} else {
    header("Location: event_form.html");
    exit();
}
?>
