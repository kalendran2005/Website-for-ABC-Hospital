<?php
session_start();

// Check if the user is a patient
if ($_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'connection.php';

// Query to fetch the patient's appointments
$patient_id = $_SESSION['patient_id']; // Assuming you set patient_id in the session on login
$sql = "SELECT * FROM appointment WHERE patient_id = '$patient_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Appointments</title>
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
        <h2>Your Appointments</h2>
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
            include 'connection.php';

            $sql = "SELECT * FROM appointment";
            $results = mysqli_query($conn, $sql) ;
            
            if ($results && mysqli_num_rows($results) > 0) {
                while($row =mysqli_fetch_assoc($results)){
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
$conn->close();
?>
