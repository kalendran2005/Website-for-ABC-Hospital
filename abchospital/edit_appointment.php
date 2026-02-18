<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not admin
    exit();
}

// Include the database connection file
include 'connection.php';

// Check if the patient_id is provided in the URL
if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    // Fetch the appointment details from the database
    $sql = "SELECT * FROM appointment WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // If the form is submitted, update the appointment
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $dob = $_POST['dob'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Update the appointment in the database
        $sql = "UPDATE appointment SET first_name = ?, last_name = ?, dob = ?, phone = ?, address = ? WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);


        if ($stmt) {
            $stmt->bind_param("sssssi", $first_name, $last_name, $dob, $phone, $address, $patient_id);
            if ($stmt->execute()) {
                echo "<script>alert('Appointment updated successfully.'); window.location.href = 'view_appointments.php';</script>";
            } else {
                echo "<script>alert('Error updating appointment.');</script>";
            }
            $stmt->close(); // Only close if $stmt is valid
        } else {
            // Output SQL error if prepare fails
            die("Error preparing statement (UPDATE): " . $conn->error);
        }
    }
} else {
    echo "<script>alert('Invalid appointment ID.'); window.location.href = 'view_appointments.php';</script>";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            margin: 0;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Appointment</h2>
        <form method="post">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($appointment['first_name']); ?>" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($appointment['last_name']); ?>" required>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($appointment['dob']); ?>" required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($appointment['phone']); ?>" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($appointment['address']); ?>" required>

            <button type="submit">Update Appointment</button>
        </form>
    </div>
</body>
</html>
