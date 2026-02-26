<?php
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

// Initialize variables
$productId = $name = $description = $price = "";

// Handle GET request to load the product data
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    } else {
        echo "Product not found.";
        exit;
    }
}

// Handle POST request to update the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = intval($_POST['productId']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);

    // Update product in the database
    $sql = "UPDATE products SET name = '$name', description = '$description', price = $price WHERE id = $productId";

     if ($conn->query($sql) === TRUE) {
        // Redirect to the view products page with success flag
        header("Location: view_product.php?success");
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff; /* Added background color for better readability */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="POST">
            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($description); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>
