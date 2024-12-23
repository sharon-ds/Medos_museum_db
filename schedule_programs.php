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

// Add new event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $event_Title = $_POST['event_Title'];
    $Date = $_POST['Date'];
    $room_num = $_POST['room_num'];

    // Calculate new event ID
    $sql = "SELECT MAX(event_ID) AS max_id FROM event";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $new_event_ID = $row['max_id'] + 1;

    // Insert the new event WITH id
    $sql = "INSERT INTO event (event_ID, event_Title, Date, room_num) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $new_event_ID, $event_Title, $Date, $room_num);
    $stmt->execute();
    $stmt->close();
}

// Fetch all rooms
$room_sql = "SELECT * FROM room";
$room_result = $conn->query($room_sql);

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Schedule Programs/Events</h1>
    <table>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Date and Time</th>
                <th>Room Number</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['event_ID']) ?></td>
                    <td><?= htmlspecialchars($row['event_Title']) ?></td>
                    <td><?= htmlspecialchars($row['Date']) ?></td>
                    <td><?= htmlspecialchars($row['room_num']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div id="addFormContainer" class="form-container">
        <h2>Add New Program/Event</h2>
        <form method="POST">
            <label for="event_Title">Event Title:</label>
            <input type="text" id="event_Title" name="event_Title" required>
            <label for="Date">Date and Time:</label>
            <input type="datetime-local" id="Date" name="Date" required>
            <label for="room_num">Room Number:</label>
            <select name="room_num" id="room_num" required>
                <?php while ($row = $room_result->fetch_assoc()): ?>
                    <option value="<?= $row['room_num'] ?>"><?= htmlspecialchars($row['room_num']) ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" name="add">Add Event</button>
        </form>
    </div>

    <?php $conn->close(); ?>
</body>
</html>