<?php

include 'config.php'; // Include database connection file

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
   exit; 
}

// Initialize variables to store total pending and completed prices
$total_pending_price = 0;
$total_completed_price = 0;

// Fetch all product names from the database
$product_query = mysqli_query($conn, "SELECT DISTINCT name FROM `orders`") or die('Query failed: ' . mysqli_error($conn));

// Check if form is submitted
if (isset($_POST['search'])) {
   // Get selected product name from form
   $selected_product = $_POST['product_name'];
   
   // Fetch orders for the selected product
   $sql = "SELECT *, CASE WHEN payment_status = 'completed' THEN 'complete' ELSE 'pending' END AS status  
           FROM `orders` WHERE name = '$selected_product'";
   $select_orders = mysqli_query($conn, $sql) or die('Query failed: ' . mysqli_error($conn));

   // Fetch total pending price for the selected user
   $total_pending_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_pending_price FROM `orders` WHERE name = '$selected_product' AND payment_status = 'pending'");
   $total_pending_row = mysqli_fetch_assoc($total_pending_query);
   $total_pending_price = $total_pending_row['total_pending_price'];

   // Fetch total completed price for the selected user
   $total_completed_query = mysqli_query($conn, "SELECT SUM(total_price) AS total_completed_price FROM `orders` WHERE name = '$selected_product' AND payment_status = 'completed'");
   $total_completed_row = mysqli_fetch_assoc($total_completed_query);
   $total_completed_price = $total_completed_row['total_completed_price'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Report</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">

   <style>
body {
    background-color: #f2f2f2;
}   </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">
   <h1 class="title">Order Reports </h1>
   <form action="" method="post">
      <h3>Order Report</h3>
      <label for="product_name">Select User:</label>
      <select name="product_name" class="box" required>
         <option value="">Select user</option>
         <?php while ($row = mysqli_fetch_assoc($product_query)) { ?>
            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
         <?php } ?>
      </select>
      <input type="submit" name="search" value="Search" class="btn">
   </form>
</section>

<section class="orders">
   <div class="box-container">
      <?php if (isset($selected_product)) { ?>
         <div class="box">
            <h3 style="font-size: 13px;">Total Pending Price for <?php echo $selected_product; ?>: <?php echo $total_pending_price; ?></h3>
         </div>
         <div class="box">
            <h3 style="font-size: 13px;">Total Completed Price for <?php echo $selected_product; ?>: <?php echo $total_completed_price; ?></h3>
         </div>
      <?php } ?>
   </div>
</section>

<section class="orders">
   <div class="box-container">
      <?php
      if (isset($select_orders)) {
         if (mysqli_num_rows($select_orders) > 0) {
            while ($order = mysqli_fetch_assoc($select_orders)) {
               // Format date to display as "12-Nov-2023"
               $formatted_date = date('d-M-Y', strtotime($order['placed_on']));
      ?>
      <div class="box">
         <p class="name">Order ID: <?php echo $order['user_id']; ?></p>
         <div class="details">
            <p>Customer Name: <?php echo $order['name']; ?></p>
            <p>Email: <?php echo $order['email']; ?></p>
            <p>Order Date: <?php echo $formatted_date; ?></p>
            <p>Total Products: <?php echo $order['total_products']; ?></p>
            <p>Total Price: <?php echo $order['total_price'];?></p>
            <p>Status: <?php echo ucfirst($order['status']); ?></p> <!-- Display order status -->
            
            <!-- Add more details as needed -->
         </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No orders found for this product!</p>';
         }
      }
      ?>
   </div>
</section>

<script src="js/script.js"></script>

</body>
</html>
