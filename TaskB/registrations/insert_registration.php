<?php
require '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = intval($_POST['StudentId']);
    $eventID = intval($_POST['EventID']);
    $registrationDate = $_POST['RegistrationDate'];
    $attendanceStatus = trim($_POST['AttendanceStatus']);

    $stmt = $conn->prepare(
        "INSERT INTO Registration (StudentId, EventID, RegistrationDate, AttendanceStatus)
         VALUES (?, ?, ?, ?)"
    );

    if ($stmt === false) {
        die("<h2>Error preparing statement: " . htmlspecialchars($conn->error) . "</h2>");
    }

    $stmt->bind_param("iiss", $studentId, $eventID, $registrationDate, $attendanceStatus);

    if ($stmt->execute()) {
        header("Location: view_registrations.php?msg=created");
        exit();
    }

    echo "<h2>Error executing registration insertion: " . htmlspecialchars($stmt->error) . "</h2>";
    echo "<a href='registration_form.html'>Go Back</a>";

    $stmt->close();
    $conn->close();
} else {
    header("Location: registration_form.html");
    exit();
}
?>
