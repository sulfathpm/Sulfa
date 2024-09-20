<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fashion";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dressStyle = htmlspecialchars($_POST['dress-style']);
    $fabric = htmlspecialchars($_POST['fabric']);
    $color = htmlspecialchars($_POST['color']);
    $embellishments = htmlspecialchars($_POST['embellishments']);
    $sizes = htmlspecialchars($_POST['sizes']);
    // $bust = htmlspecialchars($_POST['bust']);
    // $waist = htmlspecialchars($_POST['waist']);
    // $hips = htmlspecialchars($_POST['hips']);
    $dresslength=htmlspecialchars($_POST['dresslength']);
    $sleevelength=htmlspecialchars($_POST['sleevelength']);
    $additionalNotes = htmlspecialchars($_POST['additional-notes']);

    // Insert data into database
    $sql = "INSERT INTO customizations (DRESS_ID, FABRIC_ID, COLOR, EMBELLISHMENTS, SIZES,DRESS_LENGTH,SLEEVE_LENGTH ,ADDITIONAL_NOTES)
    VALUES ('$dressStyle', '$fabric', '$color', '$embellishments', '$sizes', '$dresslength','$sleevelength', '$additionalNotes')";

    if ($conn->query($sql) === TRUE) {
        $message = "New record created successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Your Dress</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <style>
        /* Add your CSS here */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
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
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: palevioletred;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input[type="color"] {
            padding: 3px;
            height: 45px;
        }

        #total-price {
            color: palevioletred;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        button {
            background-color: palevioletred;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: block;
            width: 100%;
            margin: 0 auto;
        }

        button:hover {
            background-color: #d06c9f;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            margin-top: 40px;
            border-radius: 0 0 10px 10px;
        }

        @media (min-width: 768px) {
            .form-group {
                flex-direction: row;
                align-items: center;
            }

            .form-group label {
                width: 30%;
                margin-bottom: 0;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                width: 65%;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="home.html">Home</a>
        <a href="fabric.html">Choose by Fabric</a>
        <a href="abt.html">About</a>
        <a href="contact.html">Contact</a>
        <a href="login.html">Login</a>
        <a href="customize.php" class="customize-button">Customize Now</a>
    </div>

    <div class="container">
        <h2>Customize Your Dress</h2>

        <form id="customization-form" method="POST" action="customize.php">
            <div class="form-group">
                <label for="dress-style">Select Dress Style:</label>
                <select id="dress-style" name="dress-style" onchange="updatePrice()">
                    <option value="evening" data-price="120">Evening Dress - $120</option>
                    <option value="summer" data-price="80">Summer Dress - $80</option>
                    <option value="bridesmaid" data-price="90">Bridesmaid Dress - $90</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fabric">Choose Fabric:</label>
                <select id="fabric" name="fabric" onchange="updatePrice()">
                    <option value="silk" data-price="30">Silk - +$30</option>
                    <option value="cotton" data-price="20">Cotton - +$20</option>
                    <option value="lace" data-price="25">Lace - +$25</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">Select Color:</label>
                <input type="color" id="color" name="color">
            </div>

            <div class="form-group">
                <label for="embellishments">Add Embellishments:</label>
                <select id="embellishments" name="embellishments" onchange="updatePrice()">
                    <option value="none" data-price="0">None</option>
                    <option value="beads" data-price="15">Beads - +$15</option>
                    <option value="sequins" data-price="20">Sequins - +$20</option>
                </select>
            </div>

            <div class="form-group">
                <label for="size">Choose Size:</label>
                <select id="size" name="size">
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                </select>
            </div>

            <div class="form-group">
                <label for="measurements">Enter Measurements (in inches):</label>
                <input type="text" id="bust" name="bust" placeholder="Bust">
                <input type="text" id="waist" name="waist" placeholder="Waist">
                <input type="text" id="hips" name="hips" placeholder="Hips">
            </div>

            <div class="form-group">
                <label for="additional-notes">Additional Notes:</label>
                <textarea id="additional-notes" name="additional-notes" placeholder="Enter any special requests..."></textarea>
            </div>

            <h3>Total Price: $<span id="total-price">0</span></h3>
            <!-- <button type="submit">Preview Customization</button> -->
        
            <button type="submit">Submit</button>
        </form>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; 2024 Women's Boutique. All Rights Reserved.</p>
    </div>

    <script>
        function updatePrice() {
            const dressStyle = document.getElementById('dress-style');
            const fabric = document.getElementById('fabric');
            const embellishments = document.getElementById('embellishments');
            
            const dressPrice = parseInt(dressStyle.options[dressStyle.selectedIndex].getAttribute('data-price'));
            const fabricPrice = parseInt(fabric.options[fabric.selectedIndex].getAttribute('data-price'));
            const embellishmentsPrice = parseInt(embellishments.options[embellishments.selectedIndex].getAttribute('data-price'));
            
            const totalPrice = dressPrice + fabricPrice + embellishmentsPrice;
            document.getElementById('total-price').innerText = totalPrice;
        }

        document.addEventListener("DOMContentLoaded", updatePrice);
    </script>
</body>
</html>
