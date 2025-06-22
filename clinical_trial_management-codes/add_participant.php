<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Participant - Clinical Trial Management System</title>
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
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container form label {
            margin-bottom: 10px;
        }
        .container form input[type="text"],
        .container form input[type="number"],
        .container form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .container form button {
            width: 100%; /* Full width button */
            padding: 15px; /* Increased padding */
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
        .container .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            padding: 8px 16px;
            border-radius: 4px;
            background-color: #f2f2f2;
            transition: background-color 0.3s ease;
        }
        .container .back-link:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Participant</h1>

        <form action="add_participant_process.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="medical_history">Medical History:</label>
            <input type="text" id="medical_history" name="medical_history">

            <label for="contact_information">Contact Information:</label>
            <input type="text" id="contact_information" name="contact_information">

            <button type="submit">Add Participant</button>
        </form>

        <a class="back-link" href="manage_participants.php">Back</a> <!-- Link to manage_participants.php -->

    </div>
</body>
</html>
