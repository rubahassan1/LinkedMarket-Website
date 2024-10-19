<?php
// Start session
session_start();

// Include the database configuration file
include "config.php";

// Initialize $reqID variable
$reqID;

// Check if reqID is provided and set
if (isset($_GET['reqID'])) {
    // Sanitize user input to prevent SQL injection
    $reqID = mysqli_real_escape_string($con, $_GET['reqID']);
    $dbDelete = mysqli_query($con, "DELETE FROM product_requests WHERE pRequestID='$reqID'");
    if ($dbDelete) {
        echo "Done";
    } else {
        echo "Error: Unable to delete record.";
    }
} else {
    echo "Error: Request ID not provided.";
}
?>
