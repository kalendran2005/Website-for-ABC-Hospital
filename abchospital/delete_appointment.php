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

    // Delete the appointment from the database
    $sql = "DELETE FROM appointment WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patient_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Appointment deleted successfully.'); window.location.href = 'view_appointments.php';</script>";
    } else {
        echo "<script>alert('Error deleting appointment.'); window.location.href = 'view_appointments.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Invalid appointment ID.'); window.location.href = 'view_appointments.php';</script>";
}

// Close the database connection
$conn->close();
?>
