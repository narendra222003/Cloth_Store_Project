<?php

include 'config.php';

session_start();


$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location: login.php');
    exit;
}

$message = [];


if (isset($_POST['add_offer'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

  
    $select_offer_name = mysqli_query($conn, "SELECT name FROM `offers` WHERE name = '$name'") or die('query failed');
    if (mysqli_num_rows($select_offer_name) > 0) {
        $message[] = 'Offer name already added';
    } else {

        $add_offer_query = mysqli_query($conn, "INSERT INTO `offers` (name, price, image) VALUES ('$name', '$price', '$image')") or die('query failed');

        if ($add_offer_query) {
          
            if ($image_size > 2000000) {
                $message[] = 'Image size is too large';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Offer added successfully!';
            }
        } else {
            $message[] = 'Offer could not be added!';
        }
    }
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `offers` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    $image_to_delete = 'uploaded_img/' . $fetch_delete_image['image'];
    unlink($image_to_delete);
    mysqli_query($conn, "DELETE FROM `offers` WHERE id = '$delete_id'") or die('query failed');
    header('location: admin_offers.php');
}


if (isset($_POST['update_offer'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_price = $_POST['update_price']; // Added line to fetch updated price

    // Update offer details in the database
    mysqli_query($conn, "UPDATE `offers` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    // Update offer image if a new image is provided
    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image file size is too large';
        } else {
            mysqli_query($conn, "UPDATE `offers` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            $image_to_delete = 'uploaded_img/' . $update_old_image;
            unlink($image_to_delete);
        }
    }

    header('location: admin_offers.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    
</head>

<style>
    body {
    background-color: #f2f2f2;
}

main {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    margin: 20px auto;
    text-align: center;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
}

input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
}

p {
    margin: 10px 0;
}

.discount {
    font-size: 1.2em;
    color: #e74c3c;
    margin-bottom: 10px;
}

.add-offers {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    margin: 20px auto;
}

.show-offers {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 80%;
    margin: 20px auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.show-offers .box-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.show-offers .box {
    width: calc(33.33% - 20px);
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.show-offers .box img {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 10px;
}

.show-offers .box .name {
    font-weight: bold;
}

.show-offers .box .price {
    color: #4caf50;
    font-weight: bold;
}

.show-offers .box .option-btn,
.show-offers .box .delete-btn {
    margin-top: 10px;
    display: inline-block;
    padding: 8px 16px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.show-offers .box .delete-btn {
    background-color: #e74c3c;
    margin-left: 10px;
}

.empty {
    text-align: center;
}

</style>

<body>
    <?php include 'admin_header.php'; ?>

    <main>
        <?php
       
        function calculateDiscount($totalAmount, $discountPercentage) {
            return $totalAmount * ($discountPercentage / 100);
        }

       
        $totalAmount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;
        $discountPercentage = isset($_POST['discount_percentage']) ? (float)$_POST['discount_percentage'] : 0;

        if ($totalAmount > 0 && $discountPercentage > 0) {
           
            $discountedAmount = calculateDiscount($totalAmount, $discountPercentage);
            $finalAmount = $totalAmount - $discountedAmount;

            echo "<p>Total Amount: $totalAmount</p>";
            echo "<p>Discount Percentage: $discountPercentage%</p>";
            echo "<p>Discounted Amount: $discountedAmount</p>";
            echo "<p>Final Amount after Discount: $finalAmount</p>";
        }
        ?>

        <form method="post" action="">
            <label for="total_amount">Total Amount:</label>
            <input type="number" step="0.01" name="total_amount" required>

            <label for="discount_percentage">Discount Percentage:</label>
            <input type="number" step="0.01" name="discount_percentage" required>

            <input type="submit" value="Calculate Discount">
        </form>
    </main>

    <section class="add-offers">
        <h1 class="title">Shop Offers</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Add Offer</h3>
            <input type="text" name="name" class="box" placeholder="Enter offer name" required>
            <input type="number" min="0" name="price" class="box" placeholder="Enter offer price" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <input type="submit" value="Add Offer" name="add_offer" class="btn">
        </form>
    </section>
<!--  change -->
    <section class="show-offers">
        <div class="box-container">
            <?php
            $total_price = 0;
            $select_offers = mysqli_query($conn, "SELECT * FROM `offers`") or die('query failed');
            if (mysqli_num_rows($select_offers) > 0) {
                while ($fetch_offers = mysqli_fetch_assoc($select_offers)) {
                    $total_price += $fetch_offers['price'];
            ?>
                    <div class="box">
                        <img src="offer img/<?php echo $fetch_offers['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_offers['name']; ?></div>
                        <div class="price">Rs<?php echo $fetch_offers['price']; ?>/-</div>

                        <a href="admin_offers.php?update=<?php echo $fetch_offers['id']; ?>" class="option-btn">Update</a>
                        <a href="admin_offers.php?delete=<?php echo $fetch_offers['id']; ?>" class="delete-btn" onclick="return confirm('Delete this offer?');">Delete</a>
                    </div>
            <?php
                }
               
            } else {
                echo '<p class="empty">No offers added yet!</p>';
            }
            ?>
        </div>
    </section>

    <section class="edit-offer-form">
        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `offers` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="offer img/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter offer name">
                        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter offer price">
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <input type="submit" value="Update" name="update_offer" class="btn">
                        <input type="reset" value="Cancel" id="close-update" class="option-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-offer-form").style.display = "none";</script>';
        }
        ?>
    </section>

    <script src="js/admin_script.js"></script>
</body>

</html>
