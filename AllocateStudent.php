<!DOCTYPE html>
<html>
<head>
    <title>AllocateStudentrooms</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #ff5733;
            color: white;
            padding: 20px;
        }

        .view-container {
            background-color: #ff9f43;
            padding: 20px;
            width: 90%;
            margin: 0 auto;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            overflow-x: auto;
        }

        .dashboard-button {
            background-color: #ff5733;
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
        }

        th, td {
            border: 1px solid #e1e1e1;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #ff5733;
            color: white;
        }

        .action-buttons button {
            padding: 5px 10px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>View Students</h1>
    <div class="view-container">
        <h2>List of Student Residence Applications</h2>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Application Status</th>
                <th>Preferred Residence</th>
                <th>Room</th>
                <th>Action</th>
            </tr>

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

            $sql = "SELECT * FROM applications";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["StudentID"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                    echo "<td id='status_" . htmlspecialchars($row["StudentID"]) . "'>" . htmlspecialchars($row["application_status"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PreferredResidence"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["room"]) . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<button onclick=\"updateStatus('" . htmlspecialchars($row["StudentID"]) . "', 'Pending', this)\">Pending</button>";
                    echo "<button onclick=\"updateStatus('" . htmlspecialchars($row["StudentID"]) . "', 'Approved', this)\">Approve</button>";
                    echo "<button onclick=\"updateStatus('" . htmlspecialchars($row["StudentID"]) . "', 'Rejected', this)\">Reject</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
            }
            
            $conn->close();
            
            ?>

        </table>

        <a href="manager_dashboard.html"><button class="dashboard-button">Back to Dashboard</button></a>
    </div>

    <script>
function updateStatus(studentID, newStatus, button) {
    // Update the application status in the UI
    const statusElement = document.getElementById('status_' + studentID);
    statusElement.textContent = newStatus;

    // Hide other buttons in the same row
    const row = button.parentElement.parentElement;
    const buttons = row.getElementsByClassName('action-buttons')[0].getElementsByTagName('button');
    for (let i = 0; i < buttons.length; i++) {
        if (buttons[i] !== button) {
            buttons[i].style.display = 'none';
        }
    }

    // Allocate a room and generate a room number if status is 'Approved'
    if (newStatus === 'Approved') {
        allocateRoom(studentID);
    }

    // Send the status update to the server
    const data = {
        studentID: studentID,
        newStatus: newStatus
    };

    fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        // Optionally, you can update the UI here if needed
    })
    .catch(error => console.error('Error:', error));
}

function allocateRoom(studentID) {
    console.log('Allocating room for student ID:', studentID);

    // Assume room number is based on residence and a random number
    const residences = ['R', 'S', 'T'];  // Add more residences as needed
    const randomResidence = residences[Math.floor(Math.random() * residences.length)];
    const randomRoomNumber = Math.floor(Math.random() * 1000) + 1;
    const roomNumber = randomResidence + randomRoomNumber;

    console.log('Allocated room number:', roomNumber);

    // Update the room number in the UI
    const roomElement = document.getElementById('room_' + studentID);
    roomElement.textContent = 'Room ' + roomNumber;
}


    </script>
</body>
</html>
