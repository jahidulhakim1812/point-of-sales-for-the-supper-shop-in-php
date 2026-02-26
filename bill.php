<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartData'])) {
    // Decode the JSON cart data from POST
    $cartData = json_decode($_POST['cartData'], true);
    $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 'Not Specified';
    $customerName = isset($_POST['customerName']) ? $_POST['customerName'] : 'Anonymous';

    if (!$cartData) {
        echo "Invalid cart data.";
        exit;
    }

    // Database connection
    $host = "localhost";
    $db = "pos";
    $user = "root";
    $password = "";

    $conn = new mysqli($host, $user, $password, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Calculate total price and total quantity
    $grandTotal = 0;
    $totalQuantity = 0;
    foreach ($cartData as $item) {
        $grandTotal += $item['totalPrice'];
        $totalQuantity += $item['quantity'];
    }

    // Insert data into the `bill` table
    $stmt = $conn->prepare("INSERT INTO bill (customer_name, cart_data, total_price, quantity, grand_total, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $cartJson = json_encode($cartData);
    $stmt->bind_param("ssdids", $customerName, $cartJson, $grandTotal, $totalQuantity, $grandTotal, $paymentMethod);

    if ($stmt->execute()) {
        // Successful insertion
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: rgba(4, 77, 70, 0.94);
            color: #ffffff;
            padding: 5px 10px;
            text-align: center;
            font-family: 'Georgia', serif;
        }
        nav {
            background: rgba(1, 59, 56, 0.94);
            color: #ffffff;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        nav a {
            color: #ffffff;
            margin: 0 15px;
            text-decoration: none;
        }
        nav .search-bar {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }
        nav .search-bar input {
            padding: 3px;
            width: 150px;
            border: 1px solid #ddd;
            border-radius: 20px;
        }
        nav .search-bar button {
            padding: 3px 10px;
            border: none;
            border-radius: 20px;
            background-color: rgb(253, 255, 255);
            color: black;
            cursor: pointer;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: rgb(1, 68, 65);
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .receipt-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .receipt {
            width: 400px;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .receipt-header p {
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }

        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .receipt-details th, .receipt-details td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .receipt-details th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .receipt-summary {
            text-align: right;
            margin-bottom: 20px;
        }

        .receipt-summary h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .customer-name, .payment-method {
            text-align: left;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }

        .print-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: rgb(1, 68, 65);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<nav>

    <a href="dashboard.php">Home</a>
    <a href="pos.php">Sales</a>
    <a href="pos add product.php">Insert</a>
    <a href="view_product.php">View</a>
    <a href="billshow.php">Report</a>
    <a href="about.php">About</a>
    
</nav>
<body>
    <div class="receipt-container">
        <div class="receipt">
            <div class="receipt-header">
                <h2>Amar Bazar</h2>
                <p>Address: Khailkur, Boardbazar, Gazipur-1704</p>
                <p>Mobile: 01957-288638</p>
                <p>Thank you for your purchase!</p>
            </div>
            <div class="receipt-details">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandTotal = 0;
                        foreach ($cartData as $item) {
                            $unitPrice = $item['totalPrice'];

                            echo "<tr>
                                <td>" . htmlspecialchars($item['name']) . "</td>
                                <td>" . $item['quantity'] . "</td>
                                <td>$" . number_format($unitPrice, 2) . "</td>
                            </tr>";

                            $grandTotal += $unitPrice;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="receipt-summary">
                <h3>Grand Total: $<?php echo number_format($grandTotal, 2); ?></h3>
            </div>
            <div class="customer-name">
                <strong>Customer:</strong> <?php echo htmlspecialchars($customerName); ?>
            </div>
            <div class="payment-method">
                <strong>Payment Method:</strong> <?php echo htmlspecialchars($paymentMethod); ?>
            </div>
            <button class="print-btn" onclick="window.print()">Print</button>
        </div>
    </div>
</body>
</html>
