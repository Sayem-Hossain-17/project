<?php
// Include the database connection file
include 'db_config.php'; // Use the centralized connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if title and content are provided
    if (!empty($_POST['title']) && !empty($_POST['content'])) {
        
        // Sanitize and validate input data
        $adminID = trim($_POST['adminID']);
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);

        // Validate the title and content for any malicious input (optional)
        if (empty($adminID) || empty($title) || empty($content)) {
            echo "All fields are required!";
        } else {
            // Use prepared statements for security
            $stmt = $conn->prepare("INSERT INTO notices (adminID, title, content) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $adminID, $title, $content); // Bind parameters as strings

            // Execute the SQL statement
            if ($stmt->execute()) {
                echo "Notice uploaded successfully!";
            } else {
                echo "Error: " . $stmt->error; // Error message if something goes wrong
            }

            // Close the prepared statement
            $stmt->close();
        }
    } else {
        // If title or content are empty, display an error
        echo "Title and content are required!";
    }
} else {
    // If the request method is not POST, display a message
    echo "Invalid request method!";
}

// Close the database connection
$conn->close();
?>
