<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Database connection
$conn = new mysqli("localhost", "root", "", "cim_system2");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if cas_no is set
if (isset($_GET['cas_no'])) {
    $cas_no = intval($_GET['cas_no']);

    // Delete query
    $query = "DELETE FROM chemicals WHERE cas_no = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cas_no);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Chemical entry deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete the chemical entry.";
    }

    $stmt->close();
}

// Close the connection
$conn->close();

// Redirect back to the view details page
header('Location: view_details.php');
exit;
?>
