<?php
// Connect to MySQL database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");

// Check connection
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the fabric ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $fabric_id = intval($_GET['id']); // Sanitize input

    // Fetch fabric details from the database
    $sql = "SELECT * FROM fabrics WHERE FABRIC_ID = $fabric_id";
    $result = mysqli_query($dbcon, $sql);

    // Check if the fabric exists
    if ($result->num_rows > 0) {
        $fabric = $result->fetch_assoc();
    } else {
        echo "Fabric not found.";
        exit();
    }
} else {
    echo "Invalid fabric ID.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($fabric['NAME']); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            padding: 40px;
            max-width: 1200px;
            margin: auto;
        }

        .fabric-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .fabric-details img {
            width: 40%;
            height: auto;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .fabric-info {
            width: 55%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .fabric-info h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .fabric-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .fabric-info table th, .fabric-info table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .fabric-info table th {
            background-color: #f9f9f9;
            color: #333;
        }

        .price {
            font-size: 1.5em;
            color: palevioletred;
            margin-bottom: 20px;
        }

        .buy-button {
            background-color: palevioletred;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .buy-button:hover {
            background-color: #d1477a;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($fabric['NAME']); ?></h1>
        <div class="fabric-details">
            <img src="<?php echo htmlspecialchars($fabric['IMAGE_URL']); ?>" alt="<?php echo htmlspecialchars($fabric['NAME']); ?>">
            <div class="fabric-info">
                <h2>Fabric Details</h2>
                <table>
                    <tr>
                        <th>Description</th>
                        <td><?php echo htmlspecialchars($fabric['DESCRIPTION']); ?></td>
                    </tr>
                    <tr>
                        <th>Fabric Type</th>
                        <td><?php echo htmlspecialchars($fabric['NAME']); ?></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td class="price">₹<?php echo number_format($fabric['PRICE_PER_UNIT'], 2); ?></td>
                    </tr>
                    <tr>
                        <th>Available Quantity</th>
                        <td><?php echo htmlspecialchars($fabric['AVAILABLE_QUANTITY']); ?> meters</td>
                    </tr>
                </table>
                <button class="buy-button">Buy Now</button>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($dbcon);
?>
