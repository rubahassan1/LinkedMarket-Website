<?php
session_start();
include "config.php";

// Initialize variables
$catName;
$catalogID;

// Check if catName parameter is set and assign its value
if (isset($_GET['catName'])) {
    $catName = $_GET['catName'];
}

// Check if catalogID parameter is set and assign its value
if (isset($_GET['catalogID'])) {
    $catalogID = $_GET['catalogID'];
}

// Validate catalogID
if (!is_numeric($catalogID)) {
    die("Invalid catalog ID");
}

// Prevent SQL injection
$catName = mysqli_real_escape_string($con, $catName);
$catalogID = mysqli_real_escape_string($con, $catalogID);

// Perform insertion
$dbI = mysqli_query($con, "INSERT INTO category (catalogID, Name, NbOfProducts) VALUES ('$catalogID', '$catName', '0')")
or die("Error: Failed to insert category");
?>
