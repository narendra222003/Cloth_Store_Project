<?php
  include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Success</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,700,900" rel="stylesheet">
  <style>
    body {
      font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
      text-align: center;
      padding-top: 60px;
      background: grey;
    }
    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: blue;
      color: #fff;
      padding: 10px 0;
    }
    header nav ul {
      margin: 0;
      padding: 0;
      list-style: none;
    }
    header nav ul li {
      display: inline;
      margin-right: 20px;
    }
    header nav ul li a {
      color: black;
      text-decoration: none;
      font-size: 18px;
    }
    header nav ul li a:hover {
      color: #88B04B;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
    }
    .card {
      background: white;
      padding: 60px;
      border-radius: 4px;
      box-shadow: 0 2px 3px #C8D0D8;
      margin: 0 auto;
    }
    .checkmark {
      color: #9ABC66;
      font-size: 100px;
      line-height: 200px;
    }
    h1 {
      color: #88B04B;
      font-weight: 900;
      font-size: 40px;
      margin-bottom: 10px;
    }
    p {
      color: #404F5E;
      font-size: 20px;
      margin: 0;
    }
  </style>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="Feedback.php">Feedback</a></li>
      </ul>
    </nav>
  </header>
  <div class="container">
    <div class="card">
      <div style="border-radius: 200px; height: 200px; width: 200px; background: #F8FAF5; margin: 0 auto;">
        <i class="checkmark">✓</i>
      </div>
      <h1>Success</h1>
      <!-- <p>Transaction ID : <?php echo $_GET['tid']; ?></p> -->
      <!-- <p>Amount : <?php echo $_GET['amount']/100; ?></p> -->
      <p>We received your purchase request;<br/> we'll be in touch shortly!</p>
    </div>
  </div>
</body>
</html>
