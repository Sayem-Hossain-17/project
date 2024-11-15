<?php
// Include database connection
include 'db_config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and trim any extra spaces
    $ID = isset($_POST["ID"]) ? trim($_POST["ID"]) : '';
    $Name = isset($_POST["Name"]) ? trim($_POST["Name"]) : '';
    $Email = isset($_POST["Email"]) ? trim($_POST["Email"]) : '';
    $PhoneNo = isset($_POST["PhoneNo"]) ? trim($_POST["PhoneNo"]) : '';
    $Password = isset($_POST["Password"]) ? trim($_POST["Password"]) : '';

    // Validate inputs (You can add more validation as per requirements)
    if (empty($ID) || empty($Name) || empty($Email) || empty($PhoneNo) || empty($Password)) {
        die("All fields are required.");
    }

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Validate phone number (Example: allowing only numeric, 10 digits phone number)
    if (!preg_match('/^[0-9]{10}$/', $PhoneNo)) {
        die("Invalid phone number format. Must be 10 digits.");
    }

    // Hash the password securely using bcrypt (password_hash with PASSWORD_DEFAULT)
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

    // Check if the user already exists in the database
    $sql = "SELECT * FROM student WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User already exists
        echo "The user already exists!";
    } else {
        // Insert the new user into the database
        $user_type = "Non Residential Student";  // Default user type

        $sql_insert = "INSERT INTO student (ID, Name, Email, PhoneNo, Password, user_type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssssss", $ID, $Name, $Email, $PhoneNo, $hashedPassword, $user_type);

        if ($stmt_insert->execute()) {
            echo "Welcome! Your account has been created successfully.";
            // Optionally, redirect to another page (e.g. the login page)
            // header("Location: login.php");
        } else {
            echo "Error: " . $stmt_insert->error;
        }

        $stmt_insert->close();
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the connection
$conn->close();
?>
