<?php
// Include database connection
include 'db_config.php';

// Initialize $data array
$data = array();

// Check if Email is provided in the URL
if(isset($_GET['Email'])) {
    $Email = trim($_GET['Email']); // Get the Email from the URL

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // SQL query to retrieve student data based on Email using a prepared statement
    $sql = "SELECT * FROM student WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Email); // Bind the email parameter to the SQL query
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Store the data in the $data array
        }
    } else {
        echo "No data found for the provided Email.";
    }

    $stmt->close();
} else {
    echo "Email not provided in the URL.";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="student_data.css">
</head>
<body>
    <div class="container">
        <h2>Student Data for <?php echo htmlspecialchars($Email); ?></h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>User Type</th>
            </tr>
            <?php 
            // Check if $data is not empty before iterating over it
            if (!empty($data)) {
                foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["ID"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["Email"]); ?></td>
                        <td><?php echo htmlspecialchars($row["PhoneNo"]); ?></td>
                        <td><?php echo htmlspecialchars($row["user_type"]); ?></td>
                    </tr>
                <?php endforeach; 
            } else {
                echo "<tr><td colspan='6'>No data found for the provided Email.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
