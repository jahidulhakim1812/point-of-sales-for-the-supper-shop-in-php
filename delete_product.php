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

// Check if the ID is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $productId = intval($_POST['id']);

    // Delete the product from the database
    $sql = "DELETE FROM products WHERE id = $productId";
    if ($conn->query($sql) === TRUE) {
        // Reorder the rows and reset AUTO_INCREMENT
        $reorderSql = "SET @count = 0;
                       UPDATE products SET id = (@count := @count + 1);
                       ALTER TABLE products AUTO_INCREMENT = 1;";
        if ($conn->multi_query($reorderSql)) {
            do {
                // Process each result set if needed
            } while ($conn->next_result());
            
            // Redirect to the view products page with success flag
            header("Location: view_product.php?success=1");
            exit;
        } else {
            echo "Error reordering IDs and resetting AUTO_INCREMENT: " . $conn->error;
        }
    } else {
        echo "Error deleting product: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
