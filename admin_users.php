<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE log_id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

   
</head>

<body>
   

      <?php include 'admin_header.php'; ?>

      <section class="users  w-75 m-auto">

         <h1 class="title"> user accounts </h1>

         <div class="container-users">

            <table class="table table-hover ">
               <thead>
                  <tr>
                     <th scope="col">No</th>
                     <th scope="col">ID Users</th>
                     <th scope="col">Username</th>
                     <th scope="col">Email</th>
                     <th scope="col">Role</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <?php

               $limit_per_page = 10;
               $page = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
               $first_page = ($page > 1) ? ($page * $limit_per_page) - $limit_per_page : 0;

               $previous = $page - 1;
               $next = $page + 1;

               $row_user = mysqli_query($conn, "SELECT * FROM users ");
               $total_row_user = mysqli_num_rows($row_user);
               $total_page = ceil($total_row_user/$limit_per_page);

               $select_users = mysqli_query($conn, "SELECT * FROM `users` LIMIT $first_page, $limit_per_page") or die('query failed');
               $no = $first_page + 1;
               while ($fetch_users = mysqli_fetch_assoc($select_users)) {
               ?>
                  <tbody>
                     <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $fetch_users['log_id']; ?></td>
                        <td><?php echo $fetch_users['name']; ?></td>
                        <td><?php echo $fetch_users['email']; ?></td>
                        <td><?php echo $fetch_users['user_type']; ?></td>
                        <td>
                           <a class="delete-btn" href="admin_users.php?delete=<?php echo $fetch_users['log_id']; ?>" onclick="return confirm('delete this user?');" >Remove</a>
                        </td>
                     </tr>
                  </tbody>
               <?php
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