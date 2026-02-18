<?php
// login.php
session_start(); // Start a session to store user data

// Include the database connection file
include 'connection.php';

$error = ""; // Variable to store error message
$success = ""; // Variable to store success message

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username, password, and role from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST["role"]) ? $_POST["role"] : '';

    // Prepare SQL query to check if the user with the selected role exists
    $stmt = $conn->prepare("SELECT * FROM user_table WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, set a success message and session variables
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Set patient_id only if the user is a patient
        if ($role == 'patient') {
            $_SESSION['patient_id'] = $user['patient_id'];
        }

        $success = "Successfully connected";

        // Redirect based on role
        if ($role == 'admin') {
            header("Location: ad_view.php");
        } elseif ($role == 'patient') {
            header("Location: patientd.php");
        } elseif ($role == 'doctor') {
            header("Location: view_appointment_doctor.php");
        } elseif ($role == 'receptionist') {
            header("Location: receptionist_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username, password, or role";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Hospital Login</title>
    <style>
        /* General styles */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #4CAF50, #0070cd);
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Container */
        .login-container {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }

        /* Title */
        .login-container h2 {
            color: #0070cd;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            font-weight: bold;
        }

        /* Form styles */
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .login-container label {
            text-align: left;
            font-size: 0.9rem;
            color: #555;
            margin-top: 1rem;
        }

        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container select {
            padding: 0.8rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus,
        .login-container select:focus {
            border-color: #3F51B5;
            box-shadow: 0 0 8px rgba(63, 81, 181, 0.2);
        }

        .login-container input[type="submit"] {
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

        .login-container input[type="submit"]:hover {
            background-color: #303F9F;
        }

        /* Error and Success messages */
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
        
        .success-message {
            color: green;
            font-size: 0.9rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to ABC Hospital</h2>
        <form method="POST" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="role">Select Role:</label>
            <select name="role" id="role" required>
                <option value="" disabled selected>Select your role</option>
                <option value="admin">Admin</option>
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="receptionist">Receptionist</option>
            </select>

            <input type="submit" value="Login">
        </form>

        <?php 
        if ($success != "") { 
            echo "<p class='success-message'>$success</p>"; 
        } elseif ($error != "") { 
            echo "<p class='error-message'>$error</p>"; 
        }
        ?>
    </div>
</body>
</html>
