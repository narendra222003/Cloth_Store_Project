<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'shop_db';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['mobile']) && isset($_POST['amount'])) {
        $stmt = $conn->prepare("INSERT INTO payusers (name, email, mobile, amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param($name, $email, $mobile, $amount);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $amount = $_POST['amount'];
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Payment successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">

    <style>

.footer {
    background-color: white;
    color: black;
    padding: 50px 0;
}

.box-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.box {
    flex: 1;
    padding: 0 20px;
}

.box h3 {
    font-size: 18px;
    margin-bottom: 20px;
}

.box a {
    color: black;
    text-decoration: none;
    display: block;
    margin-bottom: 10px;
}

.box a:hover {
    text-decoration: underline;
}

.box p {
    margin-bottom: 10px;
}

.box i {
    margin-right: 10px;
}


        body {
            background-color: grey;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            background-color: blue;
            padding: 10px 0;
            text-align: center;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            color: black;
            text-decoration: none;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Use min-height instead of height for responsive design */
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .card-title {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Style for footer */
        footer {
            background-color: grey;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="Feedback.php">Feedback</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card bg-light" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="card-title">Online Payment</h4>

                <form id="payment-form" method="POST" action="success.php">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" class="form-control" placeholder="Enter your name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label for="email">upi id</label>
                        <input id="email" name="email" class="form-control" placeholder="Enter your upi id" type="email" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <section class="footer">

<div class="box-container">

   <div class="box">
      <h3>quick links</h3>
      <a href="home.php">home</a>
      <a href="about.php">about</a>
      <a href="shop.php">shop</a>
      <a href="contact.php">contact</a>
   </div>

   <div class="box">
      <h3>extra links</h3>
      <a href="login.php">login</a>
      <a href="register.php">register</a>
      <a href="cart.php">cart</a>
      <a href="orders.php">orders</a>
   </div>

   <div class="box">
      <h3>contact info</h3>
      <p> <i class="fas fa-phone"></i> +123-456-7890 </p>
      <p> <i class="fas fa-phone"></i> +111-222-3333 </p>
      <p> <i class="fas fa-envelope"></i> narendra@gmail.com </p>
      <p> <i class="fas fa-map-marker-alt"></i> surat, india - 400104 </p>
   </div>

   <div class="box">
      <h3>follow us</h3>
      <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
      <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
      <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
      <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
   </div>

</div>


</section>
</body>

</html>
