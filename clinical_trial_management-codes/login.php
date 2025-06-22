<?php
session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM $role WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (assuming plain text storage, which is not recommended)
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $role;

            switch ($role) {
                case 'participant':
                    header('Location: participant_dashboard.php');
                    exit();
                case 'researcher':
                    header('Location: researcher_dashboard.php');
                    exit();
                case 'admin':
                    header('Location: admin_dashboard.php');
                    exit();
                default:
                    die("Invalid role");
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
    $conn->close();
} else {
    die("Access denied. Method not allowed.");
}
?>
