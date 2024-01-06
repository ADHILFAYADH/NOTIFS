<?php
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html >
  <head>

    <style>
      body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh; /* Ensures the content stretches to fill the viewport */
}

    </style>

    <meta charset="utf-8"/>
    <title>Notifs</title>
  
    

  <meta content="width=device-width, initial-scale=1" name="viewport"/>

  <link href="header1.css" rel="stylesheet" type="text/css"/>
  
  <style>
    /* START OF TWEET CARDS CSS */

.tweet-card-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.tweet-card {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  background-color: #fff;
  border-radius: 14px;
  padding: 20px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  margin-bottom: 20px;
  width: 350px;
}

.tweet-card .profile-pic {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
}

.tweet-card .header {
  display: flex;
  align-items: center;
  margin-bottom: 5px;
}

.tweet-card .author {
  font-weight: bold;
  margin-right: 5px;
  color: #000;
}

.tweet-card .time {
  color: #1292e7;
  font-size: 12px;
}

.tweet-card .text-content {
  margin-bottom: 10px;
  text-align: left;
}

.tweet-card .link {
  color: #007bff;
  text-decoration: none;
  margin-right: 5px;
}

.tweet-card .link:hover {
  text-decoration: underline;
}

.tweet-card .image-container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  padding-top: 133.33%; /* 3:4 aspect ratio (4 / 3 * 100) */
  position: relative;
  overflow: hidden;
  border-radius: 14px;
  margin-bottom: 10px;
}

.tweet-card .image-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Responsive styles */

/* For screens with width up to 768px */
@media (max-width: 768px) {
  .tweet-card {
    width: 100%; /* Cards take full width on smaller screens */
  }
}

/* For screens with width up to 576px */
@media (max-width: 576px) {
  .tweet-card-container {
    padding: 10px; /* Reduce container padding on smaller screens */
  }
}

/* END OF TWEET CARDS CSS */
</style>


  </head>
  <body style="background-color: black;">
    <h1 class="sticky-heading">notifs.</h1><br>
    <div class="home">
    
    <nav class="nav">
        <div  class="navigation">
          
          <a href="index.php" class="navigation-link w-inline-block">
            <img src="icons/home.png" loading="lazy" data-w-id="9dffbcfe-9fad-91f8-99ab-3bf0211c2bc6" alt="" class="navigation-icon"/>
            <div data-w-id="7ec63668-ab4b-1935-36c9-0a7d48bdfeec" class="link-spacer"></div>
            <div data-w-id="8b0e73b3-3528-b671-7ee9-c32e5293be24" class="navigation-text">Home</div>
          </a>
          <a href="posts.php" class="navigation-link w-inline-block">
            <img src="icons/pencil.png" loading="lazy" data-w-id="cdcdcf45-1968-ce98-4207-91ec890dda84" alt="" class="navigation-icon"/>
            <div data-w-id="06066af0-e5eb-19c8-d99d-c10aa3a2b658" class="link-spacer"></div>
            <div data-w-id="c72c2171-79d9-39fb-041b-6d922af9acec" class="navigation-text">Post</div>
          </a>
          <a href="proff.php" class="navigation-link w-inline-block">
            <img src="icons/user.png" loading="lazy" data-w-id="cdcdcf45-1968-ce98-4207-91ec890dda84" alt="" class="navigation-icon"/>
            <div data-w-id="06066af0-e5eb-19c8-d99d-c10aa3a2b658" class="link-spacer"></div>
            <div data-w-id="c72c2171-79d9-39fb-041b-6d922af9acec" class="navigation-text">Profile</div>
          </a>
          <a href="cano.php" class="navigation-link w-inline-block">
            <img src="icons/group.png" loading="lazy" data-w-id="cdcdcf45-1968-ce98-4207-91ec890dda84" alt="" class="navigation-icon"/>
            <div data-w-id="06066af0-e5eb-19c8-d99d-c10aa3a2b658" class="link-spacer"></div>
            <div data-w-id="c72c2171-79d9-39fb-041b-6d922af9acec" class="navigation-text">Users</div>
          </a>
          
          
          <a href="logout.php" class="navigation-link w-inline-block">
            <img src="icons/logout.png" loading="lazy" data-w-id="dc18bb42-525d-b42b-f794-33a8deea1893" alt="" class="navigation-icon"/>
            <div data-w-id="53fcbb3c-893d-f69d-d751-71835242cf04" class="link-spacer"></div>
            <div data-w-id="9952cdbb-00a5-1d35-eaab-6ef00e7c3998" class="navigation-text">Logout</div>
          </a>
          
          
        </div>
      </nav>
      
      
      <main class="main">
        
        <section id="hello" class="sectionx">
          
        <?php  
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'notifs';
        
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        
        
        $query = "SELECT * from posts ORDER BY posts.id DESC";
        $result = mysqli_query($db, $query);


        // Check if there are any posts
        if (mysqli_num_rows($result) > 0) {
            // Loop through each post
            while ($row = mysqli_fetch_assoc($result)) {
                $username = $row['username']; // Placeholder URL for profile picture
                $postedTime = ''; // Placeholder posted time
                $description = $row['description'];
                $url = $row['url'];
                $imageData = $row['image'];
                $event = $row['event'];
                $speaker = $row['speaker'];
                $host = $row['host'];
                $venue = $row['venue'];
                $starttime = $row['starttime'];

                list($day, $month, $year, $hour, $minute) = sscanf($starttime, "%d-%d-%d %d:%d");

                // Create DateTime object
                $datetimeObj = new DateTime();
                $datetimeObj->setDate($year, $month, $day);
                $datetimeObj->setTime($hour, $minute);

                $formattedDate = $datetimeObj->format('d-m-Y H:i');
              
                

                $folder = 'profile_pictures/';
                $profilePic = $folder . $username . '.jpg';

                  
                 // Assuming you have fetched the `created_time` value from the database and stored it in a variable
                $createdTime = $row['created_at'];
                $timestamp = strtotime($createdTime);

                

              // Format the date and month
              $formattedDateAndMonth = date('F j', $timestamp);
                // Convert the `created_time` timestamp to a Unix timestamp and multiply by 1000
                $createdTimestamp = strtotime($createdTime) * 1000;
                

                // Calculate the current time in milliseconds
                $currentTime = time() * 1000;
                

                // Calculate the time difference from the current time
                $timeDiff = $currentTime - $createdTimestamp;
                

                  // Convert the time difference into seconds, minutes, hours, days, or weeks
                  if ($timeDiff < 0 ) {
                      $postedTime = $timeDiff . " seconds ago";
                  } elseif ($timeDiff < 60) {
                      // Calculate the minutes and discard the remaining seconds
                      $minutes = floor($timeDiff/10 );
                      $postedTime = $minutes . " minutes ago";
                      echo $postedTime;
                  } elseif ($timeDiff < 3600) {
                      // Calculate the hours and discard the remaining minutes
                      $hours = floor($timeDiff / 3600);
                      $postedTime = $hours . " hours ago";
                  } elseif ($timeDiff < 604800) {
                      // Calculate the days and discard the remaining hours
                      $days = floor($timeDiff / 86400);
                      $postedTime = $days . " days ago";
                  } else {
                      // Calculate the weeks and discard the remaining days
                      $weeks = floor($timeDiff / 604800);
                      $postedTime = $weeks . " weeks ago";
                  }




                  // Display the calculated time difference
                  


            
                // Check if image data is available
            // Check if image data exists and create the image source
if (!empty($imageData)) {
  $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
} else {
  // Set $imageSrc to an empty string if there is no image data
  $imageSrc = '';
}

// Function to split text into rows of 100 characters each
if (!function_exists('splitTextIntoRows')) {
  function splitTextIntoRows($text, $rowLength = 52) {
      // Remove any return spaces from the input text
      $text = str_replace("\r\n", "\n", $text);
      $text = str_replace("\r", "\n", $text);

      // Split the text into words
      $words = explode(' ', $text);

      $rowTexts = [];
      $currentRow = '';

      foreach ($words as $word) {
          // Check if adding the current word exceeds the row length
          if (strlen($currentRow . $word) > $rowLength) {
              // If the word itself is longer than the row length, split it
              if (strlen($word) > $rowLength) {
                  $subWords = str_split($word, $rowLength);
                  foreach ($subWords as $subWord) {
                      $rowTexts[] = $currentRow;
                      $currentRow = $subWord . ' ';
                  }
              } else {
                  $rowTexts[] = $currentRow;
                  $currentRow = $word . ' ';
              }
          } else {
              $currentRow .= $word . ' ';
          }
      }

      // Add any remaining text to the rows
      if (!empty($currentRow)) {
          $rowTexts[] = $currentRow;
      }

      return $rowTexts;
  }
}

// Generate the HTML template for each post
echo '<div class="tweet-card-container">';
echo '    <div class="tweet-card" >';
echo '        <div class="header">';
echo '            <img src="' . $profilePic . '" alt="Profile Picture" class="profile-pic">';
echo '            <div>';
echo '                <div class="author" style="color: black;">@' . $username . '</div>';
echo '                <div class="time">' . $formattedDateAndMonth . '</div>';
echo '            </div>';
echo '        </div>';
echo '        <div class="text-content">';

if (!empty($event)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 18px;color: black; font-weight: bold;">' . $event . '</p>';
}

if (!empty($speaker)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px;color: black; "> Speaker: '. $speaker .' </p>';
}

if (!empty($host)) {
    echo '<p  style="font-family: Poppins, Arial, sans-serif; font-size: 15px;color: black; ">Hosted by: ' . $host . '</p>';
}

if (!empty($venue)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px;color: black; ">Venue: ' . $venue . '</p>';
}

if (!empty($starttime)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px;color: black; ">Time: ' . $starttime . '</p>';
}

if (!empty($url)) {
  echo '<a style="font-family: Poppins, Arial, sans-serif; font-size: 15px;color: #1292e7;" href="' . $url . '">' . $url . '</a>';
}

echo '        </div>';

if (!empty($imageSrc)) {
    echo '        <div class="image-container">';
    echo '            <img src="' . $imageSrc . '" alt="Post Image">';
    echo '        </div>';
}

echo '    </div>';
echo '</div>';
echo '<br>';

 



        }
      }
      ?>
      
        </section>  
          

        
      </main>
    </div>
    
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63e102c807c57eb28524550a" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script><script src="https://assets.website-files.com/63e102c807c57eb28524550a/js/webflow.7453bf54f.js" type="text/javascript"></script>
  </body>

</html>