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

// Example query to fetch participants
$sql = "SELECT * FROM participant";
$result = $conn->query($sql);

$participants = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
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
    <title>View Participants - Clinical Trial Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('image3.jpg'); /* Background image */
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
        .container .participant-table {
            margin-top: 20px;
            overflow-x: auto;
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
        .container .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #007bff; /* Blue background */
            transition: background-color 0.3s ease;
        }
        .container .back-link:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: #fff; /* White text on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Participants</h1>

        <div class="participant-table">
            <table>
                <thead>
                    <tr>
                        <th>Participant ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Medical History</th>
                        <th>Contact Information</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $participant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($participant['id']); ?></td>
                            <td><?php echo htmlspecialchars($participant['name']); ?></td>
                            <td><?php echo htmlspecialchars($participant['age']); ?></td>
                            <td><?php echo htmlspecialchars($participant['gender']); ?></td>
                            <td><?php echo htmlspecialchars($participant['medical_history']); ?></td>
                            <td><?php echo htmlspecialchars($participant['contact_information']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a class="back-link" href="manage_participants.php">Back</a> <!-- Link to manage_participants.php -->

    </div>
</body>
</html>
