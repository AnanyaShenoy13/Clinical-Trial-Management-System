<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['nameResearcher']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Store password in plain text
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $age = mysqli_real_escape_string($conn, $_POST['ageResearcher']);
    $role = 'researcher'; // Assign the role as 'researcher'

    // Check if the username already exists in researcher table
    $sql_check_username = "SELECT id FROM researcher WHERE username = '$username'";
    $result = $conn->query($sql_check_username);

    if ($result->num_rows > 0) {
        // Username already exists
        echo "Username already exists. Please choose a different username.";
    } else {
        // Prepare SQL statement to insert data into 'researcher' table
        $sql_insert_user = "INSERT INTO researcher (name, username, password, role, dob, age)
                            VALUES ('$name', '$username', '$password', '$role', '$dob', '$age')";

        // Perform query execution
        if ($conn->query($sql_insert_user) === TRUE) {
            // Registration successful
            session_start();
            $_SESSION['user_id'] = $conn->insert_id; // Assign the new user's ID to session
            $_SESSION['role'] = 'researcher'; // Assign the user's role to session

            // Display a success message (optional)
            echo "<script>alert('Researcher registration successful');</script>";

            // Redirect to researcher dashboard
            header("Location: researcher_dashboard.php");
            exit();
        } else {
            // Display error message if query fails
            echo "Error: " . $sql_insert_user . "<br>" . $conn->error;
        }
    }
} else {
    // Display error if POST data is not set
    echo "Error: Required POST data is missing.";
}

// Close database connection
$conn->close();
?>
