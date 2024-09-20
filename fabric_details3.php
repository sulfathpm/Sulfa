<?php
// Connect to the database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure you are querying a specific fabric, replace 1 with the actual fabric ID you want to retrieve
$fabric_id = 1; // You can change this or pass it dynamically
$fabrics_query = "SELECT * FROM fabrics WHERE FABRIC_ID = $fabric_id";
$result = mysqli_query($dbcon, $fabrics_query);

// Check if any result is returned
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    $row = null; // To handle no data scenario
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose by Fabric - Women's Boutique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .navbar {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            color: #fff;
            padding: 14px 20px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .navbar a:hover, .navbar a.customize-button {
            background-color: palevioletred;
            border-radius: 20px;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: white;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: palevioletred;
        }

        .fabric-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .fabric-table th, .fabric-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .fabric-table th {
            background-color: #f9f9f9;
            color: #333;
        }

        .fabric-table img {
            max-width: 100px;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 40px;
            border-radius: 0 0 10px 10px;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="home.html">Home</a>
        <a href="fabric.html" class="active">Choose by Fabric</a>
        <a href="abt.html">About</a>
        <a href="contact.html">Contact</a>
        <a href="login.html">Login</a>
        <a href="customize1.html" class="customize-button">Customize Now</a>
    </div>

    <div class="container">
        <h1>Choose Your Fabric</h1>
        <p>Browse through our selection of high-quality fabrics and choose the perfect one for your custom dress.</p>

        <?php if ($row): // Check if $row is not null ?>
        <div class="container">
            <h1><?php echo htmlspecialchars($row['NAME']); ?></h1>
            <div class="dress-details">
                <img src="<?php echo htmlspecialchars($row['IMAGE_URL']); ?>" alt="<?php echo htmlspecialchars($row['NAME']); ?>">
                <div class="dress-info">
                    <h2>Dress Details</h2>
                    <table>
                        <tr>
                            <th>Description</th>
                            <td><?php echo htmlspecialchars($row['DESCRIPTION']); ?></td>
                        </tr>
                        <tr>
                            <th>Fabric</th>
                            <td><?php echo htmlspecialchars($row['NAME']); ?></td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td class="price">₹<?php echo number_format($row['PRICE_PER_UNIT'], 2); ?></td>
                        </tr>
                        <tr>
                            <th>Available Quantity</th>
                            <td><?php echo htmlspecialchars($row['AVAILABLE_QUANTITY']); ?> Meters</td>
                        </tr>
                    </table>
                    <button class="buy-button">Buy Now</button>
                </div>
            </div>
        </div>
        <?php else: ?>
            <p>No fabric details available.</p>
        <?php endif; ?>
    </div>

<?php
// Close database connection
mysqli_close($dbcon);
?>

    <div class="footer">
        <p>&copy; 2024 Women's Boutique. All Rights Reserved.</p>
    </div>
</body>
</html>
