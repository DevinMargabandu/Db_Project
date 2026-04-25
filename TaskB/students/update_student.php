<?php
require '../config/db_connect.php';

$studentID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$student = null;
$errorMsg = null;

// Fetch existing data to populate the form
if ($studentID > 0) {
    $stmt = $conn->prepare("SELECT * FROM Student WHERE StudentID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $student = $result->fetch_assoc();
        }
        $stmt->close();
    }
}

// Handle the update submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idToUpdate = intval($_POST['StudentID']); // ensuring safety
    $firstName  = $_POST['FirstName'];
    $lastName   = $_POST['LastName'];
    $email      = $_POST['Email'];
    $major      = $_POST['Major'];
    $gradYear   = intval($_POST['GradYear']);
    
    // UPDATE: Update the specific student using a prepared statement
    $updateStmt = $conn->prepare("UPDATE Student SET FirstName=?, LastName=?, Email=?, Major=?, GradYear=? WHERE StudentID=?");
    if ($updateStmt) {
        $updateStmt->bind_param("ssssii", $firstName, $lastName, $email, $major, $gradYear, $idToUpdate);
        if ($updateStmt->execute()) {
            header("Location: view_students.php?msg=updated");
            exit();
        } else {
            $errorMsg = "Error updating database: " . $updateStmt->error;
        }
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
    <title>Update Student</title>
    <link rel="stylesheet" href="../assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Update Student</h1>
            <p>Modify existing student information in the database. (UPDATE)</p>
        </header>

        <?php if ($errorMsg) echo "<p style='color:#d9534f; background:#f9d6d5; padding:10px; border-radius:4px;'>$errorMsg</p>"; ?>

        <?php if ($student): ?>
        <form action="update_student.php?id=<?php echo $studentID; ?>" method="POST">
            <!-- Read-only primary key -->
            <div class="form-group">
                <label>Student ID (Not Editable)</label>
                <input type="number" name="StudentID" value="<?php echo htmlspecialchars($student['StudentID']); ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
            </div>
            
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="FirstName" value="<?php echo htmlspecialchars($student['FirstName']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="LastName" value="<?php echo htmlspecialchars($student['LastName']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" value="<?php echo htmlspecialchars($student['Email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Major</label>
                <input type="text" name="Major" value="<?php echo htmlspecialchars($student['Major']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Graduation Year</label>
                <input type="number" name="GradYear" value="<?php echo htmlspecialchars($student['GradYear']); ?>" min="2020" max="2035" required>
            </div>
            
            <button type="submit">Update Student</button>
        </form>
        <?php else: ?>
            <p>Student not found. <a href="view_students.php">Go back</a></p>
        <?php endif; ?>
        
        <br>
        <a href="view_students.php" class="back-link">← Cancel and Back to Directory</a>
    </div>
</body>
</html>
<?php 
if(isset($conn)){
    $conn->close(); 
}
?>
