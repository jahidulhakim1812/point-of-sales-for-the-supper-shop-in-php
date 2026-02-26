<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
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
            background-color:rgb(253, 255, 255);
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
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit {
            background-color: #f0ad4e;
            color: white;
        }
        .delete {
            background-color: #d9534f;
            color: white;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<header>
    <h1>VIEW THE PRODUCT LIST</h1>
</header>

<nav>
    <div style="display: flex; flex: 1; justify-content: center; gap: 20px;">
    
    <a href="dashboard.php">Home</a>
    <a href="pos.php">Sales</a>
    <a href="pos add product.php">Insert</a>
    <a href="view_product.php">View</a>
    <a href="billshow.php">Report</a>
    <a href="about.php">About</a>


    </div>
    <div class="search-bar">
        <form method="get" action="view_product.php">
            <input type="text" name="search" placeholder="Search by name">
            <button type="submit">Search</button>
        </form>
    </div>
</nav>

<body>
<div class="container">
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p style="color: green; text-align: center;">Product deleted successfully!</p>
    <?php endif; ?>

    <h1>Product List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'pos');
            if ($conn->connect_error) {
                die('<tr><td colspan="6">Database connection failed: ' . $conn->connect_error . '</td></tr>');
            }

            // Fetch products from the database
            $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
            $sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo number_format($row['price'], 2); ?></td>
                        <td>
                            <?php
                            $imagePath = 'images/upload/' . htmlspecialchars($row['image']);
                            if (file_exists($imagePath) && is_file($imagePath)) {
                                echo "<img src='$imagePath' alt='Product Image'>";
                            } else {
                                echo "<img src='images/upload/placeholder.png' alt='Placeholder Image'>";
                            }
                            ?>
                        </td>
                        <td class="actions">
                            <form style="display:inline;" method="post" action="edit_product.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="edit">Edit</button>
                            </form>
                            <form style="display:inline;" method="post" action="delete_product.php">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="6">No products found</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
<footer>
    <p>&copy; Jahidul Hakim. All rights reserved.</p>
</footer>
</html>
