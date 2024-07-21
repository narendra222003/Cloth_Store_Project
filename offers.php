<?php
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:offers.php');
}

$message = [];

if (isset($_POST['add_to_cart'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['offer_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['offer_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['offer_image']);
    $product_quantity = mysqli_real_escape_string($conn, $_POST['offer_quantity']);

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloth Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
          
          body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

header {
    background-color: #343a40;
    padding: 20px 0;
    color: white;
    text-align: center;
}

h1 {
    color: #dc3545;
    font-size: 36px;
    margin-bottom: 20px;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

ul li {
    display: inline;
    margin-right: 10px;
}

ul li a {
    color: white;
    text-decoration: none;
}

marquee {
    font-style: italic;
    color: #dc3545;
    font-size: 20px;
}

.sale-banner {
    width: 100%;
    height: auto;
    margin-bottom: 20px;
}

.box-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

.box {
    width: 300px;
    border: 1px solid #dee2e6;
    margin: 10px;
    padding: 10px;
    text-align: center;
    background-color: white;
    transition: transform 0.3s;
}

.box:hover {
    transform: scale(1.05);
}

.box img {
    max-width: 100%;
    height: auto;
}

.name {
    font-weight: bold;
    margin: 10px 0;
}

.price {
    color: #28a745;
    font-size: 1.2em;
}

.qty {
    width: 50px;
    text-align: center;
    margin: 10px 0;
}

.btn {
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}

footer {
    background-color: #343a40;
    color: white;
    padding: 20px 0;
    text-align: center;
    position: fixed;
    width: 100%;
    bottom: 0;
}

a {
    color: #007bff;
}

#container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    text-align: center;
}

#myVideo {
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}

    /* Existing styles */
    /* Add your existing CSS styles here */

    /* Footer styles */
    footer {
        background-color: #343a40;
        color: white;
        padding: 20px 0;
        text-align: center;
        position: fixed;
        width: 100%;
        bottom: 0;
    }

    footer a {
        color: #007bff;
        text-decoration: none;
    }

    /* Additional styles for better appearance */
    .footer-links {
    margin-top: 10px;
    text-align: center;
}

.footer-links a {
    margin: 0 10px;
    display: inline-block;
    color: #007bff;
    text-decoration: none;
}

/* Adjustments for smaller screens */
@media (max-width: 576px) {
    .footer-links a {
        display: block;
        margin: 5px 0;
    }
}

</style>

    </style>

</head>

<body>

    <header>
        <h1>“today Offer On sale.”</h1>

        <ul>
            <li><a href="home.php" class="text-white">Home</a></li>
            <li><a href="cart.php" class="text-white">View Cart</a></li>
            <li><a href="logout.php" class="text-white">Logout</a></li>
        </ul>
    </header>

    <marquee scrollamount="10">
        <p>Always in a killer’s outfit.</p>
    </marquee>

    <div id="container">
        <h1>Welcome to our Clothing Store!</h1>
        <p>Explore our latest collection in this video:</p>
        <video id="myVideo" width="1530" height="360" controls autoplay>
            <source src="WhatsApp Video 2024-03-13 at 23.32.07_68239855.mp4" type="video/mp4">
        </video>
    </div>
    
    <img class="sale-banner" src="vector-colorful-fashion-sale-banner.jpg" alt="Sale Banner">

    <div class="container mt-4">
        <div class="row">
            <?php
            $select_offers = mysqli_query($conn, "SELECT * FROM `offers` LIMIT 100") or die('query failed');
            if (mysqli_num_rows($select_offers) > 0) {
                while ($fetch_offers = mysqli_fetch_assoc($select_offers)) {
            ?>
                    <div class="col-md-4">
                        <div class="box">
                            <img class="image" src="uploaded_img/<?php echo $fetch_offers['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_offers['name']; ?></div>
                            <div class="price">RS.<?php echo $fetch_offers['price']; ?>/-</div>
                            <form method="post" action="" class="class">
                                <input type="number" min="1" name="offer_quantity" value="1" class="qty">
                                <input type="hidden" name="offer_name" value="<?php echo $fetch_offers['name']; ?>">
                                <input type="hidden" name="offer_price" value="<?php echo $fetch_offers['price']; ?>">
                                <input type="hidden" name="offer_image" value="<?php echo $fetch_offers['image']; ?>">
                                <input type="submit" value="add to Cart" name="add_to_cart" class="btn">
                            </form>
                        </div>
                    </div>
                  
            <?php
                }
            } else {
                echo '<p class="empty text-center">No offers added yet!</p>';
            }
            ?>
        </div>
    </div>
    <marquee scrollamount="10">
        <p>Life is too short to wear boring clothes. Let's add some cuteness!</p>
    </marquee>
<center>
    <img src="clothingrack-e1586952118505.jpg" alt="Clothing Rack"  class="img-fluid mt-4" style="width: 1530px;" "height: 120pt;"></center>

    
    <?php include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>
