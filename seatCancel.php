<?php
// Include the database configuration
include 'db_config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $ID = $_POST['ID'];
    $checkOutDate = $_POST['checkOutDate'];

    // Validate ID (Check if it's numeric or not)
    if (!is_numeric($ID)) {
        die("Invalid ID format.");
    }

    // Prepare SQL to check if ID exists
    $sql_check_id = "SELECT * FROM student WHERE ID = ?";
    $stmt = $conn->prepare($sql_check_id);
    $stmt->bind_param("i", $ID);  // "i" means integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ID exists, proceed with checkout

        // Update allotment table with the checkout date
        $sql_update_allotment = "UPDATE allotment SET checkOutDate = ? WHERE ID = ?";
        $stmt_update_allotment = $conn->prepare($sql_update_allotment);
        $stmt_update_allotment->bind_param("si", $checkOutDate, $ID);  // "s" means string, "i" means integer
        if ($stmt_update_allotment->execute()) {
            // Update student table to mark as 'Non Residential Student'
            $sql_update_student = "UPDATE student SET user_type = 'Non Residential Student' WHERE ID = ?";
            $stmt_update_student = $conn->prepare($sql_update_student);
            $stmt_update_student->bind_param("i", $ID);
            if ($stmt_update_student->execute()) {
                echo "Check out successful!";
            } else {
                echo "Error updating student status: " . $stmt_update_student->error;
            }
        } else {
            echo "Error updating allotment: " . $stmt_update_allotment->error;
        }
    } else {
        echo "ID not found in the database.";
    }

    // Close the prepared statement
    $stmt->close();
    $stmt_update_allotment->close();
    $stmt_update_student->close();
}

// Close the connection
$conn->close();
?>
