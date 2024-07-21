<?php

include 'config.php';

if(isset($_POST['submit'])){
   
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND user_type = '$user_type'") or die('query failed');
   
   if(mysqli_num_rows($select_users) == 1){
      // User exists, proceed with password reset
      $user_row = mysqli_fetch_assoc($select_users);
      $name = $user_row['name'];
      $new_password = mysqli_real_escape_string($conn, $_POST['new_password']); // Get the new password from the form
      $hashed_password = md5($new_password); // Hash the new password

      mysqli_query($conn, "UPDATE `users` SET password = '$hashed_password' WHERE email = '$email'") or die('query failed');

      // Password reset successful message
      $message[] = 'Password reset successfully!';
      
      // Redirect to the login page after password reset
      header('location: login.php');
      exit; // Stop further execution
   } else {
      // User not found with provided email and user type combination
      $message[] = 'No user found with the provided email and user type combination.';
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
 
<div class="form-container">
   <form action="" method="post">
      <h3>Forgot Password Form</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="password" name="new_password" placeholder="Enter your new password" required class="box">
      <input type="submit" name="submit" value="Reset" class="btn">
   </form>
   <?php if(isset($message)) { ?>
      <div class="message">
         <?php foreach($message as $msg) { echo $msg . "<br>"; } ?>
      </div>
   <?php } ?>
</div>
</body>
</html>
