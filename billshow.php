<?php
// Database connection
$host = "localhost";
$db = "pos";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$sql = "SELECT * FROM bill";
$conditions = [];

if (!empty($searchQuery)) {
    $conditions[] = "customer_name LIKE '%" . $conn->real_escape_string($searchQuery) . "%'";
}
if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "DATE(created_at) BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "'";
}

if ($conditions) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Records</title>
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
            padding: 10px 20px;
            text-align: center;
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
            margin: 0 10px;
            text-decoration: none;
        }
        nav .search-bar {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }
        nav .search-bar input, nav .search-bar button {
            padding: 5px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }
        nav .search-bar button {
            background-color: #ffffff;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: rgba(1, 59, 56, 0.94);
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<header>
    <h1>Bill Report</h1>
</header>

<nav>
    <a href="dashboard.php">Home</a>
    <a href="pos.php">Sales</a>
    <a href="pos add product.php">Insert</a>
    <a href="view_product.php">View</a>
    <a href="billshow.php">Report</a>
    <a href="about.php">About</a>

    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <input type="date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
            <input type="date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
            <button type="submit">Filter</button>
        </form>
    </div>
</nav>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Customer Name</th>
            <th>Products</th>
            <th>Total Price</th>
            <th>Quantity</th>
            <th>Grand Total</th>
            <th>Payment Method</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $idCounter = 1;
            while ($row = $result->fetch_assoc()) {
                $cartData = json_decode($row['cart_data'], true);
                $productNames = [];

                // Ensure unique product names
                if (is_array($cartData)) {
                    foreach ($cartData as $item) {
                        $productNames[htmlspecialchars($item['name'])] = true;
                    }
                }

                echo "<tr>
                    <td>" . $idCounter . "</td>
                    <td>" . htmlspecialchars($row['customer_name']) . "</td>
                    <td>" . implode(", ", array_keys($productNames)) . "</td>
                    <td>$" . number_format($row['total_price'], 2) . "</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                    <td>$" . number_format($row['grand_total'], 2) . "</td>
                    <td>" . htmlspecialchars($row['payment_method']) . "</td>
                    <td>" . htmlspecialchars($row['created_at']) . "</td>
                </tr>";

                $idCounter++;
            }
        } else {
            echo "<tr><td colspan='8'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<footer>
    <p>&copy; Jahidul Hakim. All rights reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
