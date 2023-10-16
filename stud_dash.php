<!DOCTYPE html>
<html>
<head>
    <title>View Residence Application status</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <style>
        /* Your CSS styles */
        /* ... */

        /* Added missing CSS for countdown */
        #countdown {
            background-color: #ff6347; /* Tomato red background color */
            color: #fff; /* White text */
            padding: 20px;
            margin: 20px auto;
            border-radius: 10px;
            text-align: center;
            font-family: 'Arial', sans-serif;
            font-size: 36px;
            font-weight: bold;
            animation: pulse 1s infinite alternate; /* Pulse animation */
        }

        /* Additional styles for countdown container */
        .countdown-container {
            text-align: center;
            margin-bottom: 20px;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.05);
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            background-image: url('student.jpg');
        }

        h1 {
            background-color: #ff5733; /* Reddish-Orange color */
            color: white;
            padding: 20px;
        }

        .dashboard-container {
            background-color: #ff9f43; /* Light Orange color */
            padding: 20px;
            width: 80%;
            margin: 0 auto;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
        }

        p {
            color: #333;
        }

        a {
            text-decoration: none;
            color: #ff5733; /* Reddish-Orange color */
        }

        .dashboard-button {
            background-color: #ff5733; /* Reddish-Orange color */
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 18px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div id="countdown">
        <div class="countdown-container">
            Applications closing in:
        </div>
    </div>

    <h1>View Residence Application</h1>
    <div class="dashboard-container">
        <?php
        // Assuming you have a session with StudentID after login
        session_start();
        if (isset($_SESSION['StudentID'])) {
            $student_id = $_SESSION['StudentID'];

            $servername = "localhost";
            $username = "root";  // Replace with your database username
            $password = "maumela17";  // Replace with your database password
            $dbname = "spu_res";

            // Create a connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL query (using prepared statements to prevent SQL injection)
            $sql = $conn->prepare("SELECT * FROM applications WHERE StudentID = ?");
            $sql->bind_param("i", $student_id);
            if ($sql->execute()) {
                $result = $sql->get_result();

                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Field</th><th>Value</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>Application No</td><td>" . $row["application_no"] . "</td></tr>";
                        echo "<tr><td>Student ID</td><td>" . $row["StudentID"] . "</td></tr>";
                        echo "<tr><td>Name</td><td>" . $row["Name"] . "</td></tr>";
                        echo "<tr><td>Gender</td><td>" . $row["gender"] . "</td></tr>";
                        echo "<tr><td>Application Status</td><td>" . $row["application_status"] . "</td></tr>";
                        echo "<tr><td>Room</td><td>" . $row["room"] . "</td></tr>";
                        echo "<tr><td>Preferred Residence</td><td>" . $row["PreferredResidence"] . "</td></tr>";
                        // Add more fields as needed
                    }
                    echo "</table>";
                } else {
                    echo "No application found for the provided Student ID.";
                }
            } else {
                echo "Error executing the query: " . $sql->error;
            }

            $sql->close();
            $conn->close();
        } else {
            echo "Please log in to view your application status.";
        }
        ?>
        </div>


<script>
    // Set the date we're counting down to (replace with your desired closing date)
    var countDownDate = new Date("Oct 19, 2023 15:37:25").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Calculate days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the countdown
        document.getElementById("countdown").innerText = `Applications closing in: ${days}d ${hours}h ${minutes}m ${seconds}s`;

        // Display a message when applications are closing soon
        if (distance < 86400000) { // Show the message if less than 1 day (86400000 milliseconds)
            document.getElementById("countdown").innerText = "Applications closing soon!";
        }

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerText = "EXPIRED";
        }
    }, 1000);
</script>
</body>
</html>

