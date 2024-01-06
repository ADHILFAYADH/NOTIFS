<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>


<html>
<head>
  <link rel="stylesheet" href="css/3s.css">
    <style>
        body{ font: 14px sans-serif; }
        .container{ width: 360px; padding: 20px; }
    </style>
</head>
<body>

<div class="container">
<h2 class="title">Update Profile</h2>
<form method="POST" action="profile_process.php" enctype="multipart/form-data" onsubmit="return validateForm()">
  <div class="input-field username-field">
    <label for="fullname">Full Name</label>
    <input type="text" id="fullname" name="fullname" required>
  </div>
  <div class="input-field username-field">
    <label for="profilepic">Profile Picture (Max 2MB)</label>
    <input type="file" id="profilepic" name="profilepic" accept="image/jpeg,image/png,image/gif" required>
  </div>
  <div class="input-field username-field">
    <label for="dob">Date of Birth</label>
    <input type="date" id="dob" name="dob" required>
  </div>
  <div class="input-field username-field">
    <label for="year">Year</label>
    <select id="year" name="year" required>
      <option value="">Select Year</option>
      <option value="First Year">First Year</option>
      <option value="Second Year">Second Year</option>
      <option value="Third Year">Third Year</option>
      
    </select>
  </div>
  <div class="input-field username-field">
    <label for="department">Department</label>
    <select id="department" name="department" required>
      <option value="">Select Department</option>
      <option value="CS">Computer Science</option>
      <option value="BTHM">BTHM</option>
      <option value="MATHS & PHYSICS">MATHS & PHYSICS</option>
      <option value="BCOM">BCOM</option>
      <option value="BBA">BBA</option>
      <option value="PSY">PSYCHOLOGY</option>
      <option value="ENG">ENGLISH</option>
      <option value="ECO">ECONOMICS</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div> 

<script>
  function validateForm() {
    var fileInput = document.getElementById('profilepic');
    if (fileInput.files.length > 0) {
      var fileSize = fileInput.files[0].size; // in bytes
      var maxSize = 3 * 1024 * 1024; // 3MB in bytes
      if (fileSize > maxSize) {
        alert("Error: Profile picture size exceeds the limit of 3MB.");
        return false;
      }
    }
    return true;
  }
</script></body>
</html>
