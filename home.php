<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   <style>
      .form-input {
         display: flex;
         justify-content: center;
         align-items: center;
      }
   </style>

</head>

<body>

<div class="home-page w-75 m-auto">

   <?php include 'header.php'; ?>

   <section class="home">

      <div class="bg-dark py-5">
         <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
               <h1 class="display-4 fw-bolder">Book in style</h1>
               <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
            </div>
         </div>
      </div>

   </section>

   <div class="title mt-5">
      <h1 class="title">list products</h1>
   </div>

   <section class="py-2 d-flex justify-content-around flex-wrap">

      <!-- Pagination -->
      <?php
      $limit_per_page = 6;
      $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
      $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

      $previous = $page - 1;
      $next = $page + 1;

      $row_user = mysqli_query($conn, "SELECT * FROM products ");
      $total_row_user = mysqli_num_rows($row_user);
      $total_page = ceil($total_row_user / $limit_per_page);


      $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT $first_page, $limit_per_page") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>

            <form action="" method="post">

               <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">


               <div class="container px-4 px-lg-5 mt-5">
                  <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 ">

                     <div class="col mb-5">
                        <div class="card h-100" style="width: 16rem;">

                           <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>

                           <img class="card-img-top" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="..." />

                           <div class="card-body p-4">
                              <div class="text-center">

                                 <h5 class="fw-bolder" ><?php echo $fetch_products['name']; ?></h5>


                                 <span class="text-muted">Rp. <?php echo $fetch_products['price']; ?>.00</span>
                                 <div class="form-input">
                                    <input type="number" min="1" name="product_quantity" value="1" class="form-control input-sm mt-2 w-75">
                                 </div>

                              </div>
                           </div>
                           <!-- Product actions-->
                           <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                              <div class="text-center">
                                 <input type="submit" value="add to cart" name="add_to_cart" class="btn btn-primary">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
      <?php
         }
      } else {
         echo '<p class="empty">All product have sold out</p>';
      }
      ?>



   </section>

   <nav class="mt-3">
      <ul class="pagination justify-content-center">
         <li class="page-item">
            <a class="page-link" <?php if ($page > 1) {
                                    echo "href='?page_no=$previous'";
                                 } ?>>Previous</a>
         </li>
         <?php
         for ($x = 1; $x <= $total_page; $x++) {
         ?>
            <li class="page-item"><a class="page-link" href="?page_no=<?php echo $x ?>"><?php echo $x; ?></a></li>
         <?php
         }
         ?>
         <li class="page-item">
            <a class="page-link" <?php if ($page < $total_page) {
                                    echo "href='?page_no=$next'";
                                 } ?>>Next</a>
         </li>
      </ul>
   </nav>


   



   <section class="about">

      <div class="flex">


         <div class="content">
            <h3>about us</h3>
            <p>Information about us (0000-0000-0000)</p>
            <p>about_us@gmaill.eu</p>

         </div>

      </div>

   </section>
</div>

   <?php
   include('footer.php');
   ?>



</body>

</html>
