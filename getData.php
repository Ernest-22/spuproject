<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your actual database username
$password = "maumela17"; // Replace with your actual database password
$dbname = "spu_res"; // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if StudentID is set and is a valid number
if (isset($_GET['StudentID']) && is_numeric($_GET['StudentID'])) {
    $studentID = $_GET['StudentID'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT application_no, StudentID, Name, gender, application_status, PreferredResidence, room FROM applications WHERE StudentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studentID); // "i" for integer

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $studentData = array(); // Initialize an array to hold the student data
            while ($row = $result->fetch_assoc()) {
                $studentData[] = $row; // Store each row of data in the array
            }

            // Encode student data as JSON and echo it
            echo json_encode($studentData);
        } else {
            echo "No data found for the StudentID.";
        }
    } else {
        echo "Query execution failed.";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Invalid or missing StudentID.";
}

// Close the connection
$conn->close();
?>
