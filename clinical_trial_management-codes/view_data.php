<?php
session_start();

// Check if username is set in session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($username)) {
    // Redirect or handle unauthorized access
    header('Location: login.php');
    exit();
}

// Include your database connection here
include 'db.php';

// Query to fetch trial data
$sql = "SELECT * FROM trial_data";
$result = $conn->query($sql);

$trialData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trialData[] = $row;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Trial Data - Clinical Trial Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing styles */
    </style>
</head>
<body>
    <div class="container">
        <h1>View Trial Data</h1>
        <nav>
            <ul>
                <li><a href="create_trial.html">Create Trials</a></li>
                <li><a href="manage_trials.php">Manage Trials</a></li>
                <li><a href="manage_participants.php">Manage Participants</a></li>
                <li><a href="generate_reports.php">Generate Reports</a></li>
                <li><a class="show-trials-btn" onclick="toggleTrials()">Show Trials</a></li>
            </ul>
        </nav>
        <div class="dashboard-content">
            <h2>Trial Data</h2>
            <table>
                <thead>
                    <tr>
                        <th>Participant ID</th>
                        <th>Data Type</th>
                        <th>Data Value</th>
                        <th>Date Recorded</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trialData as $data): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['participant_id']); ?></td>
                            <td><?php echo htmlspecialchars($data['data_type']); ?></td>
                            <td><?php echo htmlspecialchars($data['data_value']); ?></td>
                            <td><?php echo htmlspecialchars($data['date_recorded']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a class="logout-link" href="logout.php">Logout</a>
    </div>

    <script>
        function toggleTrials() {
            var trialsContent = document.querySelector('.dashboard-content');
            trialsContent.style.display = (trialsContent.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
