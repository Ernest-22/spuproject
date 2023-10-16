<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'maumela17';
$db_name = 'spu_res';

// Create a connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Escape the inputs to prevent SQL injection
    $studentID = mysqli_real_escape_string($conn, $data->studentID);
    $newStatus = mysqli_real_escape_string($conn, $data->newStatus);

    // Update the application status in the database
    $sql = "UPDATE applications SET application_status = '$newStatus' WHERE StudentID = '$studentID'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Record updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating record: " . $conn->error));
    }
}

$conn->close();
?>
