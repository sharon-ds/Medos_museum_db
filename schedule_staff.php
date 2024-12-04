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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #faf3e0; /* Light tan-yellow background */
            color: #5a4a3c; /* Dark brownish text for readability */
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #e7c27d; /* Tan-yellow header background */
            color: #5a4a3c; /* Dark brown text */
            padding: 20px;
            margin: 0;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            background-color: white; /* Soft cream color for table */
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #e0c385; /* Light tan border */
        }

        th {
            background-color: #e7c27d; /* Tan-yellow header */
            color: #5a4a3c; /* Dark text */
            font-weight: bold;
            padding: 10px;
        }

        td {
            padding: 10px;
            text-align: left;
        }

        .form-container {
            background-color: #fff8e1; /* Soft cream for form */
            border: 1px solid #e0c385;
            padding: 20px;
            margin: 20px auto;
            width: 80%;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #5a4a3c; /* Text color */
        }

        input, textarea, button {
            width: calc(100% - 20px);
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #e0c385;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #e7c27d; /* Tan-yellow button */
            color: #5a4a3c;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #d4a659; /* Slightly darker tan-yellow */
        }

        .action-buttons button {
            width: auto;
            margin: 0 5px;
            padding: 5px 10px;
        }

        .center {
            text-align: center;
        }
    </style>
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

    <?php $conn->close(); ?>
</body>
</html>
