<?php
session_start();
include 'db.php';

$message = ''; // Initialize message variable

// Check if form data is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure all required fields are set
    if (isset($_POST['participant_id'], $_POST['date'], $_POST['measurement_type'], $_POST['value'])) {
        $participant_id = $_POST['participant_id'];
        $date = $_POST['date'];
        $measurement_type = $_POST['measurement_type'];
        $value = $_POST['value'];

        // Check if participant_id exists in participation table
        $check_participant = $conn->prepare("SELECT id FROM participation WHERE id = ?");
        $check_participant->bind_param("i", $participant_id);
        $check_participant->execute();
        $result = $check_participant->get_result();

        if ($result->num_rows > 0) {
            // Insert new trial data into trial_data table
            $stmt = $conn->prepare("INSERT INTO trial_data (participation_id, date, measurement_type, value) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $participant_id, $date, $measurement_type, $value);

            if ($stmt->execute()) {
                $message = "Data recorded successfully";
            } else {
                $message = "Error inserting data: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error: Participant ID does not exist.";
        }

        $check_participant->close();
    } else {
        $message = "Error: Missing form data.";
    }
} else {
   // $message = "Enter Data";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Trial Data</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-image: url('image3.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h1 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .form-group input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            color: #d9534f;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Record Trial Data</h1>

        <?php if (!empty($message)): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="record_data.php" method="post">
            <div class="form-group">
                <label for="participant_id">Participant ID:</label>
                <input type="number" id="participant_id" name="participant_id" required>
            </div>
            <div class="form-group">
                <label for="date">Enrollment Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="measurement_type">Measurement Type:</label>
                <input type="text" id="measurement_type" name="measurement_type" required>
            </div>
            <div class="form-group">
                <label for="value">Value:</label>
                <input type="text" id="value" name="value" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Record Data">
            </div>
        </form>

        <a class="back-link" href="participant_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
