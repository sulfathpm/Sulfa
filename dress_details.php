<?php
// Connect to MySQL database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");

// Check connection
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the dress ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $dress_id = intval($_GET['id']); // Sanitize input

    // Fetch dress details from the database
    $sql = "SELECT * FROM dress WHERE DRESS_ID = $dress_id";
    $result = mysqli_query($dbcon, $sql);

    // Check if the dress exists
    if ($result->num_rows > 0) {
        $dress = $result->fetch_assoc();
    } else {
        echo "Dress not found.";
        exit();
    }
} else {
    echo "Invalid dress ID.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($dress['NAME']); ?></title>
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

        .dress-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .dress-details img {
            width: 40%;
            height: auto;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .dress-info {
            width: 55%;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .dress-info h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .dress-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .dress-info table th, .dress-info table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .dress-info table th {
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
        <h1><?php echo htmlspecialchars($dress['NAME']); ?></h1>
        <div class="dress-details">
            <img src="<?php echo htmlspecialchars($dress['IMAGE_URL']); ?>" alt="<?php echo htmlspecialchars($dress['NAME']); ?>">
            <div class="dress-info">
                <h2>Dress Details</h2>
                <table>
                    <tr>
                        <th>Description</th>
                        <td><?php echo htmlspecialchars($dress['DESCRIPTION']); ?></td>
                    </tr>
                    <tr>
                        <th>Fabric</th>
                        <td><?php echo htmlspecialchars($dress['FABRIC']); ?></td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td><?php echo htmlspecialchars($dress['COLOR']); ?></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td class="price">₹<?php echo number_format($dress['BASE_PRICE'], 2); ?></td>
                    </tr>
                    <tr>
                        <th>Available Sizes</th>
                        <td><?php echo htmlspecialchars($dress['SIZES']); ?></td>
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
