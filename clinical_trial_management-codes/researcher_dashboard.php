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

// Query to fetch trials data
$sql = "SELECT * FROM trials";
$result = $conn->query($sql);

$trials = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trials[] = $row;
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
    <title>Researcher Dashboard - Clinical Trial Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('image3.jpg'); /* Background image added */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.8); /* Light blue background with opacity */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            color: #333;
        }
        .container .welcome-message {
            background-color: #007bff; /* Changed to blue */
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .container nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
            margin-bottom: 20px; /* Added margin */
        }
        .container nav ul li {
            display: inline-block; /* Display as blocks to allow margin */
            margin-right: 10px;
        }
        .container nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 12px 20px; /* Increased padding for better button size */
            border-radius: 4px;
            background-color: #007bff; /* Same color for all buttons */
            transition: background-color 0.3s ease;
            display: block; /* Make the entire block clickable */
            text-align: center;
        }
        .container nav ul li a:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        .container .dashboard-content {
            margin-top: 20px;
            overflow-x: auto;
            display: none; /* Initially hide the trials list */
        }
        .container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .container table th, .container table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .container table th {
            background-color: #f2f2f2;
        }
        .container table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .container table tbody tr:hover {
            background-color: #e9e9e9;
        }
        .show-trials-btn {
            display: inline-block; /* Display inline */
            padding: 12px 20px; /* Adjust padding */
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            margin-bottom: 20px; /* Added margin */
        }
        .show-trials-btn:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        .logout-link {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #f2f2f2;
            transition: background-color 0.3s ease;
        }
        .logout-link:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Researcher Dashboard</h1>
        <div class="welcome-message">
            <?php echo "Welcome!<br>You are logged in as a researcher."; ?>
        </div>
        <nav>
            <ul>
                <li><a href="create_trial.php">Create Trials</a></li>
                <li><a href="manage_participants.php">Manage Participants</a></li> 
                <li><a class="show-trials-btn" onclick="toggleTrials()">Show Trials</a></li>
            </ul>
        </nav>
        <div class="dashboard-content">
            <h2>Trials List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Trial ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trials as $trial): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trial['id']); ?></td>
                            <td><?php echo htmlspecialchars($trial['name']); ?></td>
                            <td><?php echo htmlspecialchars($trial['description']); ?></td>
                            <td><?php echo htmlspecialchars($trial['start_date']); ?></td>
                            <td><?php echo htmlspecialchars($trial['end_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a class="logout-link" href="logout.php">Logout</a> <!-- Logout link positioned separately -->
    </div>

    <script>
        function toggleTrials() {
            var trialsContent = document.querySelector('.dashboard-content');
            trialsContent.style.display = (trialsContent.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>
</html>
