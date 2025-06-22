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

// Initialize variables
$participant_id = '';
$participant = [];
$participant_username = '';

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $participant_id = $_POST['participant_id'];
    $participant_username = $_POST['username'];

    // Validate input
    if (!empty($participant_id) && !empty($participant_username)) {
        // Check if participant exists in the database
        $sql = "SELECT * FROM participant WHERE id = ? AND username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $participant_id, $participant_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Participant found, fetch details
            $participant = $result->fetch_assoc();

            // Check if confirmed for deletion
            if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'true') {
                // Perform deletion operation
                $delete_sql = "DELETE FROM participant WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $participant_id);

                if ($delete_stmt->execute()) {
                    // Deletion successful
                    echo "<div style='color: green;'>Participant '{$participant['name']}' deleted successfully.</div>";
                    // Additional deletion from other related tables can be added here if needed

                    // Clear participant details after deletion
                    $participant = [];
                } else {
                    echo "<div style='color: red;'>Error deleting participant: " . $delete_stmt->error . "</div>";
                }

                // Close delete statement
                $delete_stmt->close();
            } else {
                echo "<div>Please confirm deletion of participant '{$participant['name']}'.</div>";
            }
        } else {
            echo "<div style='color: red;'>Participant not found or username does not match.</div>";
        }

        // Close select statement
        $stmt->close();
    } else {
        echo "<div style='color: red;'>Please enter participant ID and username.</div>";
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
    <title>Delete Participant - Clinical Trial Management System</title>
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
            max-width: 600px;
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
        .container p {
            margin-bottom: 20px;
        }
        .container form {
            display: inline-block;
            margin-top: 20px;
        }
        .container form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .container form input[type="text"],
        .container form input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .container form button {
            padding: 10px 16px; /* Reduced button width */
            background-color: #dc3545; /* Red background */
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container form button:hover {
            background-color: #c82333; /* Darker red on hover */
        }
        .container .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #fff; /* White text */
            border: none;
            padding: 8px 12px; /* Adjusted padding */
            border-radius: 4px;
            background-color: #007bff; /* Blue background */
            transition: background-color 0.3s ease;
        }
        .container .back-link:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Participant</h1>

        <form action="" method="POST">
            <label for="username">Participant Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($participant_username); ?>" required>

            <label for="participant_id">Participant ID:</label>
            <input type="number" id="participant_id" name="participant_id" value="<?php echo htmlspecialchars($participant_id); ?>" required>

            <?php if (!empty($participant['name'])): ?>
                <p>Participant Details:</p>
                <p>Name: <?php echo htmlspecialchars($participant['name']); ?></p>
                <p>Age: <?php echo htmlspecialchars($participant['age']); ?></p>
                <p>Gender: <?php echo htmlspecialchars($participant['gender']); ?></p>
                <p>Medical History: <?php echo htmlspecialchars($participant['medical_history']); ?></p>
                <p>Contact Information: <?php echo htmlspecialchars($participant['contact_information']); ?></p>

                <label for="confirm_delete">Confirm Deletion:</label>
                <input type="checkbox" id="confirm_delete" name="confirm_delete" value="true" required>
            <?php endif; ?>

            <button type="submit">Delete Participant</button>
        </form>

        <a class="back-link" href="manage_participants.php">Back</a>
    </div>
</body>
</html>
