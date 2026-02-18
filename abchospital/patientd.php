<?php
session_start();
if ($_SESSION['role'] != 'patient') {
    header("Location: save_appointment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Appointment</title>
    <style>
        /* General styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4CAF50, #0070cd);
            color: #333;
        }

        /* Container */
        .appointment-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        /* Title */
        .appointment-container h2 {
            color: #0070cd;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: bold;
        }

        /* Form styles */
        .appointment-container form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .appointment-container label {
            text-align: left;
            font-size: 0.9rem;
            color: #555;
            margin-top: 1rem;
        }

        .appointment-container input[type="text"],
        .appointment-container input[type="date"],
        .appointment-container textarea {
            padding: 0.8rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .appointment-container input[type="text"]:focus,
        .appointment-container input[type="date"]:focus,
        .appointment-container textarea:focus {
            border-color: #3F51B5;
            box-shadow: 0 0 8px rgba(63, 81, 181, 0.2);
        }

        .appointment-container button[type="submit"] {
            margin-top: 1.5rem;
            padding: 0.8rem;
            background-color: #0070cd;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .appointment-container button[type="submit"]:hover {
            background-color: #303F9F;
        }

        /* Disabled field style */
        #patient_id {
            background-color: #f5f5f5;
            color: #888;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="appointment-container">
        <h2>Make an Appointment</h2>
        <form method="post" action="save_appointment.php">
            <label for="patient_id">Patient ID:</label>
            <input type="text" id="patient_id" name="patient_id">
            
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>
            
            <button type="submit">Schedule Appointment</button>
        </form>
    </div>
</body>
</html>
