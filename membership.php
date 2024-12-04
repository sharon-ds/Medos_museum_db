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

// Handle visitor addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $visitor_Name = $_POST['visitor_Name'];
    $v_Contact_info = $_POST['v_Contact_info'];

    $sql = "INSERT INTO visitor (visitor_Name, v_Contact_info) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $visitor_Name, $v_Contact_info);
    $stmt->execute();
    $stmt->close();
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $visitor_ID = $_POST['visitor_ID'];

    $sql = "DELETE FROM visitor WHERE visitor_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $visitor_ID);
    $stmt->execute();
    $stmt->close();
}

// Fetch all visitors
$sql = "SELECT * FROM visitor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Memberships</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h1>Manage Membership Records</h1>
    <table>
        <thead>
            <tr>
                <th>Visitor ID</th>
                <th>Name</th>
                <th>Contact Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['visitor_ID']) ?></td>
                    <td><?= htmlspecialchars($row['visitor_Name']) ?></td>
                    <td><?= htmlspecialchars($row['v_Contact_Info']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="visitor_ID" value="<?= $row['visitor_ID'] ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div id="visitorFormContainer" class="form-container">
    <h2>Add New Visitor</h2>
        <form method="POST">
            <label for="visitor_Name">Name:</label>
            <input type="text" id="visitor_Name" name="visitor_Name" required>
            
            <label for="visitor_ID">Visitor ID:</label>
            <input type="text" id="visitor_ID" name="visitor_ID" required>
            
            <label for="v_Contact_info">Contact Info:</label>
            <input type="text" id="v_Contact_info" name="v_Contact_info" required>
            <button type="submit" name="add">Add Visitor</button>
        </form>
    </div>
    <?php $conn->close(); ?>
</body>
</html>