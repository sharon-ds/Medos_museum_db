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

    <?php $conn->close(); ?>
</body>
</html>
