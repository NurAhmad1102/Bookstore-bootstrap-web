<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_POST['update_order'])) {

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment', admin_id = '$admin_id' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'payment status has been updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
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


</head>

<body>
   

   <?php include 'admin_header.php'; ?>

   <section class="orders w-75 m-auto">

      <h1 class="title my-3">Pending orders</h1>

      <div class="container-card d-flex justify-content-around flex-wrap">

         <?php
         $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status='Pending' ") or die('query failed');
         if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
         ?>
               <div class="card " style="width: 18rem;">
                  <div class="card-header ">
                     <h4>Order</h4>
                  </div>
                  <div class="order-form">
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item">user id : <?php echo $fetch_orders['user_id']; ?></li>
                        <li class="list-group-item">placed on : <span><?php echo $fetch_orders['placed_on']; ?></span></li>
                        <li class="list-group-item">name : <span><?php echo $fetch_orders['name']; ?></span></li>
                        <li class="list-group-item">number : <span><?php echo $fetch_orders['number']; ?></span></li>
                        <li class="list-group-item">email : <span><?php echo $fetch_orders['email']; ?></span></li>
                        <li class="list-group-item">address : <span><?php echo $fetch_orders['address']; ?></span></li>
                        <li class="list-group-item">total products : <span><?php echo $fetch_orders['total_products']; ?></span></li>
                        <li class="list-group-item">total price : <span>Rp. <?php echo $fetch_orders['total_price']; ?>.00</span></li>
                        <li class="list-group-item">payment method : <span><?php echo $fetch_orders['method']; ?></span></li>
                     </ul>

                     <form action="" method="post">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                        <select class="form-select" name="update_payment" aria-label="Default select example">
                           <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                           <option value="Pending" selected>Pending</option>
                           <option value="Completed">Completed</option>
                        </select>
                        <div class="button my-2 ms-2">
                           <input type="submit" class="btn btn-primary btn-sm" value="update" name="update_order">
                           <a class="btn btn-danger btn-sm" href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');">delete</a>
                        </div>
                     </form>

                  </div>


               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no pending orders yet!</p>';
         }
         ?>
      </div>

   </section>





   <section class="users w-75 m-auto my-5">

      <h1 class="title"> Completed payment </h1>

      <div class="container-users">

         <table class="table table-hover">

            <thead>
               <tr>
                  <th scope="col">No</th>
                  <th scope="col">ID Users</th>
                  <th scope="col">Username</th>
                  <th scope="col">Number</th>
                  <th scope="col">Email</th>
                  <th scope="col">Payment</th>
                  <th scope="col">Approved</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <?php

            $limit_per_page = 10;
            $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
            $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

            $previous = $page - 1;
            $next = $page + 1;

            $row_user = mysqli_query($conn, "SELECT * FROM orders ");
            $total_row_user = mysqli_num_rows($row_user);
            $total_page = ceil($total_row_user / $limit_per_page);

            $select_users = mysqli_query($conn, "SELECT orders.*, users.name FROM `orders` INNER JOIN users ON orders.admin_id = users.log_id WHERE payment_status = 'Completed' LIMIT $first_page, $limit_per_page") or die('query failed');
            $no = $first_page + 1;
            if (mysqli_num_rows($select_users) > 0) {
               while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                  <tbody>
                     <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $fetch_users['user_id']; ?></td>
                        <td><?php echo $fetch_users['name']; ?></td>
                        <td><?php echo $fetch_users['number']; ?></td>
                        <td><?php echo $fetch_users['email']; ?></td>
                        <td><?php echo $fetch_users['payment_status']; ?></td>
                        <td><?php echo $fetch_users['name']; ?></td>
                        <td>
                           <form action="" method="Post">
                              <input type="hidden" name="order_id" value="<?php echo $fetch_users['id']; ?>">
                              <a class="btn btn-danger btn-sm" href="admin_orders.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this order?');">Cancel</a>
                           </form>
                        </td>
                     </tr>
                  </tbody>

            <?php

               };
            };
            ?>
         </table>

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
      </div>

   </section>

</body>

</html>