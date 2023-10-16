<?php
// Connect to your MySQL database
$servername = "localhost";
$username = "root";
$password = "maumela17";
$dbname = "spu_res";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve the student name from the POST request
$studentName = $_POST['Name'];

// Query the database to get the student's information
$sql = "SELECT * FROM students WHERE name = '$studentName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Student found, perform room allocation logic (replace this with your allocation logic)
  $row = $result->fetch_assoc();
  $allocatedRoom = allocateRoomLogic($row); // Implement your room allocation logic

  // Update the response message
  $response = array('message' => "Room allocated for $studentName. Allocated Room: $allocatedRoom");
} else {
  $response = array('message' => "Student '$studentName' not found.");
}

// Send the response as JSON
echo json_encode($response);

$conn->close();

// Implement your room allocation logic based on student information
function allocateRoomLogic($studentData) {
  // Replace this with your actual room allocation logic
  // For demonstration purposes, we'll just return a hardcoded room
  return 'Room A101';
}
?>
