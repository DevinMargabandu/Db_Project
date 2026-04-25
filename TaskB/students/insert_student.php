<?php
require '../config/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Retrieve form data
    $studentID = $_POST['StudentID'];
    $firstName = $_POST['FirstName'];
    $lastName  = $_POST['LastName'];
    $email     = $_POST['Email'];
    $major     = $_POST['Major'];
    $gradYear  = $_POST['GradYear'];
    
    // 2. Prepare SQL INSERT statement using Prepared Statements to prevent injection
    $stmt = $conn->prepare("INSERT INTO Student (StudentID, FirstName, LastName, Email, Major, GradYear) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("<h2>Error preparing statement: " . $conn->error . "</h2>");
    }

    // Bind parameters (i = integer, s = string)
    $stmt->bind_param("issssi", $studentID, $firstName, $lastName, $email, $major, $gradYear);
    
    // 3. Execute statement and handle results
    if ($stmt->execute()) {
        echo "<h2>New student successfully created! (CREATE)</h2>";
        echo "<a href='view_students.php'>View All Students</a><br><br>";
        echo "<a href='student_form.html'>Add Another Student</a>";
    } else {
        echo "<h2>Error executing student insertion: " . $stmt->error . "</h2>";
        echo "<a href='student_form.html'>Go Back</a>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed directly without a POST request, redirect back
    header("Location: student_form.html");
    exit();
}
?>
