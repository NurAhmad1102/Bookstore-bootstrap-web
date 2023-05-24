<?php

include 'config.php';

if (isset($_POST['submit'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, ($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if (mysqli_num_rows($select_users) > 0) {
      $message[] = 'user already exist!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'confirm password not matched!';
      } else {
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
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
   <title>register</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


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

      .card {
         padding: 10px;
      }
   </style>
</head>

<body>



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

   <div class="container-register mt-5">


      <div class="card" style="width: 30rem;">

         <form action="" method="post">
            <h3 class="text-center">Register</h3>

            <div class="mb-3 w-auto">
               <label class="form-label">Name</label>
               <input type="text" class="form-control" name="name">

            </div>

            <div class="mb-3 w-auto">
               <label class="form-label">Email address</label>
               <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
               <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            <div class="mb-3 w-auto">
               <label class="form-label">Password</label>
               <input type="password" class="form-control" name="password" aria-describedby="emailHelp">
               <div id="passwordHelp" class="form-text">We'll never ask your password.</div>
            </div>

            <div class="mb-3 w-auto">
               <label class="form-label">Confirm Password</label>
               <input type="password" class="form-control" name="cpassword">
            </div>

            <div class="mb-3 w-auto">
               <label class="form-label">Select role</label>
               <select name="user_type" class="form-select">
                  <option value="user">user</option>
                  <option value="admin">admin</option>
               </select>
            </div>

            <div class="col text-center">
               <button type="submit" class="btn btn-primary text-center" name="submit">Register</button>
               <p class="pt-2">don't have an account? <a href="login.php">login now</a></p>
            </div>

         </form>

      </div>
   </div>

</body>

</html>