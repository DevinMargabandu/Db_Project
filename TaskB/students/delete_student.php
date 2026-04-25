<?php
require '../config/db_connect.php';

if (isset($_GET['id'])) {
    $studentID = intval($_GET['id']);
    
    // DELETE: Delete the specific student using a prepared statement
    $stmt = $conn->prepare("DELETE FROM Student WHERE StudentID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $studentID);
        if ($stmt->execute()) {
             // Redirection after successful delete
             header("Location: view_students.php?msg=deleted");
             exit();
        } else {
             echo "<h2>Error deleting record: " . $conn->error . "</h2>";
        }
        $stmt->close();
    } else {
        echo "<h2>Error preparing statement: " . $conn->error . "</h2>";
    }
}

$conn->close();
echo "<br><a href='view_students.php'>Back to Student List</a>";
?>
