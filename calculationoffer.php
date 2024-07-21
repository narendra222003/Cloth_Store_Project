<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offer Discount Calculator</title>
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

        main {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
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
    </style>
</head>
<body>

<main>
    <?php
    // Function to calculate the discounted amount
    function calculateDiscount($totalAmount, $discountPercentage) {
        return $totalAmount * ($discountPercentage / 100);
    }

    // Sample data
    $totalAmount = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0;
    $discountPercentage = isset($_POST['discount_percentage']) ? (float)$_POST['discount_percentage'] : 0;

    if ($totalAmount > 0 && $discountPercentage > 0) {
        // Calculate discounted amount
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

</body>
</html>
