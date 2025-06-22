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
$name = $age = $gender = $medical_history = $contact_information = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $medical_history = mysqli_real_escape_string($conn, $_POST['medical_history']);
    $contact_information = mysqli_real_escape_string($conn, $_POST['contact_information']);

    // Check if participant already exists
    $check_sql = "SELECT * FROM participant WHERE name = '$name'";
    $check_result = $conn->query($check_sql);

    if ($check_result && $check_result->num_rows > 0) {
        // Participant with this name already exists
        echo "<script>alert('Participant with this name already exists.');</script>";
    } else {
        // Insert new participant into database
        $insert_sql = "INSERT INTO participant (name, age, gender, medical_history, contact_information)
                       VALUES ('$name', '$age', '$gender', '$medical_history', '$contact_information')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Participant added successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}

// Close database connection
$conn->close();
?>
