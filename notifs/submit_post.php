
<?php
  session_start();
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $event = $_POST['event'];
  $host = $_POST['host'];
  $speaker = $_POST['speaker'];
  $venue = $_POST['venue'];
  $starttime = $_POST['starttime'];
 
  $username = $_SESSION['username']; // Assuming you have a session variable for storing the logged-in username
  $postImage = $_FILES['image']['tmp_name'];
  $postImageType = $_FILES['image']['type'];
  $postImageName = $_FILES['image']['name'];
  $url = $_POST['url'];

  // Limit the post description to 200 characters
  if (strlen($event) > 100) {
    $description = substr($description, 0, 100);
  }

  // Check if an image file is selected
if (!empty($postImage)) {
  // Check image file size
  $maxFileSize = 4.2 * 1024 * 1024; // 4.2MB in bytes
  if ($_FILES['image']['size'] > $maxFileSize) {
      // Image file size exceeds the limit
      echo 'Error: Maximum image file size is 4.2MB.';
      exit;
  }

  $imageData = file_get_contents($postImage);
  $imageData = $db->real_escape_string($imageData);

  if (!empty($imageData)) {
      $sql = "INSERT INTO posts ( image, username,event,host,speaker,venue,starttime, image_type, image_name, url, created_at) 
              VALUES ( '$imageData', '$username', '$event','$host','$speaker','$venue','$starttime', '$postImageType', '$postImageName', '$url', NOW())";
  } else {
      $sql = "INSERT INTO posts (username,event,host,speaker,venue,starttime, url, created_at) 
              VALUES ('$username', '$event','$host','$speaker','$venue','$starttime', '$url', NOW())";
  }
} else {
  $sql = "INSERT INTO posts ( username,event,host,speaker,venue,starttime, url, created_at) 
          VALUES ('$username', '$event','$host','$speaker','$venue','$starttime', '$url', NOW())";
}

  if ($db->query($sql) === true) {
    echo 'Post created successfully.';
    header("location: index.php");
  } else {
    echo 'Error: ' . $db->error;
  }

  // Close the database connection
  $db->close();
}

?>
