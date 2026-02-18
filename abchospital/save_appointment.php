<?php
// save_appointment.php

session_start();
include 'connection.php';  // Assumes 'connection.php' connects to your database

// Retrieve form data
$patient_id = $_POST['patient_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Insert data into the appointments table
$sql = "INSERT INTO appointment (patient_id, first_name, last_name, dob, phone, address) 
        VALUES ('$patient_id', '$first_name', '$last_name', '$dob', '$phone', '$address')";

if ($conn->query($sql) === TRUE) {
    // Redirect to view appointments page after successful insert
    header("Location: view_appointment.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
