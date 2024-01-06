<?php
// admin_panel.php

// Include the config file to establish a database connection
require_once 'config.php';

// Assuming you have implemented user authentication, and the admin is logged in.

// Perform a database query to fetch pending users
$query = "SELECT * FROM users WHERE status = 'pending'";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <title>Notifs</title>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <link href="header1.css" rel="stylesheet" type="text/css"/>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h2{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include 'header.html'?>
    <h2>Pending User Registrations</h2>

    <!-- Display the table of pending users -->
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <form method="post" action="approve_reject.php">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="approve">Approve</button>
                        <button type="submit" name="action" value="reject">Reject</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
