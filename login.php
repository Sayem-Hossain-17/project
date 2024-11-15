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

// Retrieve user inputs and validate
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $Password = isset($_POST['Password']) ? trim($_POST['Password']) : '';
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

    // Check if fields are empty
    if (empty($Email) || empty($Password) || empty($user_type)) {
        echo "Please fill in all the fields.";
        exit();
    }

    // Sanitize inputs
    $Email = $conn->real_escape_string($Email);

    if ($user_type == 'admin') {
        // Prepared statement for admin login
        $sql = "SELECT Email, Password FROM admin WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        
        // Check if statement was prepared successfully
        if ($stmt) {
            $stmt->bind_param("s", $Email);  // Bind the email parameter
            
            // Execute and fetch result
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Verify the password using password_verify (assuming password is hashed)
                if (password_verify($Password, $row['Password'])) {
                    // Redirect to admin page
                    header("Location: admin.html");
                    exit();
                } else {
                    echo "Invalid email or password for admin.";
                }
            } else {
                echo "Admin credentials are incorrect.";
            }
            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement for admin.";
        }
    } else {
        // If user is not admin, check the student table
        $sql = "SELECT Email, Password, user_type FROM student WHERE Email = ?";
        $stmt = $conn->prepare($sql);

        // Check if statement was prepared successfully
        if ($stmt) {
            $stmt->bind_param("s", $Email);  // Bind the email parameter
            
            // Execute and fetch result
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                
                // Verify the password using password_verify (assuming password is hashed)
                if (password_verify($Password, $row['Password'])) {
                    // Check if user type matches
                    if ($row['user_type'] == $user_type) {
                        // Redirect to the appropriate view page
                        if ($user_type == 'Residential Student') {
                            header("Location: rst_view.html?Email=" . urlencode($Email));
                            exit();
                        } elseif ($user_type == 'Non Residential Student') {
                            header("Location: non_rst_view.html?Email=" . urlencode($Email));
                            exit();
                        }
                    } else {
                        echo "Invalid user type.";
                    }
                } else {
                    echo "Invalid email or password.";
                }
            } else {
                echo "No such user found.";
            }
            $stmt->close();
        } else {
            echo "Failed to prepare the SQL statement for student.";
        }
    }
}

// Close connection
$conn->close();
?>
