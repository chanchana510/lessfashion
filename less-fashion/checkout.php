<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
   exit();
}

if(isset($_POST['order'])){

   $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
   $number = htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8');
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $method = htmlspecialchars($_POST['method'], ENT_QUOTES, 'UTF-8');

   $address = 'Flat No. ' . htmlspecialchars($_POST['flat'], ENT_QUOTES, 'UTF-8') . ', ' .
              htmlspecialchars($_POST['street'], ENT_QUOTES, 'UTF-8') . ', ' .
              htmlspecialchars($_POST['city'], ENT_QUOTES, 'UTF-8') . ', ' .
              htmlspecialchars($_POST['state'], ENT_QUOTES, 'UTF-8') . ', ' .
              htmlspecialchars($_POST['country'], ENT_QUOTES, 'UTF-8') . ' - ' .
              htmlspecialchars($_POST['pin_code'], ENT_QUOTES, 'UTF-8');

   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Order placed successfully!';
   }else{
      $message[] = 'Your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Your Orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items = []; // Initialize as an empty array
         $total_products = ''; // Initialize the variable

         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);

         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].')';
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            }
            $total_products = implode(', ', $cart_items); // Convert array to string after loop
      ?>
         <p> <?= htmlspecialchars($total_products, ENT_QUOTES, 'UTF-8'); ?> </p>
      <?php
         }else{
            echo '<p class="empty">Your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products, ENT_QUOTES, 'UTF-8'); ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Grand Total : <span>Rs.<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>Place Your Order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Your Name :</span>
            <input type="text" name="name" placeholder="Enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Your Number :</span>
            <input type="number" name="number" placeholder="Enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Your Email :</span>
            <input type="email" name="email" placeholder="Enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Payment Method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery</option>
               <option value="credit card">Credit Card</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Address Line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. Flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Address Line 02 :</span>
            <input type="text" name="street" placeholder="Street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" placeholder="City" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>State / Province :</span>
            <input type="text" name="state" placeholder="State / Province" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" placeholder="Country" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>ZIP Code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 56400" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Place Order">

   </form>

</section>

</body>
</html>














<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>