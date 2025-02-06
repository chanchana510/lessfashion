<?php

error_reporting(0);
ini_set('display_errors', 0);

include 'components/connect.php';

session_start();


// Ensure user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:user_login.php');
    exit(); // Stop script execution after redirect
}

// Handling adding items to wishlist
if (isset($_POST['add_to_wishlist']) && !empty($user_id)) {
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ? AND product_id = ?");
    $check_wishlist->execute([$user_id, $product_id]);

    if ($check_wishlist->rowCount() > 0) {
        echo '<script>alert("Already added to wishlist!");</script>';
    } else {
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, product_id) VALUES (?, ?)");
        if ($insert_wishlist->execute([$user_id, $product_id])) {
            echo '<script>alert("Added to wishlist!");</script>';
        } else {
            echo '<script>alert("Error adding to wishlist!");</script>';
        }
    }
}

// Handling adding items to cart
if (isset($_POST['add_to_cart']) && !empty($user_id)) {
    $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ? AND product_id = ?");
    $check_cart->execute([$user_id, $product_id]);

    if ($check_cart->rowCount() > 0) {
        echo '<script>alert("Already added to cart!");</script>';
    } else {
        $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, product_id) VALUES (?, ?)");
        if ($insert_cart->execute([$user_id, $product_id])) {
            echo '<script>alert("Added to cart!");</script>';
        } else {
            echo '<script>alert("Error adding to cart!");</script>';
        }
    }
}

// Handling deletion of wishlist item
if (isset($_POST['delete']) && !empty($user_id)) {
    $wishlist_id = filter_var($_POST['wishlist_id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ? AND user_id = ?");
    $delete_wishlist_item->execute([$wishlist_id, $user_id]);
}

// Handling deletion of all wishlist items
if (isset($_GET['delete_all']) && !empty($user_id)) {
    $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
    if ($delete_wishlist_item->execute([$user_id])) {
        header('location:wishlist.php');
        exit();
    } else {
        echo '<script>alert("Error deleting wishlist!");</script>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Wishlist</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3 class="heading">Your Wishlist.</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $grand_total += $fetch_wishlist['price'];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
      <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="flex">
         <div class="price">Rs.<?= $fetch_wishlist['price']; ?>/-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <input type="submit" value="delete item" onclick="return confirm('delete this from wishlist?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>Grand Total : <span>Rs.<?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">Continue Shopping.</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from wishlist?');">delete all item</a>
   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>