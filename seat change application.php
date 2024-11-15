<?php
// Include the database configuration file
include 'db_config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from POST request
    $studentEmail = $_POST["studentEmail"];
    $currentRoomNo = $_POST["currentRoomNo"];
    $preferredRoomNo = $_POST["preferredRoomNo"];

    // Prepare SQL statement using prepared statements
    $sql = "INSERT INTO seat_change_application (studentEmail, currentRoomNo, preferredRoomNo) 
            VALUES (?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters (s = string, d = double, i = integer)
    $stmt->bind_param("sss", $studentEmail, $currentRoomNo, $preferredRoomNo);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Application submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
