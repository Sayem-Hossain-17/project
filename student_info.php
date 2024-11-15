<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #7F7FD5, #86A8E7, #91EAE4);
        }

        .container {
            max-width: 990px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        .search-form {
            text-align: right;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #4CAF50;
            color: #fff;
            text-transform: uppercase;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        .no-results {
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Information</h2> 
        <div class="search-form">
            <form action="search.php" method="GET">
                <input type="text" name="ID" placeholder="Enter ID">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>User Type</th>
                    <th>Room No</th>
                    <th>Check In Date</th>
                    <th>Check Out Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include database connection
                include 'db_config.php';

                // Query to retrieve student information with corresponding allotment details using a JOIN
                $sql = "SELECT s.*, a.roomNo, a.checkInDate, a.checkOutDate 
                        FROM student s
                        LEFT JOIN allotment a ON s.ID = a.ID";

                // Execute the query
                $result = $conn->query($sql);

                // Check if results are available
                if ($result->num_rows > 0) {
                    // Loop through the results and display them
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["ID"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["PhoneNo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["user_type"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["roomNo"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["checkInDate"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["checkOutDate"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no results found
                    echo "<tr><td colspan='8' class='no-results'>No results found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
