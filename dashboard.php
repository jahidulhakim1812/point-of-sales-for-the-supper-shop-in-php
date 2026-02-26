<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(253, 253, 253);
           
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
            color:rgb(255, 255, 255);
            padding: 10px;
            text-align: center;
        }
        nav a {
            color:rgb(255, 255, 255);
            margin: 0 15px;
            text-decoration: none;
        }
        .welcome-section {
            position: relative;
            text-align: center;
            color: white;
        }
        .welcome-section img {
            width: 100%;
            height: calc(100vh - 120px);
            object-fit: cover;
        }
        .welcome-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Georgia', serif;
            padding: 20px 40px;
            border-radius: 10px;
            font-size: 3rem;
            font-weight: bold;
            color:rgba(255, 255, 255, 0.94);
            background:rgba(4, 97, 89, 0.68);
            
        }
        footer {
            text-align: center;
            padding: 0px;
            background: rgb(1, 68, 65);
            color: #ffffff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <h1>POINT OF SALES DASHBOARD</h1>
</header>

<nav>

    <a href="dashboard.php">Home</a>
    <a href="pos.php">Sales</a>
    <a href="pos add product.php">Insert</a>
    <a href="view_product.php">View</a>
    <a href="billshow.php">Report</a>
    <a href="about.php">About</a>


</nav>

<div class="welcome-section">
    <img src="21.jpg" alt="Welcome Background">
    <div class="welcome-text">Welcome to Pos System
    </div>
</div>

<footer>
    <p>&copy; Jahidul Hakim. All rights reserved.</p>
</footer>

</body>
</html>
