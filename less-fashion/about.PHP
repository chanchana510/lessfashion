<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/23.png" alt="">
      </div>

      <div class="content">
         <h3>Welcome to Less Fashion!</h3>
         <p>Founded in 2015, Less Fashion is a trusted clothing store with two branches located at Old Post Office Ethiliwewa, Wellawaya, and Haputale Road, Diyatalawa. We are passionate about bringing affordable, stylish, and high-quality fashion to our customers.

At Less Fashion, we believe in simplicity, elegance, and comfort. Our collection is carefully curated to offer the latest trends while maintaining timeless appeal. Whether you're looking for casual wear, formal outfits, or seasonal fashion, we have something for everyone.

Join us on our journey as we continue to grow and serve our customers with the best fashion at the best prices!</p>

         <p><a href="https://www.facebook.com/er.ashokbasnet" target="_blank">Less Fashion</a> follow us in facebook and other social medias. </p>
         <a href="contact.php" class="btn">Contact Us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Client's Reviews.</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/ishara.jpg" alt="">
         <p>I've been shopping at Less Fashion for years, and they never disappoint! The clothes are stylish, comfortable, and reasonably priced. Their collection always has something new and trendy. Highly recommended!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3> <a href="https://web.facebook.com/ISHARALiyanage00" target="_blank">_Ishara Liyanage</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/chamika.jpg" alt="">
         <p>Less Fashion truly values its customers. The staff is friendly and always ready to help. I recently bought a dress from their store, and they even helped me choose the perfect accessories. A great shopping experience!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://web.facebook.com/chamika.maduranga.9277" target="_blank">_Chamika Maduranga</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/chamod.jpg" alt="">
         <p>I love how Less Fashion keeps up with the latest trends while maintaining quality. Their store is well-organized, and it's easy to find what I need. I’ll definitely keep coming back for more.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://web.facebook.com/chamod.gunawardhna.5" target="_blank">_Chamod guwawardana</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/maleesha.jpg" alt="">
         <p>Less Fashion has everything I need, from casual wear to formal outfits. The fabric quality is excellent, and the designs are always trendy. I always receive compliments on my outfits from here!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="https://web.facebook.com/profile.php?id=100073615232782" target="_blank">_Maleesha Pravinath</a></h3>
      </div>

      <div class="swiper-slide slide">
         <img src="images/janani.jpg" alt="">
         <p>I love how stylish and comfortable the clothes from Less Fashion are. The prices are reasonable, and the collection is updated frequently. Shopping here is always a great experience!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3><a href="http://web.facebook.com/profile.php?id=61571115372733" target="_blank">_Janani Peiris</a></h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>