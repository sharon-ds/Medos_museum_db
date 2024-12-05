<?php include('navbar.html'); ?>

<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medosmuseum";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle staff assignment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assign'])) {
    $staff_ID = $_POST['staff_ID'];
    $event_ID = $_POST['event_ID'];

    $sql = "INSERT INTO hosts (staff_ID, event_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $staff_ID, $event_ID);
    $stmt->execute();
    $stmt->close();

    // Update the event table with the assigned staff ID
    $update_sql = "UPDATE event SET staff_ID = ? WHERE event_ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $staff_ID, $event_ID);
    $update_stmt->execute();
    $update_stmt->close();
}

// Fetch all staff
$staff_sql = "SELECT * FROM staff";
$staff_result = $conn->query($staff_sql);

// Fetch all events
$event_sql = "SELECT * FROM event";
$event_result = $conn->query($event_sql);

// Fetch all assignments
$assignment_sql = "SELECT s.staff_Name, e.event_Title 
                   FROM hosts h
                   JOIN staff s ON h.staff_ID = s.staff_ID
                   JOIN event e ON h.event_ID = e.event_ID";
$assignment_result = $conn->query($assignment_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Staff</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h1>Schedule Staff for Events</h1>
    
    <h2>Current Assignments</h2>
    <table>
        <thead>
            <tr>
                <th>Staff Name</th>
                <th>Event Title</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $assignment_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['staff_Name']) ?></td>
                    <td><?= htmlspecialchars($row['event_Title']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
    <div id="assignFormContainer" class="form-container">
    <h2>Assign Staff to Event</h2>
        <form method="POST">
            <label for="staff_ID">Select Staff:</label>
            <select name="staff_ID" id="staff_ID" required>
                <?php while ($row = $staff_result->fetch_assoc()): ?>
                    <option value="<?= $row['staff_ID'] ?>"><?= htmlspecialchars($row['staff_Name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="event_ID">Select Event:</label>
            <select name="event_ID" id="event_ID" required>
                <?php while ($row = $event_result->fetch_assoc()): ?>
                    <option value="<?= $row['event_ID'] ?>"><?= htmlspecialchars($row['event_Title']) ?></option>
                <?php endwhile; ?>
            </select>

            <button type="submit" name="assign">Assign Staff</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
