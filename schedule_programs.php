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

// Add new event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $event_Title = $_POST['event_Title'];
    $Date = $_POST['Date'];

    $sql = "INSERT INTO event (event_Title, Date) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $event_Title, $Date);
    $stmt->execute();
    $stmt->close();
}

// Fetch all events
$sql = "SELECT * FROM event";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Programs</title>
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
    <h1>Schedule Programs/Events</h1>
    <table>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['event_ID']) ?></td>
                    <td><?= htmlspecialchars($row['event_Title']) ?></td>
                    <td><?= htmlspecialchars($row['Date']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Add New Program/Event</h2>
    <form method="POST">
        <label for="event_Title">Event Title:</label>
        <input type="text" id="event_Title" name="event_Title" required>
        <label for="Date">Date:</label>
        <input type="date" id="Date" name="Date" required>
        <button type="submit" name="add">Add Event</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
