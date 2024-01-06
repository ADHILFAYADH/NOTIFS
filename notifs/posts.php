<?php

  session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upload Post</title>
  <link rel="stylesheet" href="header1.css">
  <style>
            body{
                font-family: sans-serif;
                display: block;
                text-align: center;
                justify-content: center;
                
            }
            
            .forms{
                display: inline-block;
                padding: 1em;
                border: 1px;
                border: 1px solid rgba(0, 0, 0, 0.5);
                border-radius: 5px;
                min-height: 40vh;
            }
            .inputs{
                padding: 1em;
                margin:0.5em 0;
                border-radius: 5px;
                border: 1px solid rgba(0, 0, 0, 0.5);
                width: 35ch;

            }
            .button-primary{
                padding: 1em;
                background-color: green;
                color: white;
                border:none;
                border-radius: 5px;
                margin: 10px 0
            }
            .textareas{
                resize: none;
                font-family: sans-serif;
            }

        </style>
</head>
<body style="background-color: black;">
<?php
        
        include 'header.html';
    ?>
  
  
    
    <form method="POST" action="submit_post.php" enctype="multipart/form-data" class="forms" style="background-color:white;">
    <h3>Upload Post</h3>
        
          <input type="text" placeholder="Event Title" name="event" class="inputs" maxlength="100" >
        <br>
        <input type="text" placeholder="Speaker" name="speaker" class="inputs" maxlength="100" >
        <br>
        <input type="text" placeholder="Hosted By" name="host" class="inputs" maxlength="100" >
        <br>
        <input type="text" placeholder="Venue" name="venue" class="inputs" maxlength="100" >
        <br>
        <input type="datetime-local" placeholder="Timing" name="starttime" class="inputs" >
        <br>
        <input type="url" placeholder="Share URL" id="url" class="inputs" name="url">
        <br>
        <input style="background-color:white;" type="file" placeholder="Upload Poster (Max file size: 1.5MB)" name="image" class="inputs" accept="image/*">
        <br>
      
        
        
      
        <input type="submit" value="Submit" class="button-primary">
     
    </form>
  
</body>
</html>
