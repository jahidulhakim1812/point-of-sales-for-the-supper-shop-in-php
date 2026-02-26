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

// Get product ID from the form
$productId = $_POST['id'];

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $productId";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    // Handle the case where the product ID is not found
    echo "Product not found.";
    exit;
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
            background: rgba(141, 182, 180, 0.63);
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding:40px;
            border: 1px solid #ccc;
            border-radius: 10px;
          background: rgba(1, 68, 65, 0.42); 
		  
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
			font-family: 'Georgia', serif;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: white;
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
        <form action="update_product.php" method="POST">
            <input type="hidden" name="productId" value="<?php echo $productId; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br><br>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>"><br><br>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo $row['price']; ?>"><br><br>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>