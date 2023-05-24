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

<style>
   .dropdown{
      margin-right: -50px;
   }
</style>

<header class="header w-75 m-auto">

   <nav class="navbar navbar-expand-lg bg-light ">
      <div class="container-fluid ">
         <a class="navbar-brand" href="admin_page.php">Admin<span> Panel</span></a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="admin_page.php">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link active" href="admin_products.php">Products</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link active" href="admin_orders.php">Orders</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link active" href="admin_users.php">Users</a>
               </li>
               <li class="nav-item dropdown" class="dropdown-item">
                  <a class="nav-link active dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Profile
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                     <li><a class="dropdown-item" href="#">username : <span><?php echo $_SESSION['admin_name']; ?></span></a></li>
                     <li><a class="dropdown-item" href="#">email : <span><?php echo $_SESSION['admin_email']; ?></span></a></li>
                     <li><a class="dropdown-item" href="logout.php" class="delete-btn">logout</a></li>
                  </ul>
               </li>
            </ul>
         </div>
      </div>
   </nav>
</header>