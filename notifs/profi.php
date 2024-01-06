<?php
// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Include the database connection code
include "config.php";

// Retrieve user data from the profile table
$userId = $_SESSION["id"];
$query = "SELECT * FROM profile WHERE id = $userId";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Get the user data from the profile table
    $username = $_SESSION["username"];
    
    $name = $row["fullname"];
    $dept = $row['department'];
    $year = $row['year'];                              
} else {
    // If no profile data found, set default values
    $username = $_SESSION["username"];
    
}
$profilePicture = "profile_pictures/default.jpg";
// Retrieve the number of posts from the users table
$query = "SELECT number_of_posts, created_at FROM users WHERE id = $userId";
$result = mysqli_query($db, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Get the number of posts
    $numPosts = $row["number_of_posts"];
    $joinedDate = $row["created_at"];
    $formattedJoinedDate = date('d-m-Y H:i', strtotime($joinedDate));

} else {
    // If no post data found, set default value
    $numPosts = 0;
    $joinedDate = "Not available";
}

// Close the database connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="profi.css">
</head>
<body style="background-color: black;">
    <?php include 'header.html'; ?>
    
    <figure class="fir-image-figure" style="border: 1px solid white; padding: 10px; border-radius:8px; ">
        <?php
        $folder = 'profile_pictures/';
        $imageSrc = $folder . $username . '.jpg' ;
        
        // Check if the profile picture exists
        if (file_exists($imageSrc)) {
            echo '<img class="fir-author-image fir-clickcircle" src=" '. $imageSrc .'" alt="Profile picture"  style="width: 150px; height: 150px;">';
        } 
        else {
            echo '<a href="profile.php"><img class="fir-author-image fir-clickcircle" src="profile_pictures/default.jpg" alt="Profile picture"></a>"';
        }
        ?>

        <div  ></div>
        <figcaption >
            <div class="fig-author-figure-title" style="border: 1px solid white; padding: 4px; border-radius:8px;margin: 8px 0; " ><b>@<?php echo $username ?></b></div>
            <div class="fig-author-figure-title" style="border: 1px solid white; padding: 4px; border-radius:8px;margin: 8px 0; " >Fullname:<b><?php echo $name ?></b></div>
            <div class="fig-author-figure-title" style="border: 1px solid white; padding: 4px; border-radius:8px;margin: 8px 0; ">USERID: <?php echo $userId?></div>
           
            <div class="fig-author-figure-title" style="border: 1px solid white; padding: 4px; border-radius:8px;margin: 8px 0;" >You joined on <?php echo $formattedJoinedDate ?> </div>
            <div class="fig-author-figure-title" style="border: 1px solid white; padding: 4px; border-radius:8px;margin: 8px 0; ">You have <?php echo $numPosts ?> Posts.</div>
            <a style=" padding: 10px;margin: 0px 0;" href="userpost.php"><input type="button" style="width:80px; padding:10px;border-radius:8px" value="All Posts"  ></a>
        </figcaption>
        
    </figure><br>
    
</body>
</html>
