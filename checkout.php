<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['order_btn'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = mysqli_real_escape_string($conn,$_POST['number']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, $_POST['city'] . ', ' . $_POST['province'] . ' - ' . $_POST['postal']);
   $payment_status = mysqli_real_escape_string($conn, 'Pending');
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
         $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if ($cart_total == 0) {
      $message[] = 'your cart is empty';
   } else {
      if (mysqli_num_rows($order_query) > 0) {
         $message[] = 'order already placed!';
      } else {
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on', '$payment_status')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
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
   <title>checkout</title>


   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</head>

<body>

   <?php include 'header.php'; ?>


   <div class="bg-dark py-5">
      <div class="container px-4 px-lg-5 my-5">
         <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">checkout</h1>
            <p class="lead fw-normal text-white-50 mb-0"><a href="home.php">home</a> / checkout </p>
         </div>
      </div>
   </div>



   <section class="show-ordered">

      <div class="card w-75 my-5 m-auto">
         <div class="card-header">
            <h3>
               List order
            </h3>
         </div>
         <div class="card-body">
            <blockquote class="blockquote mb-0">

               <?php
               $grand_total = 0;
               $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                     $grand_total += $total_price;
               ?>
                     <p><?php echo $fetch_cart['name']; ?> <span>(<?php echo 'Rp' . $fetch_cart['price'] . '.00' . ' x ' . $fetch_cart['quantity']; ?>)</span></p>

               <?php
                  }
               } else {
                  echo '<p class="empty">your cart is empty</p>';
               }
               ?>
               <footer class="blockquote-footer">grand total : <span>Rp. <?php echo $grand_total; ?>.00</span> </cite></footer>
            </blockquote>
         </div>
      </div>

   </section>


   <section class="form-order">
      <div class="card w-75 m-auto mb-5">
         <div class="card-body">
            <h1>Order form</h1>
            <form action="" method="post">
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="inputName4">Name</label>
                     <input type="Text" class="form-control" id="inputName4" name="name" placeholder="Name" required>
                  </div>
                  <div class="form-group col-md-12">
                     <label for="inputNumber4">Number</label>
                     <input type="Number" class="form-control" id="inputNumber4" name="number" placeholder="Number phone" required>
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <label for="inputEmail4">Email</label>
                  <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email" required>
               </div>

               <div class="form-group col-md-12 ">
                  <label for="inputPayment">Payment method:</label>
                  <select id="inputPayment" class="form-control " name="method">
                     <option value="cash on delivery">cash on delivery</option>
                     <option value="credit card" selected>credit card</option>
                     <option value="e-wallet">e-wallet</option>
                     <option value="virtual account">virtual account</option>
                  </select>
               </div>

               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="inputCity">Address</label>
                     <input type="text" class="form-control" id="inputCity" name="city" placeholder="City" required>
                  </div>
                  <div class="form-group col-md-12">
                     <label for="inputProvince">Province</label>
                     <input type="text" class="form-control" id="inputProvince" name="province" placeholder="Province" required>
                  </div>
                  <div class="form-group col-md-2">
                     <label for="inputPostal">Postal code</label>
                     <input type="number" class="form-control" id="inputPostal" name="postal" required>
                  </div>
               </div>
               <input type="submit" value="Order" class="btn btn-primary mt-2" name="order_btn">
            </form>
         </div>
      </div>

   </section>

   <?php
   include('footer.php');
   ?>


</body>

</html>