<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #7F7FD5, #86A8E7, #91EAE4);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: linear-gradient( #7F7FD5, #86A8E7, #91EAE4);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #1d1a63;
            text-align: center;
            margin-bottom: 20px;
        }

        .complaint {
            color: #155724; /* Dark green text color */
            background-color: #c3e6cb;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .complaint h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #155724;
        }

        .complaint p {
            margin: 0;
            color: #155724;
        }

        .complaint-details {
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            color: #155724;
        }

        .complaint-details p {
            margin: 0;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Complaints</h2>
        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "hall_management_system";

        // Establish connection
        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve data from the complain table
        $sql = "SELECT * FROM complain";
        $result = $conn->query($sql);

        // Check if there are any rows returned
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="complaint">';
                echo '<h3>Complaint ID: ' . $row["complainID"] . '</h3>';
                echo '<p><strong>Student Name:</strong> ' . $row["studentName"] . '</p>';
                echo '<p><strong>Room No:</strong> ' . $row["roomNo"] . '</p>';
                echo '<p><strong>Mobile No:</strong> ' . $row["mobileNo"] . '</p>';
                echo '<p><strong>Student Email:</strong> ' . $row["studentEmail"] . '</p>';
                echo '<p><strong>Complaint Date:</strong> ' . $row["complainDate"] . '</p>';
                echo '<div class="complaint-details">';
                echo '<p><strong>Details:</strong> ' . $row["details"] . '</p>';
                echo '</div></div>';
            }
        } else {
            echo "No complaints found.";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
