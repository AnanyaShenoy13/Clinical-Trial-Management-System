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

// Fetch participant data from the database based on user_id
$sql = "SELECT * FROM participant WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $participant = $result->fetch_assoc();
} else {
    die("Participant data not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Dashboard - Clinical Trial Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            background-image: url('image3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
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
        }
        .dashboard-section {
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
            overflow: hidden; /* Clear float */
        }
        .details-box {
            float: left;
            width: 40%;
            margin-right: 5%;
            background-color: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }
        .actions-box {
            float: left;
            width: 55%;
        }
        .actions-box button {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .actions-box button:hover {
            background-color: #0056b3;
        }
        .logout-link {
            clear: both;
            display: inline-block; /* Display inline */
            margin-top: 20px;
            margin-left: calc(50% - 80px); /* Adjust margin to center */
            text-align: center;
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
        <h1>Participant Dashboard</h1>
        
        <!-- Participant details section -->
        <div class="dashboard-section">
            <div class="details-box">
                <p><strong>Participant Details</strong></p>
                <p>Participant ID: <?php echo htmlspecialchars($participant['id']); ?></p>
                <p>Name: <?php echo htmlspecialchars($participant['name']); ?></p>
                <p>Age: <?php echo htmlspecialchars($participant['age']); ?></p>
                <p>Gender: <?php echo htmlspecialchars($participant['gender']); ?></p>
                <p>Medical History: <?php echo htmlspecialchars($participant['medical_history']); ?></p>
                <p>Contact Information: <?php echo htmlspecialchars($participant['contact_information']); ?></p>
            </div>
            <div class="actions-box">
                <!-- <a href="upcoming_appointments.php"><button>Upcoming Appointments</button></a> -->
                <a href="trial_status.php"><button>Trial Participation Status</button></a>
                <a href="record_data.php"><button>Record Trial Data</button></a>
            </div>
        </div>

        <a class="logout-link" href="logout.php">Logout</a> <!-- Logout link positioned separately -->
    </div>
</body>
</html>
