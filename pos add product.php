<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - POS</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: rgba(141, 182, 180, 0.63);
        }
        header {
            background: rgba(4, 77, 70, 0.94);
            color:rgb(255, 255, 255);
            padding: 10px 20px;
            text-align: center;
            font-family: 'Georgia', serif;
        }
        nav {
            background: rgba(1, 59, 56, 0.94);
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #ffffff;
            margin: 0 15px;
            text-decoration: none;
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
            max-width: 400px;
			
            margin: 10px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: rgba(1, 68, 65, 0.42);
        }
        h1 {
            text-align: center;
            color: white;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input, textarea, button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #4cae4c;
        }
        label{
            color:white;
        }
    </style>
</head>
<header>
    <h1>ADD PRODUCTS</h1>
</header>

<nav>
    <a href="dashboard.php">Home</a>
    <a href="pos.php">Sales</a>
    <a href="pos add product.php">Insert</a>
    <a href="view_product.php">View</a>
    <a href="billshow.php">Report</a>
    <a href="about.php">About</a>

</nav>
<body>
<div class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p style="color: green; text-align: center;">Product added successfully!</p>
    <?php endif; ?>
    <h1>Add Product</h1>
    <form id="addProductForm" enctype="multipart/form-data" method="post" action="add_product.php">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="productDescription">Product Description:</label>
        <textarea id="productDescription" name="productDescription" rows="4" required></textarea>

        <label for="productPrice">Price:</label>
        <input type="number" id="productPrice" name="productPrice" step="0.01" required>

        <label for="productImage">Upload Image:</label>
        <input type="file" id="productImage" name="productImage" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>
</div>

</body>
</body>
<footer>
    <p>&copy; Jahidul Hakim. All rights reserved.</p>
</footer>
</html>
