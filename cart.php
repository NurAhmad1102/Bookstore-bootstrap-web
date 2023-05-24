<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['update_cart'])) {
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</head>

<body>
<div class="cart-page w-75 m-auto">
   
   <?php include 'header.php'; ?>

   <div class="bg-dark py-5 m-auto">
      <div class="container px-4 px-lg-5 my-5">
         <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Shopping cart</h1>
            <p class="lead fw-normal text-white-50 mb-0"><a href="home.php">home</a> / cart </p>
         </div>
      </div>
   </div>




   <section class="show-products d-flex justify-content-around flex-wrap ">
      <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select_cart) > 0) {
         while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
      ?>
            <div class="card my-3" style="width: 18rem;">
               <img class="card-img-top" src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
               <div class="card-body">
                  <h5 class="card-title"><?php echo $fetch_cart['name']; ?></h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
               </div>
               <ul class="list-group list-group-flush">
                  <li class="list-group-item">Rp. <?php echo $fetch_cart['price']; ?>.00</li>
                  <li class="list-group-item">Sub total : Rp. <?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>.00</li>

                  <li class="list-group-item">
                     <form action="" method="post" class="form-inline">
                        <div class="form-group mx-sm-4 mb-2">
                           <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                           <input type="number" class="form-control" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                        </div>
                        <div class="mx-auto" style="width: 170px;">
                           <input type="submit" class="btn btn-primary" name="update_cart" value="update" class="option-btn">

                           <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="btn btn-danger" onclick="return confirm('delete this from cart?');">remove</a>

                        </div>
                     </form>
                  </li>
               </ul>
            </div>
      <?php
            $grand_total += $sub_total;
         }
      } else {
         echo '<h3 class="empty mt-2 text-center">Cart empty</br> want to find something else?</h3>';
      }
      ?>
   </section>

   

   <div style="margin:1rem 0; text-align:center;">
      <a href="cart.php?delete_all" class="btn btn-danger <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');">Remove all</a>
   </div>

   <section class="d-flex justify-content-around flex-wrap my-3">
      <div class="card text-center w-75 " style="height: 200px">
         <div class="card-header">
            <h3>
               Cart orders
            </h3>

         </div>
         <div class="card-body">
            <h5 class="card-title">grand total : Rp. <?php echo $grand_total; ?>.00</h5>
            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. At, atque.</p>

            <a href="home.php" class="btn btn-primary px-3">Back</a>
            <a href="checkout.php" class="btn btn-success <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Checkout</a>

         </div>
      </div>
   </section>

</div>
   <?php
   include('footer.php');
   ?>


</body>

</html>