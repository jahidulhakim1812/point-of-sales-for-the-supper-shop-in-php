<?php
// pos.php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM products";
if ($search !== '') {
    $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
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
        .container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .products {
            width: 70%;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            width: 150px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background-color: #fff;
        }
        .product img {
            max-width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product h3 {
            font-size: 14px;
            margin: 10px 0;
        }
        .product p {
            font-size: 12px;
            color: #555;
        }
        .product input {
            width: 50px;
            padding: 5px;
            margin-top: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .product button {
            margin-top: 10px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: rgb(3, 81, 92);
            color: white;
            cursor: pointer;
        }
        .cart {
            width: 25%;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 50px;
            background-color: #fff;
        }
        .cart h2 {
            text-align: center;
        }
        .cart table {
            width: 100%;
            border-collapse: collapse;
        }
        .cart table th, .cart table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .total {
            margin-top: 10px;
            text-align: right;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: rgb(5, 88, 88);
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .payment-method {
            margin-top: 15px;
        }
        .payment-method label {
            margin-right: 10px;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        .customer-info input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<header>
    <h1>ADD TO CART</h1>
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
            <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
</nav>
<body>
    <div class="container">
        <div class="products">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = 'images/upload/' . htmlspecialchars($row['image']);
                    if (!file_exists($imagePath)) {
                        $imagePath = 'images/placeholder.jpg'; // Fallback image
                    }
                    echo '<div class="product">
                            <img src="' . $imagePath . '" alt="Product Image">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <p>$' . number_format($row['price'], 2) . '</p>
                            <input type="number" min="1" value="1" id="quantity_' . $row['id'] . '" placeholder="Quantity">
                            <button onclick="addToCart(' . $row['id'] . ', \'' . htmlspecialchars($row['name']) . '\', ' . $row['price'] . ')">Add to Cart</button>
                          </div>';
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>

        <!-- Cart -->
        <div class="cart">
            <h2>Cart</h2>
            <form id="cartForm" method="POST" action="bill.php">
                <!-- Customer Name Input -->
                <div class="customer-info">
                    <label for="customerName"><strong>Customer Name:</strong></label>
                    <input type="text" id="customerName" name="customerName" placeholder="Enter customer name" required>
                </div>

                <table id="cartTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="total">
                    <strong>Total: $<span id="totalPrice">0.00</span></strong>
                </div>
                <input type="hidden" name="cartData" id="cartData">
                <div class="payment-method">
                    <label><input type="radio" name="paymentMethod" value="Cash " required> Cash</label><br>
                    <label><input type="radio" name="paymentMethod" value="Bank Transfer" required> Bank Transfer</label><br>
                    <label><input type="radio" name="paymentMethod" value="bKash" required> bKash</label><br>
                </div>
                <button type="submit" class="btn">Checkout</button>
            </form>
        </div>
    </div>

    <script>
        const cart = [];

        function addToCart(id, name, price) {
            const quantityInput = document.getElementById(`quantity_${id}`);
            let quantity = parseInt(quantityInput.value);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1; // Default to 1 if invalid input
                quantityInput.value = 1;
            }

            const existingItem = cart.find(item => item.id === id);

            if (existingItem) {
                existingItem.quantity += quantity;
                existingItem.totalPrice += price * quantity;
            } else {
                cart.push({ id, name, quantity, totalPrice: price * quantity });
            }

            updateCartTable();
        }

        function updateCartTable() {
            const cartTable = document.querySelector('#cartTable tbody');
            cartTable.innerHTML = '';

            let totalPrice = 0;

            cart.forEach(item => {
                totalPrice += item.totalPrice;
                cartTable.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.totalPrice.toFixed(2)}</td>
                    </tr>
                `;
            });

            document.querySelector('#totalPrice').innerText = totalPrice.toFixed(2);
            document.querySelector('#cartData').value = JSON.stringify(cart);
        }
    </script>
</body>
<footer>
    <p>&copy; Jahidul Hakim. All rights reserved.</p>
</footer>

</html>
<?php
$conn->close();
?>
