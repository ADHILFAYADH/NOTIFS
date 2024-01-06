
<div class="bodyx"> 
          
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

                

                $folder = 'profile_pictures/';
                $profilePic = $folder . $username . '.jpg';

                  
                 // Assuming you have fetched the `created_time` value from the database and stored it in a variable
                $createdTime = $row['created_at'];

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

echo '                <div class="time">' . $createdTime . '</div>';
echo '            </div>';
echo '        </div>';
echo '        <div class="text-content">';

if (!empty($event)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 18px; font-weight: bold;">' . $event . '</p>';
}

if (!empty($speaker)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px; "> Speaker: '. $speaker .' </p>';
}

if (!empty($host)) {
    echo '<p  style="font-family: Poppins, Arial, sans-serif; font-size: 15px; ">Hosted by: ' . $host . '</p>';
}

if (!empty($venue)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px; ">Venue: ' . $venue . '</p>';
}

if (!empty($starttime)) {
    echo '<p style="font-family: Poppins, Arial, sans-serif; font-size: 15px; ">Time: ' . $starttime . '</p>';
}

if (!empty($url)) {
  echo '<a style="font-family: Poppins, Arial, sans-serif; font-size: 15px;" href="' . $url . '">' . $url . '</a>';
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
      
</div>