<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "hall_management_system";

// Establish connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$ID = isset($_POST['ID']) ? $_POST['ID'] : '';
$roomNo = isset($_POST['roomNo']) ? $_POST['roomNo'] : '';
$checkInDate = isset($_POST['checkInDate']) ? $_POST['checkInDate'] : '';
$checkOutDate = isset($_POST['checkOutDate']) ? $_POST['checkOutDate'] : null; // Optional

// Input validation
if (empty($ID) || empty($roomNo) || empty($checkInDate)) {
    echo "Error: All fields except Check-Out Date are required.";
    exit();
}

// Sanitize inputs to prevent SQL injection
$ID = $conn->real_escape_string($ID);
$roomNo = $conn->real_escape_string($roomNo);
$checkInDate = $conn->real_escape_string($checkInDate);
if ($checkOutDate) {
    $checkOutDate = $conn->real_escape_string($checkOutDate);
}

// Check if the student exists in the database
$sql_user_type = "SELECT user_type FROM student WHERE ID = '$ID'";
$result_user_type = $conn->query($sql_user_type);

if ($result_user_type->num_rows > 0) {
    // Update user_type to "Residential Student"
    $sql_update_user_type = "UPDATE student SET user_type = 'Residential Student' WHERE ID = '$ID'";
    if ($conn->query($sql_update_user_type) === TRUE) {
        echo "User type updated to Residential Student successfully.<br>";
    } else {
        echo "Error updating user type: " . $conn->error . "<br>";
    }

    // Check if the student already has an allotment
    $sql_check = "SELECT * FROM allotment WHERE ID = '$ID'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // ID exists, update the existing record
        $stmt = $conn->prepare("UPDATE allotment SET roomNo = ?, checkInDate = ?, checkOutDate = ? WHERE ID = ?");
        $stmt->bind_param("sssi", $roomNo, $checkInDate, $checkOutDate, $ID);
        $action = "updated";
    } else {
        // ID does not exist, insert a new record
        $stmt = $conn->prepare("INSERT INTO allotment (ID, roomNo, checkInDate, checkOutDate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $ID, $roomNo, $checkInDate, $checkOutDate);
        $action = "inserted";
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "Allotment details " . $action . " successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: Student with ID $ID not found.";
}

// Close database connection
$conn->close();
?>