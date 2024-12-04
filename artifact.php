<?php include('navbar.html'); ?>

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
    <link rel="stylesheet" href="styles.css">
    <style>
        .hidden {
            display: none;
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
                        <button onclick="toggleEditForm(
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

    <!-- The form is initially hidden -->
    <div id="editFormContainer" class="form-container hidden">
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
        function toggleEditForm(id, name, Excerpt, creator, condition) {
            const formContainer = document.getElementById('editFormContainer');

            // Toggle visibility
            if (formContainer.classList.contains('hidden')) {
                formContainer.classList.remove('hidden');
            } else {
                formContainer.classList.add('hidden');
                return; // Exit early if toggling off
            }

            // Populate form fields with the selected artifact's details
            document.getElementById('artifact_ID').value = id;
            document.getElementById('artifact_Name').value = name;
            document.getElementById('Excerpt').value = Excerpt;
            document.getElementById('Creator').value = creator;
            document.getElementById('Condition').value = condition;

            // Scroll to the form for better UX
            formContainer.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
