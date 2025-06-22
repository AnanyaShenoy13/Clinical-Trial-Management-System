<?php
session_start();

// Check if username is set in session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($username)) {
    // Redirect or handle unauthorized access
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Participants - Clinical Trial Management System</title>
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
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            color: #333;
        }
        .container .dashboard-links {
            margin-bottom: 20px;
        }
        .container .dashboard-links a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-right: 10px;
        }
        .container .dashboard-links a:hover {
            background-color: #0056b3;
        }
        .container .logout-link {
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            border: 1px solid #007bff; /* Blue border */
            padding: 8px 12px; /* Adjusted padding */
            border-radius: 4px;
            background-color: #007bff; /* Blue background */
            transition: background-color 0.3s ease;
        }
        .container .logout-link:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Participants</h1>
        
        <div class="dashboard-links">
            <a href="add_participant.php">Add Participant</a>
            <a href="view_participant.php">View Participants</a>
            <a href="edit_participant.php">Edit Participant</a>
            <a href="delete_participant.php">Delete Participant</a>
        </div>

        <!-- No table displayed as per your request -->

        <a class="back-link" href="researcher_dashboard.php">Back</a>
    </div>
</body>
</html>
