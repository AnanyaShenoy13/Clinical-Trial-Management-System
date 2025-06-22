<?php
session_start();

// Check if username is set in session
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

if (empty($username)) {
    // Redirect or handle unauthorized access
    header('Location: login.php');
    exit();
}

// Include database connection
include 'db.php';

// Initialize variables to store form data
$participant_id = $name = $description = $inclusion_criteria = $exclusion_criteria = $start_date = $end_date = '';
$check_participant_result = null; // Initialize $check_participant_result

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['participant_id'])) {
        // Sanitize and validate participant ID
        $participant_id = mysqli_real_escape_string($conn, $_POST['participant_id']);

        // Check if the participant already exists
        $check_participant_sql = "SELECT * FROM participant WHERE id = '$participant_id'";
        $check_participant_result = $conn->query($check_participant_sql);

        if ($check_participant_result === false) {
            // Error in SQL query
            echo "<script>alert('Error checking participant.');</script>";
        } else {
            if ($check_participant_result->num_rows == 0) {
                // Participant does not exist
                echo "<script>alert('Participant with this ID does not exist. Cannot create the trial.');</script>";
            } else {
                // Participant exists, proceed with trial creation
                if (isset($_POST['name'])) {
                    $name = mysqli_real_escape_string($conn, $_POST['name']);
                }
                if (isset($_POST['description'])) {
                    $description = mysqli_real_escape_string($conn, $_POST['description']);
                }
                if (isset($_POST['inclusion_criteria'])) {
                    $inclusion_criteria = mysqli_real_escape_string($conn, $_POST['inclusion_criteria']);
                }
                if (isset($_POST['exclusion_criteria'])) {
                    $exclusion_criteria = mysqli_real_escape_string($conn, $_POST['exclusion_criteria']);
                }
                if (isset($_POST['start_date'])) {
                    $start_date = $_POST['start_date'];
                }
                if (isset($_POST['end_date'])) {
                    $end_date = $_POST['end_date'];
                }

                // Insert new trial into database using participant_id as id
                $insert_sql = "INSERT INTO trials (id, name, description, inclusion_criteria, exclusion_criteria, start_date, end_date)
                               VALUES ('$participant_id', '$name', '$description', '$inclusion_criteria', '$exclusion_criteria', '$start_date', '$end_date')";

                if ($conn->query($insert_sql) === TRUE) {
                    echo "<script>alert('Trial created successfully');</script>";
                } else {
                    echo "<script>alert('Error: " . $conn->error . "');</script>";
                }
            }
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Trial - Clinical Trial Management System</title>
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
        /* Additional CSS styles as needed */
    </style>
    <script>
        function checkParticipant() {
            document.getElementById('participantForm').submit();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Create New Trial</h1>
        <form id="participantForm" action="create_trial.php" method="post">
            <!-- Participant ID input -->
            <label for="participant_id">Participant ID:</label>
            <input type="number" id="participant_id" name="participant_id" value="<?php echo htmlspecialchars($participant_id); ?>" required>
            <button type="button" onclick="checkParticipant()">Check Participant</button>
        </form>

        <?php if ($check_participant_result !== null && $check_participant_result->num_rows > 0): ?>
        <!-- Show the rest of the form if participant exists -->
        <form action="create_trial.php" method="post">
            <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($participant_id); ?>">
            <label for="name">Trial Name:</label>
            <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            
            <label for="inclusion_criteria">Inclusion Criteria:</label>
            <textarea id="inclusion_criteria" name="inclusion_criteria" required><?php echo isset($_POST['inclusion_criteria']) ? htmlspecialchars($_POST['inclusion_criteria']) : ''; ?></textarea>
            
            <label for="exclusion_criteria">Exclusion Criteria:</label>
            <textarea id="exclusion_criteria" name="exclusion_criteria" required><?php echo isset($_POST['exclusion_criteria']) ? htmlspecialchars($_POST['exclusion_criteria']) : ''; ?></textarea>
            
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required>
            
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required>
            
            <button type="submit" class="button">Create Trial</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
