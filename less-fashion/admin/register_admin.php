<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
   exit(); // Added exit() to stop further execution after redirection
}

if (isset($_POST['submit'])) {

   // Using FILTER_SANITIZE_SPECIAL_CHARS instead of deprecated FILTER_SANITIZE_STRING
   $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);

   // Hashing the password securely
   $pass = sha1($_POST['pass']); 
   $cpass = sha1($_POST['cpass']); 

   // Check if the username already exists
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if ($select_admin->rowCount() > 0) {
      $message[] = 'Username already exists!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirm password does not match!';
      } else {
         // Store hashed password in the database
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $pass]); // Use $pass instead of $cpass
         $message[] = 'New admin registered successfully!';
      }
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>