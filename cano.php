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
    <meta charset="utf-8"/>
    <title>Notifs</title>
  
    

  <meta content="width=device-width, initial-scale=1" name="viewport"/>

  <link href="header1.css" rel="stylesheet" type="text/css"/>
  

  <style>

  /* Table styles */
.post-table {
    width: auto;
    border-collapse: collapse;
    margin-top: 20px;
    justify-content: center;
    align-items: center;
    border: 2px solid white;
}
.tables{
  align-items: center;
  justify-content: center;
  display: flex;
}

.post-table th, .post-table td {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #ccc;
    border: 1px solid white;
    color: white;
}

.post-table th {
    font-weight: 900px;
    background-color: black;
    font-size: 20px;
    text-align: center;
}

.post-table tr:hover {
    background-color: black;
}
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

    </div>
      
    <br><br><br>
    <div class="tables">
        
      
    <?php  
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'notifs';
        
        $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        
        $query = "SELECT username, created_at FROM users ORDER BY id DESC";
        $result = mysqli_query($db, $query);
        echo '<br><br><br>';
        if ($result && mysqli_num_rows($result) > 0) {
            // Generate the HTML template for the table
            echo '<table class="post-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Username</th>';
            echo '<th>Created At</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
        
            // Loop through each row and generate the table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '</tr>';
            }
        
            echo '</tbody>';
            echo '</table>';
        }
        
            
              
          
                
            
        
    ?>      



  </div>   
  <br><br><br>
   
    
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63e102c807c57eb28524550a" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script><script src="https://assets.website-files.com/63e102c807c57eb28524550a/js/webflow.7453bf54f.js" type="text/javascript"></script>
  </body>

</html>