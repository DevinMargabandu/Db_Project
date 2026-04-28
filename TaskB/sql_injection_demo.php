<?php
require 'config/db_connect.php';

$studentId = isset($_GET['StudentID']) ? trim($_GET['StudentID']) : '';
$firstName = isset($_GET['FirstName']) ? trim($_GET['FirstName']) : '';
$major = isset($_GET['Major']) ? trim($_GET['Major']) : '';
$generatedSql = null;
$result = null;
$errorMsg = null;

if (isset($_GET['search'])) {
    $generatedSql = "SELECT StudentID, FirstName, LastName, Email, Major, GradYear
        FROM Student
        WHERE StudentID = '$studentId'
          AND FirstName = '$firstName'
          AND Major = '$major'";

    $result = $conn->query($generatedSql);
    if ($result === false) {
        $errorMsg = $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Demo</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .note {
            background: #fff3cd;
            border: 1px solid #ffe08a;
            padding: 12px;
            margin-bottom: 20px;
        }
        .code-box {
            background: #f7f7f7;
            border: 1px solid #ddd;
            padding: 12px;
            font-family: Consolas, monospace;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .hint-list {
            margin: 16px 0 0;
            padding-left: 18px;
        }
        .error-box {
            background: #f9d6d5;
            color: #8a1f11;
            padding: 12px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container" style="max-width: 1000px;">
        <header>
            <h1>SQL Injection Demo</h1>
        </header>

        <form method="GET" action="sql_injection_demo.php">
            <div class="form-group">
                <label for="StudentID">Student ID</label>
                <input type="text" id="StudentID" name="StudentID" value="<?php echo htmlspecialchars($studentId); ?>" placeholder="Try a real ID or an injection payload">
            </div>

            <div class="form-group">
                <label for="FirstName">First Name</label>
                <input type="text" id="FirstName" name="FirstName" value="<?php echo htmlspecialchars($firstName); ?>" placeholder="Example: Alice">
            </div>

            <div class="form-group">
                <label for="Major">Major</label>
                <input type="text" id="Major" name="Major" value="<?php echo htmlspecialchars($major); ?>" placeholder="Example: Computer Science">
            </div>

            <button type="submit" name="search" value="1">Submit</button>
        </form>

        <?php if ($generatedSql): ?>
            <h2 style="margin-top: 24px; color: #4caf50;">Generated SQL</h2>
            <div class="code-box"><?php echo htmlspecialchars($generatedSql); ?></div>
        <?php endif; ?>

        <?php if ($errorMsg): ?>
            <div class="error-box" style="margin-top: 20px;">
                Query error: <?php echo htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

        <?php if ($result instanceof mysqli_result): ?>
            <h2 style="margin-top: 24px; color: #4caf50;">Results</h2>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Major</th>
                            <th>Grad Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['StudentID']); ?></td>
                                <td><?php echo htmlspecialchars($row['FirstName']); ?></td>
                                <td><?php echo htmlspecialchars($row['LastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                <td><?php echo htmlspecialchars($row['Major']); ?></td>
                                <td><?php echo htmlspecialchars($row['GradYear']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="margin-top: 20px;">No rows returned.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- <h2 style="margin-top: 28px; color: #4caf50;">Read-Only Payload Ideas</h2>
        <ul class="hint-list">
            <li><code>' OR '1'='1' -- </code> in the <code>First Name</code> field while putting anything in the other fields.</li>
            <li><code>' OR 'x'='x' -- </code> in the <code>Major</code> field to bypass exact matching.</li>
            <li><code>1001' OR '1'='1' -- </code> in the <code>Student ID</code> field to turn a strict ID lookup into a broad query.</li>
            <li><code>' OR Major='Computer Science' -- </code> in the <code>First Name</code> field to force results for a chosen major.</li>
        </ul> -->

        <a href="index.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>
