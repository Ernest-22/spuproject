<?php
$servername = "localhost";
$username = "root";
$password = "maumela17";
$dbname = "spu_res"; // Database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data, handling potential errors
$StudentID = isset($_POST['StudentID']) ? $_POST['StudentID'] : '';
$Name = isset($_POST['Name']) ? $_POST['Name'] : '';
$ContactInformation = isset($_POST['ContactInformation']) ? $_POST['ContactInformation'] : '';
$gender = isset($_POST['Gender']) ? $_POST['Gender'] : '';
$PreferredResidence = isset($_POST['PreferredResidence']) ? $_POST['PreferredResidence'] : '';
$Program = isset($_POST['Program']) ? $_POST['Program'] : '';

// Escape values to prevent SQL injection
$StudentID = mysqli_real_escape_string($conn, $StudentID);
$Name = mysqli_real_escape_string($conn, $Name);
$ContactInformation = mysqli_real_escape_string($conn, $ContactInformation);
$gender = mysqli_real_escape_string($conn, $gender);
$PreferredResidence = mysqli_real_escape_string($conn, $PreferredResidence);
$program = mysqli_real_escape_string($conn, $Program);
// SQL query to insert data into the students table
$sql_students = "INSERT INTO students (StudentID, Name, ContactInformation, gender, PreferredResidence, program)
                 VALUES ('$StudentID', '$Name', '$ContactInformation', '$gender', '$PreferredResidence', '$program')";


if ($conn->query($sql_students) === TRUE) {
    // Student record added successfully
    // Now, insert into the applications table

    // SQL query to insert data into the applications table
    $sql_applications = "INSERT INTO applications (StudentID, Name, gender, PreferredResidence)
                         VALUES ('$StudentID', '$Name', '$gender', '$PreferredResidence')";

    if ($conn->query($sql_applications) === TRUE) {
        echo "APPLICATION SUCCESSFUL!!! .";
    } else {
        echo "Error: " . $sql_applications . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_students . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>



