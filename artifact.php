<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medosmuseum";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $artifact_ID = $_POST['artifact_ID'];
    $artifact_Name = $_POST['artifact_Name'];
    $Excerpt = $_POST['Excerpt'];
    $Creator = $_POST['Creator'];
    $Condition = $_POST['Condition'];

    $sql = "UPDATE artifact 
            SET artifact_Name = ?, Excerpt = ?, Creator = ?, `Condition` = ? 
            WHERE artifact_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $artifact_Name, $Excerpt, $Creator, $Condition, $artifact_ID);

    if ($stmt->execute()) {
        echo "<p> </p>";
    } else {
        echo "<p>Error updating artifact: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $artifact_ID = $_POST['artifact_ID'];

    $sql = "DELETE FROM artifact WHERE artifact_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $artifact_ID);

    if ($stmt->execute()) {
        echo "<p>Artifact deleted!</p>";
    } else {
        echo "<p>Error deleting artifact: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch all artifacts
$sql = "SELECT * FROM artifact";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Artifacts</title>
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
    <h1>Admin - Manage Artifacts</h1>
    <table>
        <thead>
            <tr>
                <th>Artifact ID</th>
                <th>Artifact Name</th>
                <th>Excerpt</th>
                <th>Creator</th>
                <th>Condition</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['artifact_ID']) ?></td>
                        <td><?= htmlspecialchars($row['artifact_Name']) ?></td>
                        <td><?= htmlspecialchars($row['Excerpt']) ?></td>
                        <td><?= htmlspecialchars($row['Creator']) ?></td>
                        <td><?= htmlspecialchars($row['Condition']) ?></td>
                        <td class="actions">
                            <button onclick="editArtifact(
                                <?= $row['artifact_ID'] ?>,
                                '<?= addslashes($row['artifact_Name']) ?>',
                                '<?= addslashes($row['Excerpt']) ?>',
                                '<?= addslashes($row['Creator']) ?>',
                                '<?= addslashes($row['Condition']) ?>'
                            )">Edit</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="artifact_ID" value="<?= $row['artifact_ID'] ?>">
                                <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this artifact?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No artifacts found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="form-container">
        <h2>Edit Artifact</h2>
        <form method="POST">
            <input type="hidden" name="artifact_ID" id="artifact_ID">
            <label for="artifact_Name">Artifact Name:</label>
            <input type="text" name="artifact_Name" id="artifact_Name" required>
            <label for="Excerpt">Excerpt:</label>
            <textarea name="Excerpt" id="Excerpt" required></textarea>
            <label for="Creator">Creator:</label>
            <input type="text" name="Creator" id="Creator">
            <label for="Condition">Condition:</label>
            <input type="text" name="Condition" id="Condition">
            <button type="submit" name="update">Update Artifact</button>
        </form>
    </div>

    <script>
        function editArtifact(id, name, Excerpt, creator, condition) {
            document.getElementById('artifact_ID').value = id;
            document.getElementById('artifact_Name').value = name;
            document.getElementById('Excerpt').value = Excerpt;
            document.getElementById('Creator').value = creator;
            document.getElementById('Condition').value = condition;
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>

