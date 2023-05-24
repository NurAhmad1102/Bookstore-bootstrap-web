<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   <style>
      body {
         height: 100%;
      }

      .container-register {
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
      }
   </style>

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <!-- admin dashboard section starts  -->

   <section class="dashboard w-75 m-auto">

      <h1 class="title my-3">Dashboard</h1>

      <div class="d-flex justify-content-around flex-wrap py-2">

         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Pending</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">

                  <?php
                  $total_pendings = 0;
                  $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'Pending'") or die('query failed');
                  if (mysqli_num_rows($select_pending) > 0) {
                     while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                        $total_price = $fetch_pendings['total_price'];
                        $total_pendings += $total_price;
                     };
                  };
                  ?>

                  <p>Rp. <?php echo $total_pendings; ?>.00</p>
                  <footer class="blockquote-footer">Total Pending</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Completed</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">

                  <?php
                  $total_pendings = 0;
                  $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
                  if (mysqli_num_rows($select_pending) > 0) {
                     while ($fetch_pendings = mysqli_fetch_assoc($select_pending)) {
                        $total_price = $fetch_pendings['total_price'];
                        $total_pendings += $total_price;
                     };
                  };
                  ?>

                  <p>Rp. <?php echo $total_pendings; ?>.00</p>
                  <footer class="blockquote-footer">Completed Payment</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Orders</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">
                  <?php
                  $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                  $number_of_orders = mysqli_num_rows($select_orders);
                  ?>
                  <p><?php echo $number_of_orders; ?></p>
                  <footer class="blockquote-footer">Order placed</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Product</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">
                  <?php
                  $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                  $number_of_products = mysqli_num_rows($select_products);
                  ?>
                  <p><?php echo $number_of_products; ?></p>
                  <footer class="blockquote-footer">Product added</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Customer</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">
                  <?php
                  $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                  $number_of_users = mysqli_num_rows($select_users);
                  ?>
                  <p><?php echo $number_of_users; ?></p>
                  <footer class="blockquote-footer">Total Customer</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Admin</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">
                  <?php
                  $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                  $number_of_admins = mysqli_num_rows($select_admins);
                  ?>
                  <p><?php echo $number_of_admins; ?></p>
                  <footer class="blockquote-footer">Total Admin</footer>
               </blockquote>
            </div>
         </div>


         <div class="card mb-4" style="width: 18rem;">
            <div class="card-header">
               <h5>Account</h5>
            </div>
            <div class="card-body">
               <blockquote class="blockquote mb-0">
                  <?php
                  $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                  $number_of_account = mysqli_num_rows($select_account);
                  ?>
                  <p><?php echo $number_of_account; ?></p>
                  <footer class="blockquote-footer">Total account</footer>
               </blockquote>
            </div>
         </div>

      </div>
   </section>

   <!-- admin dashboard section ends -->



</body>

</html>