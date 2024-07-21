<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        #paypal-button-container {
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <h1>Secure Payment Page</h1>
    
    <!-- Payment Form -->
    <form id="paymentForm">
        <label for="amount">Amount:</label>
        <input type="text" id="amount" name="amount" required>
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <!-- Add other necessary form fields here -->

        <div id="paypal-button-container"><button>Submit</button></div>
    </form>

    <!-- Include PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script>

    <!-- Include your custom JavaScript file -->
    <script src="script.js"></script>
</body>
</html>
