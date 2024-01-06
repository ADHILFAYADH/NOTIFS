<?php
// approve_reject.php

// Include the config file to establish a database connection
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];

    // Perform appropriate action based on the button clicked
    if ($action === 'approve') {
        // Set the user status to 'approved'
        $query = "UPDATE users SET status = 'approved' WHERE id = $user_id";
        mysqli_query($db, $query);
    } elseif ($action === 'reject') {
        // Delete the user from the database
        $query = "DELETE FROM users WHERE id = $user_id";
        mysqli_query($db, $query);
    }

    // Redirect back to the admin panel page after the action is completed
    header("Location: admin_panel.php");
    exit();
}
?>
