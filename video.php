<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }

        #myVideo {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div id="container">
        <h1>Welcome to our Clothing Store!</h1>
        <p>Explore our latest collection in this video:</p>
        <video id="myVideo" width="1530" height="360" controls autoplay>
            <source src="WhatsApp Video 2024-03-13 at 23.32.07_68239855.mp4" type="video/mp4">
        </video>
    </div>
    
    <script src="videojs/script1.js"></script>
</body>
</html>
