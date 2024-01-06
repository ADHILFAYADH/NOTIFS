<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, status, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $status, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;  
                               
                            if ($status == 'approved') { // Use $status variable here
                                // Redirect user to welcome page
                                header("location: index.php");
                                exit;
                            } else {
                                // User exists, but registration is pending approval by the admin.
                                $login_err = "Admin Approval Pending";
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($db);
    }
}
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="header1.css">
    
    <style>

@import url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
.body{
    
    align-items: center;
    justify-content: center;
    background-color: #0e1015;
    display: flex;
    overflow: hidden;
}
span{
  display: none;
}

section {
  position: relative;
  min-height: 90vh;
  background-color: #0e1015;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
}

section .regcontainer {
  position: relative;
  width: 800px;
  height: 500px;
  background: #fff;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  border-radius: 5px;
}

section .regcontainer .user {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
}

section .regcontainer .user .imgBx {
  position: relative;
  width: 50%;
  height: 100%;
  background: white;
  transition: 0.5s;
}

section .regcontainer .user .imgBx img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

section .regcontainer .user .formBx {
  position: relative;
  width: 50%;
  height: 100%;
  background: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
  transition: 0.5s;
}

section .regcontainer .user .formBx form h2 {
  font-size: 18px;
  font-weight: 600;

  letter-spacing: 2px;
  text-align: center;
  width: 100%;
  margin-bottom: 10px;
  color: #555;
}

section .regcontainer .user .formBx form input {
  position: relative;
  width: 300px;
  padding: 10px;
  background: #f5f5f5;
  color: #333;
  border: none;
  outline: none;
  box-shadow: none;
  margin: 8px 0;
  font-size: 14px;
  letter-spacing: 1px;
  font-weight: 300;
  border-radius: 9px;
}

section .regcontainer .user .formBx form input[type='submit'] {
  max-width: 100px;
  background: #1DA1F2;
  color: #fff;
  cursor: pointer;
  font-size: 14px;
  font-weight: 500;
  letter-spacing: 1px;
  transition: 0.5s;
  border-radius: 9px;
}

section .regcontainer .user .formBx form .signup {
  position: relative;
  margin-top: 20px;
  font-size: 12px;
  letter-spacing: 1px;
  color: #555;
  font-weight: 300;
}

section .regcontainer .user .formBx form .signup a {
  font-weight: 600;
  text-decoration: none;
  color: #1DA1F2;
}

section .regcontainer .signupBx {
  pointer-events: none;
}

section .regcontainer.active .signupBx {
  pointer-events: initial;
}

section .regcontainer .signupBx .formBx {
  left: 100%;
}

section .regcontainer.active .signupBx .formBx {
  left: 0;
}

section .regcontainer .signupBx .imgBx {
  left: -100%;
}

section .regcontainer.active .signupBx .imgBx {
  left: 0%;
}

section .regcontainer .signinBx .formBx {
  left: 0%;
}

section .regcontainer.active .signinBx .formBx {
  left: 100%;
}

section .regcontainer .signinBx .imgBx {
  left: 0%;
}

section .regcontainer.active .signinBx .imgBx {
  left: -100%;
}

@media (max-width: 991px) {
  section .regcontainer {
    max-width: 400px;
  }

  section .regcontainer .imgBx {
    display: none;
  }

  section .regcontainer .user .formBx {
    width: 100%;
  }
}



    </style>
    </head>
    <body class="body">
      <?php include "header.html"; ?>

    <section class="sectn">
    <div class="regcontainer">
    <div class="user signinBx">
            <div class="imgBx"><img src="images/login_register_logo.jpeg" alt="Logo" /></div>
            <div class="formBx"> 
       

        

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>LOGIN</h3><br>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div><br>';
        } 
        elseif(!empty($username_err)){
            echo '<div class="alert alert-danger">'. $username_err. '</div><br>';
        }
        elseif(!empty($password_err)){
                    echo '<div class="alert alert-danger">'. $password_err. '</div><br>';
        }
        ?>
        
            <div >
                
                <input type="text" placeholder="Username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span ><?php echo $username_err; ?></span>
            </div>    
            <div >
                
                <input type="password" placeholder="Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span ><?php echo $password_err; ?></span>
            </div>
            <div class="input-field">
                    <input type="submit" class="btn btn-primary" value="Submit">
                        
                    </div>
                    <p class="text-center" style="color: black;">Don't have an account? <a href="register.php">Register </a>.</p>
                </form>
    </div>
</body>
</html>

