<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_product'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'product name already added';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

      if ($add_product_query) {
         if ($image_size > 2000000) {
            $message[] = 'image size is too large';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      } else {
         $message[] = 'product could not be added!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'image file size is too large';
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/' . $update_old_image);
      }
   }

   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</head>

<body>

   <!-- <div class="container mx-2 w-100"> -->



      <?php include 'admin_header.php'; ?>

      <!-- product CRUD section starts  -->

      <section class="add-products w-75 m-auto">

         <h1 class="title">List of Products</h1>

         <div class="container-login my-5" >

            <div class="card px-2 m-auto" style="width: 30rem;">

               <form action="" method="post" enctype="multipart/form-data">
                  <h3 class="text-center">Add Product</h3>
                  <div class="mb-3 w-auto">
                     <label class="form-label">Product name</label>
                     <input type="text" class="form-control" name="name" required>
                  </div>

                  <div class="mb-3 w-auto">
                     <label class="form-label">Price</label>
                     <input type="number" class="form-control" name="price" required>
                  </div>

                  <div class="mb-3 w-auto">
                     <label class="form-label">Upload image</label>
                     <input type="file" class="form-control" name="image" accept="image/jpg, image/jpeg, image/png" required>
                  </div>

                  <div class="col text-center mb-2">
                     <button type="submit" class="btn btn-primary text-center" name="add_product">Add product</button>
                  </div>
               </form>
            </div>
         </div>

      </section>


      <!-- product CRUD section ends -->

      <!-- show products  -->

      <section class="show-products d-flex justify-content-around flex-wrap w-75 m-auto">
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
               <div class="card my-3" style="width: 18rem;">
                  <img class="card-img-top" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="Card image cap">
                  <div class="card-body">
                     <h5 class="card-title"><?php echo $fetch_products['name']; ?></h5>
                     <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  </div>
                  <ul class="list-group list-group-flush">
                     <li class="list-group-item">Rp.<?php echo $fetch_products['price']; ?>.00</li>
                  </ul>
                  <div class="card-body">
                     <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>">Update</a>
                     <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" onclick="return confirm('delete this product?');">Delete</a>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </section>

      <nav class="my-5">
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



      <section class="edit-product-form">

         <div class="container-login mt-5">

            <div class="card p-2 mb-5 m-auto" style="width: 30rem;">

               <?php
               if (isset($_GET['update'])) {
                  $update_id = $_GET['update'];
                  $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
                  if (mysqli_num_rows($update_query) > 0) {
                     while ($fetch_update = mysqli_fetch_assoc($update_query)) {
               ?>

                        <form action="" method="post" enctype="multipart/form-data">
                           <h3 class="text-center">Update</h3>
                           <div class="mb-3 w-auto">
                              <!-- <label class="form-label">Email address</label> -->
                              <input type="hidden" class="form-control" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">

                           </div>

                           <div class="mb-3 w-auto">
                              <!-- <label class="form-label">Password</label> -->
                              <input type="hidden" class="form-control" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">

                           </div>

                           <img class="card-img-top" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="Card image cap" hidden>


                           <div class="mb-3 w-auto">
                              <label class="form-label">Product name</label>
                              <input type="text" class="form-control" name="update_name" value="<?php echo $fetch_update['name']; ?>" required>

                           </div>

                           <div class="mb-3 w-auto">
                              <label class="form-label">Price</label>
                              <input type="number" class="form-control" name="update_price" value="<?php echo $fetch_update['price']; ?>" required>

                           </div>

                           <div class="mb-3 w-auto">
                              <label class="form-label">Upload image</label>
                              <input type="file" class="form-control" name="update_image" accept="image/jpg, image/jpeg, image/png">
                           </div>


                           <div class="col text-center">
                              <!-- <button type="submit" class="btn btn-primary text-center" name="update_product">Update</button> -->
                              <input type="submit" class="btn btn-primary text-center" value="update" name="update_product">
                              <button type="reset" class="btn btn-danger text-center" id="close-update">Cancel</button>
                           </div>
                        </form>
               <?php
                     }
                  }
               } else {
                  echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
               }
               ?>
            </div>
         </div>
      </section>


   <!-- </div> -->

 
  
   <script>
      document.querySelector('#close-update').onclick = () => {
         document.querySelector('.edit-product-form').style.display = 'none';
         window.location.href = 'admin_products.php';
      }
   </script>

</body>

</html>


