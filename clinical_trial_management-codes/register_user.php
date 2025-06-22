<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $medical_history = mysqli_real_escape_string($conn, $_POST['medical_history']);
    $contact_information = mysqli_real_escape_string($conn, $_POST['contact_information']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Store password in plain text

    // Prepare SQL statement to insert data into 'participant' table
    $sql_insert_user = "INSERT INTO participant (name, age, gender, medical_history, contact_information, username, password)
                        VALUES ('$name', '$age', '$gender', '$medical_history', '$contact_information', '$username', '$password')";

    // Perform query execution
    if ($conn->query($sql_insert_user) === TRUE) {
        // Registration successful
        session_start();
        $_SESSION['user_id'] = $conn->insert_id; // Assign the new user's ID to session
        $_SESSION['role'] = 'participant'; // Assign the user's role to session

        // Display success message
        echo "<script>alert('Participant registration successful');</script>";

        // Redirect to participant dashboard
        header("Location: participant_dashboard.php");
        exit();
    } else {
        // Display error message if query fails
        echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
    }
} else {
    // Display error if POST data is not set
    echo "Error: Required POST data is missing.";
}

// Close database connection
$conn->close();
?>
