<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    if (mysqli_num_rows($result) > 0) {
        $dress = mysqli_fetch_assoc($result);
    } else {
        die("Dress not found.");
    }
} else {
    die("Invalid dress ID.");
}

// Function to safely handle null values
function safeOutput($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo safeOutput($dress['NAME']); ?></title>
    <style>
        /* Your CSS styling */
    </style>
</head>
<body>

    <div class="container">
        <h1><?php echo safeOutput($dress['NAME']); ?></h1>
        <div class="dress-details">
            <img src="<?php echo safeOutput($dress['IMAGE_URL']); ?>" alt="<?php echo safeOutput($dress['NAME']); ?>">
            <div class="dress-info">
                <h2>Dress Description</h2>
                <p><?php echo safeOutput($dress['DESCRIPTION']); ?></p>
                <p class="price">Price: ₹<?php echo number_format($dress['BASE_PRICE'] ?? 0, 2); ?></p>
                
                <div class="option-buttons">
                    <a href="buy_as_is.php?id=<?php echo $dress_id; ?>" class="option-button">Buy As-Is</a>
                    <a href="customize.php?id=<?php echo $dress_id; ?>" class="option-button">Customize</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($dbcon);
?>
