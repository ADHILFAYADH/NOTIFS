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
  


  </head>
  <body>
    <h1 class="sticky-heading">notifs.</h1><br>
    <div class="home">
      <nav class="nav">
        <div  class="navigation">
          
         

      </nav>
    </div>
    <br>
      <?php include 'profi.php'; ?>
      
      
    
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=63e102c807c57eb28524550a" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script><script src="https://assets.website-files.com/63e102c807c57eb28524550a/js/webflow.7453bf54f.js" type="text/javascript"></script>
  </body>

</html>