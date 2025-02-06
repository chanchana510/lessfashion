<?php

include 'components/connect.php';

session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['send'])) {

   // Use FILTER_SANITIZE_SPECIAL_CHARS instead of deprecated FILTER_SANITIZE_STRING
   $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Use FILTER_SANITIZE_EMAIL for emails
   $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT); // Sanitize number correctly
   $msg = filter_var($_POST['msg'], FILTER_SANITIZE_SPECIAL_CHARS);

   // Check if the message already exists
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if ($select_message->rowCount() > 0) {
      $message[] = 'Message already sent!';
   } else {
      // Insert the message into the database
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Message sent successfully!';
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Get in touch.</h3>
      <input type="text" name="name" placeholder="enter your name" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="enter your email" required maxlength="50" class="box">
      <input type="number" name="number"  min="0" max="100000000000" placeholder="enter your phone number" required onkeypress="if(this.value.length == 10) return true;" class="box">
      <textarea name="msg" class="box" placeholder="enter your message" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>