<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
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
        }/* Your CSS styles go here */
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
                    echo "<td>" . htmlspecialchars($row["application_status"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["PreferredResidence"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Error: " . $conn->error . "</td></tr>";
            }

            $conn->close();
            ?>

        </table>

        <a href="manager_dashboard.html"><button class="dashboard-button">Back to Dashboard</button></a>
    </div>
</body>
</html>

