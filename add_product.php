<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "pos"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form inputs
    $productName = $conn->real_escape_string($_POST['productName']);
    $productDescription = $conn->real_escape_string($_POST['productDescription']);
    $productPrice = floatval($_POST['productPrice']);

    // Handle file upload
    $target_dir = "/";
    $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
    move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$productName', '$productDescription', '$productPrice', '$target_file')";

 
	
	 if ($conn->query($sql) === TRUE) {
        // Redirect to the view products page with success flag
        header("Location: pos add product.php?success=1");
        exit;
    } else {
        echo "Error deleting product: " . $conn->error;
    }
}
 else {
    echo "Invalid request.";
}

    $conn->close();

?>
<?php
// Display success message if redirected
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<p style='color: green; text-align: center;'>Product added successfully!</p>";
}
?>

