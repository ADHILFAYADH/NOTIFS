<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
// Database Connection
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'notifs';

$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve form data
  $fullname = $_POST['fullname'];
  $profilepic = $_FILES['profilepic']['name'];
  $dob = $_POST['dob'];
  $year = $_POST['year'];
  $department = $_POST['department'];
  $username = $_SESSION['username']; // Assuming you have a session variable for storing the logged-in username
  $postImageType = $_FILES['profilepic']['type'];
  $postImageName = $_FILES['profilepic']['name'];

  // Date of Birth validation
  if (!validateDate($dob)) {
    echo "Error: Invalid date of birth.";
    exit;
  }

  // Insert data into the profile database
  $sql = "INSERT INTO profile (username, fullname, profilepic, dob, year, department,image_type,image_name)
          VALUES ('$username', '$fullname', '$profilepic', '$dob', '$year', '$department','$postImageType','$postImageName')";
  if ($db->query($sql) === true) {
    // Rename and move the uploaded profile picture to a desired location
    $targetDir = 'profile_pictures/';
    $username = $_SESSION['username'];
    $extension = strtolower(pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION));
    $targetFile = $targetDir . $username . '.' . $extension;
    move_uploaded_file($_FILES['profilepic']['tmp_name'], $targetFile);

    echo 'Profile created successfully.';
    header('profi.php');
} else {
    echo 'Error: ' . $db->error;
}

}

// Function to validate the date format (YYYY-MM-DD)
function validateDate($date) {
  $d = DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}

// Close the database connection
$db->close();
?>
