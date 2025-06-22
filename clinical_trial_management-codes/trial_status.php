<?php
session_start();

// Check if user is logged in as participant
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'participant') {
    header('Location: login.php');
    exit();
}

// Include your database connection file
include 'db.php';

$user_id = $_SESSION['user_id'];

// Fetch trial participation status for the participant (example query)
$sql = "SELECT t.name AS trial_name, p.status
        FROM participation AS p
        INNER JOIN trials AS t ON p.trial_id = t.id
        WHERE p.participant_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial Participation Status</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('image3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            color: #333;
            font-size: 28px; /* Increased font size */
            font-weight: bold; /* Bold font weight */
        }
        .status-list {
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Clear float */
        }
        .status-list p {
            margin-bottom: 10px;
            font-size: 18px; /* Increased font size */
            font-weight: bold; /* Bold font weight */
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff; /* Blue background color */
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px; /* Increased font size */
        }
        .back-link:hover {
            text-decoration: none;
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Trial Participation Status</h1>

        <div class="status-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p>Trial Name: " . htmlspecialchars($row['trial_name']) . "</p>";
                    echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
                    // Display other trial status details as needed
                }
            } else {
                echo "<p>No trial participation status found.</p>";
            }
            ?>
        </div>

        <a class="back-link" href="participant_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
