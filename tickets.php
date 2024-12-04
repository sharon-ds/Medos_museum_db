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

// Handle ticket purchase
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_ticket'])) {
    $visitor_ID = $_POST['visitor_ID'];
    $event_ID = $_POST['event_ID'];

    $sql = "INSERT INTO attends (visitor_ID, event_ID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $visitor_ID, $event_ID);
    $stmt->execute();
    $stmt->close();
}

// Fetch all visitors
$visitor_sql = "SELECT * FROM visitor";
$visitor_result = $conn->query($visitor_sql);

// Fetch all events
$event_sql = "SELECT * FROM event";
$event_result = $conn->query($event_sql);

// Fetch all tickets
$tickets_sql = "SELECT v.visitor_Name, e.event_Title 
                FROM attends a
                JOIN visitor v ON a.visitor_ID = v.visitor_ID
                JOIN event e ON a.event_ID = e.event_ID";
$tickets_result = $conn->query($tickets_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Management</title>
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
    <h1>Tickets Management</h1>
    <h2>Current Tickets</h2>
    <table>
        <thead>
            <tr>
                <th>Visitor Name</th>
                <th>Event Title</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $tickets_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['visitor_Name']) ?></td>
                    <td><?= htmlspecialchars($row['event_Title']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Buy Ticket</h2>
    <form method="POST">
        <label for="visitor_ID">Select Visitor:</label>
        <select name="visitor_ID" id="visitor_ID" required>
            <?php while ($row = $visitor_result->fetch_assoc()): ?>
                <option value="<?= $row['visitor_ID'] ?>"><?= htmlspecialchars($row['visitor_Name']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="event_ID">Select Event:</label>
        <select name="event_ID" id="event_ID" required>
            <?php while ($row = $event_result->fetch_assoc()): ?>
                <option value="<?= $row['event_ID'] ?>"><?= htmlspecialchars($row['event_Title']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="buy_ticket">Buy Ticket</button>
    </form>

    <?php $conn->close(); ?>
</body>
</html>
