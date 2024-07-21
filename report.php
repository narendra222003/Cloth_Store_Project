<?php

include 'config.php'; // Include database connection file

session_start();

$user_id = $_SESSION['user_id']; // Assuming 'user_id' is the session variable for the logged-in user

if (!isset($user_id)) {
   header('location:login.php');
   exit; 
}

// Fetch orders for the logged-in user
$sql = "SELECT *, CASE WHEN payment_status = 'completed' THEN 'complete' ELSE 'pending' END AS status  
        FROM `orders` 
        WHERE user_id = '$user_id'";
$select_orders = mysqli_query($conn, $sql) or die('Query failed: ' . mysqli_error($conn));

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Report</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css"> 

   <style>
      body {
         background-color: grey;
      }
   </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>our report</h3>
   <p> <a href="home.php">home</a> / report </p>
</div>

<section class="placed-orders">
<h1 class="title">User Reports</h1>

   <div class="box-container">
      <?php
      if (mysqli_num_rows($select_orders) > 0) {
         while ($order = mysqli_fetch_assoc($select_orders)) {
            // Format date to display as "12-Nov-2023"
            $formatted_date = date('d-M-Y', strtotime($order['placed_on']));
      ?>
      <div class="box">
         <p class="name">Order ID: <?php echo $order['user_id']; ?></p>
         
            <p>Customer Name: <?php echo $order['name']; ?></p>
            <p>Email: <?php echo $order['email']; ?></p>
            <p>Order Date: <?php echo $formatted_date; ?></p>
            <p>Total Products: <?php echo $order['total_products']; ?></p>
            <p>Total Price: <?php echo $order['total_price'];?></p>
            <p>Status: <?php echo ucfirst($order['status']); ?></p> <!-- Display order status -->
            
            <!-- Add more details as needed -->
         
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders found!</p>';
      }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
