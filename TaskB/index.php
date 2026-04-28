<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University DB System Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container" style="max-width: 800px;">
        <header>
            <h1>Database Hub</h1>
            <p>Phase 3 - HTML Interface</p>
        </header>

        <div class="dashboard-grid">
            <a href="students/view_students.php" class="dashboard-card"
                style="background-color: var(--primary); color: rgb(53, 121, 73);">Students Directory</a>
            <a href="clubs/view_clubs.php" class="dashboard-card"
                style="background-color: var(--primary); color: rgb(53, 121, 73);">Clubs Directory</a>
            <a href="events/view_events.php" class="dashboard-card"
                style="background-color: var(--primary); color: rgb(53, 121, 73);">Event Schedule</a>
            <a href="registrations/view_registrations.php" class="dashboard-card"
                style="background-color: var(--primary); color: rgb(53, 121, 73);">Event Registrations</a>
            <a href="sql_injection_demo.php" class="dashboard-card"
                style="background-color: var(--primary); color: rgb(53, 121, 73);">SQL Injection Demo</a>
        </div>
    </div>
</body>

</html>
