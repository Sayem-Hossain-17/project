<?php
// Include the database configuration file
include 'db_config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection (optional now with prepared statements)
    $studentName = $_POST['studentName'];
    $studentId = $_POST['studentId'];
    $hallName = $_POST['hallName'];
    $session = $_POST['session'];
    $gender = $_POST['gender'];
    $term = $_POST['term'];
    $applicationDate = $_POST['applicationDate'];
    $ygpa = $_POST['ygpa'];
    $address = $_POST['address'];
    
    // Check if the data already exists in the database using prepared statements
    $sql_check = "SELECT * FROM seat_application WHERE studentId=? AND term=? LIMIT 1";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $studentId, $term);  // "ss" indicates two string parameters
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows == 0) {
        // Data does not exist, insert into database using prepared statements
        $sql = "INSERT INTO seat_application (studentName, studentId, hall_name, session, gender, term, application_date, ygpa, address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssdds", $studentName, $studentId, $hallName, $session, $gender, $term, $applicationDate, $ygpa, $address); 
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // Data already exists, do not insert
        echo "Data already exists in the database";
    }

    $stmt_check->close();
    $stmt->close();
}

// Close the connection
$conn->close();
?>
