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
    <link rel="stylesheet" href="styles.css">
    
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
