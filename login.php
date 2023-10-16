<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Get the login credentials
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];  // Added user type

    // Your database credentials
    $servername = "localhost";
    $db_username = "root";
    $db_password = "maumela17";
    $dbname = "spu_res";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "SELECT * FROM ";

    // Choose the table based on the user type
    if ($userType == 'student') {
        $sql .= "users WHERE username='$username'";
    } elseif ($userType == 'staff') {
        $sql .= "staff WHERE username='$username'";
    } else {
        echo "Invalid user type";
        exit();
    }

    // Execute the SQL statement
    $result = $conn->query($sql);

    if ($result) {
        // Check if a row was returned
        if ($result->num_rows == 1) {
            // User found, check the password
            $row = $result->fetch_assoc();

            // Verify the password
            $hashedPassword = $row['password_hash'];
            if (password_verify($password, $hashedPassword)) {
                // Store studentID in the session
                session_start();
                $_SESSION['StudentID'] = $row['StudentID'];

                // Redirect to the appropriate dashboard using PHP header
                if ($userType == 'student') {
                    header("Location: stud_dash.php");
                    exit();
                } elseif ($userType == 'staff') {
                    header("Location: manager_dashboard.html");
                    exit();
                }
            } else {
                echo "Invalid username or password";
            }
        } else {
            echo "No user found with that username";
        }
    } else {
        echo "Error in SQL query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
</body>
</html>
