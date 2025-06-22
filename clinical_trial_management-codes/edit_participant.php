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
$update_success = false;
$participant = null;
$show_prompt = false;
$show_success_message = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $participant_name = $_POST['name']; // Assuming input field name is 'name'
    $participant_id = $_POST['participant_id']; // Assuming input field name is 'participant_id'

    // Validate input
    if (!empty($participant_name) && !empty($participant_id)) {
        // Check if participant exists in the database for the given ID and name
        $sql = "SELECT * FROM participant WHERE id = ? AND name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $participant_id, $participant_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Participant found, display details for editing
            $participant = $result->fetch_assoc();

            // Process form submission for updating participant details
            if (isset($_POST['update_participant'])) {
                $name = $_POST['name'];
                $age = $_POST['age'];
                $gender = $_POST['gender'];
                $medical_history = $_POST['medical_history'];
                $contact_information = $_POST['contact_information'];

                // Update participant details in the database
                $update_sql = "UPDATE participant SET name=?, age=?, gender=?, medical_history=?, contact_information=? WHERE id=?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("sisssi", $name, $age, $gender, $medical_history, $contact_information, $participant_id);

                if ($update_stmt->execute()) {
                    $update_success = true; // Update successful flag
                    $show_success_message = true;
                } else {
                    echo "Error updating participant details: " . $conn->error;
                }

                $update_stmt->close();
            }
        } else {
            $show_prompt = true;
            $message = "Participant not found.";
        }

        $stmt->close();
    } else {
        $show_prompt = true;
        $message = "Please enter both participant name and ID.";
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
    <title>Edit Participant - Clinical Trial Management System</title>
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
        .container form {
            display: <?php echo $participant ? 'block' : 'none'; ?>; /* Show form only if participant details are fetched */
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container form label {
            margin-bottom: 10px;
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
            width: 50%;
            padding: 12px; /* Increased button size */
            border: none;
            border-radius: 4px;
            background-color: #007bff; /* Blue background */
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container form button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
            display: <?php echo $show_success_message ? 'block' : 'none'; ?>; /* Show success message if update successful */
        }
        .prompt-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
            display: <?php echo $show_prompt ? 'block' : 'none'; ?>; /* Show prompt message if participant not found or incomplete input */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Participant</h1>

        <div class="prompt-message">
            <p><?php echo $message; ?></p>
        </div>

        <?php if (!$participant): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="name">Participant Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="participant_id">Participant ID:</label>
                <input type="number" id="participant_id" name="participant_id" required>

                <button type="submit">Search Participant</button>
            </form>
        <?php endif; ?>

        <?php if ($participant): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden" name="participant_id" value="<?php echo htmlspecialchars($participant['id']); ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($participant['name']); ?>" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($participant['age']); ?>" required>

                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="male" <?php echo ($participant['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo ($participant['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo ($participant['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
                </select>

                <label for="medical_history">Medical History:</label>
                <input type="text" id="medical_history" name="medical_history" value="<?php echo htmlspecialchars($participant['medical_history']); ?>">

                <label for="contact_information">Contact Information:</label>
                <input type="text" id="contact_information" name="contact_information" value="<?php echo htmlspecialchars($participant['contact_information']); ?>">

                <button type="submit" name="update_participant">Update Participant</button>
            </form>
        <?php endif; ?>

        <!-- Success message display -->
        <div class="success-message" style="<?php echo $update_success ? 'display: block;' : 'display: none;'; ?>">
            <p>Participant details updated successfully!</p>
        </div>

        <a class="back-link" href="manage_participants.php">Back</a>
    </div>
</body>
</html>
