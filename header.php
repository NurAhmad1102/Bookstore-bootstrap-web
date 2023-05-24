<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <nav class="navbar navbar-expand-lg bg-light ">
      <div class="container-fluid ">
         <a class="navbar-brand" href="home.php">Shop <span class="text-success">Panel</span></a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="home.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link active" href="orders.php">Orders</a>
               </li>
               <li class="nav-item dropdown class=" dropdown-item"">
                  <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Profile
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                     <li><a class="dropdown-item" href="#">username : <span><?php echo $_SESSION['user_name']; ?></span></a></li>
                     <li><a class="dropdown-item" href="#">email : <span><?php echo $_SESSION['user_email']; ?></span></a></li>
                     <li><a class="dropdown-item" href="logout.php" class="delete-btn">logout</a></li>
                  </ul>
               </li>
            </ul>


            <div id="user-btn" class="fas fa-user">Cart &nbsp;</div>
            <div class="cart-qty">              
               <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number);
               ?>
               <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
            </div>

         </div>
      </div>
   </nav>



</header>

