<?php
session_start();

// Include the database connection file
include 'connection.php';

// Check if the user is an admin (assuming the role 'admin' is used)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in as admin
    exit();
}

// Query to fetch all appointments
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
    <title>Manage Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        .header {
            background-color: #0070cd;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .header nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .table-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .content {
            width: 90%;
            max-width: 1000px;
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
        .action-btn {
            padding: 6px 12px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #007BFF;
        }
        .delete-btn {
            background-color: #DC3545;
        }
        .action-btn a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h1>Welcome to ABC Hospital</h1>
        <nav>
            <a href="">Manage Appointments</a>
        </nav>
    </div>

    <!-- Table Container -->
    <div class="table-container">
        <div class="content">
            <h2>Appointments List</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Date of Birth</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
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
                        echo "<td><button class='action-btn edit-btn'><a href='edit_appointment.php?id=" . $row['patient_id'] . "'>Edit</a></button></td>";
                        echo "<td><button class='action-btn delete-btn'><a href='delete_appointment.php?id=" . $row['patient_id'] . "' onclick='return confirm(\"Are you sure you want to delete this appointment?\");'>Delete</a></button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>No appointments found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
