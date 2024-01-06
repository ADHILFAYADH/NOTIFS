<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    

    if (isset($_POST["type"])) {
        // Retrieve the selected value from the select box
        $type = $_POST["type"];
    }
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a  email.";     
    } elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid Email Format.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmts = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmts, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmts)){
                /* store result */
                mysqli_stmt_store_result($stmts);
                
                if(mysqli_stmt_num_rows($stmts) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmts);
        }
    }
    


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(!filter_var(trim($_POST["email"])) ){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username,email,type, password) VALUES (?, ?,?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_username,$param_email,$type, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_email = $email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($db);
}
?>

<html>
    <head>
    <title>Register</title>

    

    <link rel="stylesheet" type="text/css" href="header1.css">

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
  font-size: 15px;
  letter-spacing: 1px;
  font-weight: 250;
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
  color: #333;
  font-weight: 800;
}

section .regcontainer .user .formBx form .signup a {
  font-weight: 800;
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

.selectdiv {
  position: relative;
  /*Don't really need this just for demo styling*/
  
  float: left;
  min-width: 200px;
  margin: -3 -9px 40px -4px;
  height: 15px;
  
  
  
}
select{
    border-radius: 9px;
}

/* IE11 hide native button (thanks Matt!) */
select::-ms-expand {
display: none;

}

option{
    border-radius: 9px;
}

.selectdiv:after {
  content: '<>';
  font: 17px "Consolas", monospace;
  color: #333;
  -webkit-transform: rotate(90deg);
  -moz-transform: rotate(90deg);
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
  right: 11px;
  background-color: #f5f5f5;
  border-radius: 9px;
  /*Adjust for position however you want*/
  
  top: 18px;
  padding: 0px 7px 0px 0px;
  
  /*left line */
  
  position: absolute;
  pointer-events: none;
}

.selectdiv select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  background-color: #f5f5f5;
  border-radius: 9px;
  /* Add some styling */
  
  display: flex;
  width: 100%;
  max-width: 320px;
  height: 50px;
  float: right;
  margin: -2px 9px;
  padding: 0px 10px ;
  font-size: 16px;
  line-height: 1.75;
  color: #333;
  
  
  background-image: none;
  border: 0px solid #cccccc;
  -ms-word-break: normal;
  word-break: normal;
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
    <?php include 'header.html'; ?>

    <section class="sectn">   
        <div class="regcontainer">
        <div class="user signinBx">
            <div class="imgBx"><img src="images/login_register_logo.jpeg" alt="Logo" /></div>
            <div class="formBx"> 

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h3>CREATE A NEW ACCOUNT</h3><br>

                    <?php 
                
                if(!empty($username_err)){
                    echo '<div class="alert alert-danger">'. $username_err. '</div><br>';
                }
                elseif(!empty($email_err)){
                            echo '<div class="alert alert-danger">'. $email_err. '</div><br>';
                }
                elseif(!empty($password_err)){
                            echo '<div class="alert alert-danger">'. $password_err. '</div><br>';
                }
                elseif(!empty($confirm_password_err)){
                            echo '<div class="alert alert-danger">'. $confirm_password_err. '</div><br>';
                }
                
                ?>

                    <div class="selectdiv">
                        <label>
                            <select name="type" id="type">
                                <option value="student" selected> Student </option>
                                <option value="moderator" >Moderator</option>
                                
                            </select>
                        </label>
                    </div><br>
                    <div class="input-field username-field">
                        
                        <input type="text" name="username" placeholder="Username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="input-field email-field">
                        
                        <input type="email" placeholder="Email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div> 
                    
                    <div class="input-field password-field">
                       
                        <input type="password" placeholder="Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="input-field confirm-password-field">
                        
                        <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="input-field">
                    <input type="submit" class="btn btn-primary" value="Submit">
                        
                    </div>
                    <p class="text-center" style="color: black;">Already have an account? <a href="login.php">Login </a>.</p>
                </form>

        </div>
        </div>
    



    </body>
<html>