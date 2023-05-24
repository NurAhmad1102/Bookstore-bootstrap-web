<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   <style>
    .order-page {
      min-height: 1000px; /* Set the desired minimum height */
    }
  </style>

</head>

<body>

<div class="order-page w-75 m-auto">

   <?php include 'header.php'; ?>

   <div class="bg-dark py-5">
      <div class="container px-4 px-lg-5 my-5">
         <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">List Order</h1>
            <p class="lead fw-normal text-white-50 mb-0"><a href="home.php">home</a> / order </p>
         </div>
      </div>
   </div>


   <h1 class="title my-3">Transaction</h1>

   </section>

   <section class="order-tab mb-5">
      <div class="card w-75 m-auto">
         <h5 class="card-header">Details order</h5>
         <div class="card-body">

            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($order_query) > 0) {
               while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>

                  <div class="box">
                     <p class="card-text"> Placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                     <p class="card-text"> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                     <p class="card-text"> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                     <p class="card-text"> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                     <p class="card-text"> Address : <span><?php echo $fetch_orders['address']; ?></span> </p>
                     <p class="card-text"> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                     <p class="card-text"> Items : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                     <p class="card-text"> Total price : <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                     <p class="card-text"> Payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'Pending') {
                                                                                    echo 'red';
                                                                                 } else {
                                                                                    echo 'green';
                                                                                 } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                  </div>
                  <hr><hr>
            <?php
               }
            } else {
               echo '<p class="empty">no orders placed yet!</p>';               
            }
            ?>            
            <a href="home.php" class="btn btn-primary mt-2">Find out</a>
         </div>
      </div>

   </section>
</div>

   <?php
   include('footer.php');
   ?>
   

</body>

</html>


 