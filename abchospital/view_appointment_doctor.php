<?php
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is a doctor
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

// Query to fetch all appointments for viewing by the doctor
$sql = "SELECT patient_id, first_name, last_name, dob, phone, address FROM appointment";
$results = $conn->query($sql);

// Check for query errors
if (!$results) {
    die("Error in query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Patient Appointments</title>
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
        .table-container {
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Patient Appointments</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Phone Number</th>
                <th>Address</th>
            </tr>
            <?php
            // Display appointments if found
            if ($results && $results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['patient_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No appointments found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
