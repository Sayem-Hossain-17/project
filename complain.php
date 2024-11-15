<?php
// Database configuration
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
$studentName = isset($_POST['studentName']) ? $_POST['studentName'] : '';
$roomNo = isset($_POST['roomNo']) ? $_POST['roomNo'] : '';
$mobileNo = isset($_POST['mobileNo']) ? $_POST['mobileNo'] : '';
$studentEmail = isset($_POST['studentEmail']) ? $_POST['studentEmail'] : '';
$details = isset($_POST['details']) ? $_POST['details'] : '';
$complainDate = isset($_POST['complainDate']) ? $_POST['complainDate'] : '';

// Validate required fields
if (empty($studentName) || empty($roomNo) || empty($mobileNo) || empty($studentEmail) || empty($details)) {
    echo "Error: All fields are required.";
    exit();
}

// Sanitize inputs
$studentName = $conn->real_escape_string($studentName);
$roomNo = $conn->real_escape_string($roomNo);
$mobileNo = $conn->real_escape_string($mobileNo);
$studentEmail = $conn->real_escape_string($studentEmail);
$details = $conn->real_escape_string($details);
$complainDate = $conn->real_escape_string($complainDate);

// Use prepared statements to insert data
$sql = "INSERT INTO complain (studentName, roomNo, mobileNo, studentEmail, complainDate, details) 
        VALUES (?, ?, ?, ?, ?, ?)";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $studentName, $roomNo, $mobileNo, $studentEmail, $complainDate, $details);

// Execute the statement
if ($stmt->execute()) {
    echo "Complaint submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
