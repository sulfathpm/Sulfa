<?php
session_start();
error_reporting(0);
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

if($_SERVER["REQUEST_METHOD"] == "GET"){
   
    //check if the user logged in or not
    if($_SESSION["USER_ID"]==null){
         $_SESSION["KEY"]='to-customise-dress';
        // header("Location: login.php"); 
        echo "<script>alert('You need to login to customise dress'); window.location.href='login.php';</script>";
    }

    

}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dressStyle = htmlspecialchars($_POST['dress-style']);
    $fabric = htmlspecialchars($_POST['fabric']);
    $color = htmlspecialchars($_POST['color']);
    $embellishments = htmlspecialchars($_POST['embellishments']);
    $sizes = htmlspecialchars($_POST['sizes']);
    $dresslength = htmlspecialchars($_POST['dresslength']);
    $sleevelength = htmlspecialchars($_POST['sleevelength']);
    $additionalNotes = htmlspecialchars($_POST['additional-notes']);
    $sql1= "SELECT DRESS_ID FROM dress";


    // Insert data into database
    $sql = "INSERT INTO customizations (DRESS_ID, FABRIC_ID, COLOR, EMBELLISHMENTS, SIZES, DRESS_LENGTH, SLEEVE_LENGTH, ADDITIONAL_NOTES)
            VALUES ('$dressStyle', '$fabric', '$color', '$embellishments', '$sizes', '$dresslength', '$sleevelength', '$additionalNotes')";

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
        <a href="custmrdshbrd.php">Home</a>
        <a href="fabric.php">Choose by Fabric</a>
        <a href="abt.php">About</a>
        <a href="contact1.php">Contact</a>
        <?php
        if($_SESSION["USER_ID"]==null){
           echo "<a href='login.php'>Login</a>";
        }else{
            echo "<a href='logout.php'>Logout</a>";
        }
        ?>
        <a href="customize1.php" class="customize-button">Customize Now</a>
    </div>

    <div class="container">
        <h2>Customize Your Dress</h2>

        <form id="customization-form" method="POST" action="customize.php">
            <div class="form-group">
                <?php
                    if($_SESSION["DRESS_ID"]==null){

                    
                        echo "<label for='dress-style'>Select Dress Style:</label>
                        <select id='dress-style' name='dress-style' onchange='updatePrice()'>
                        <option value='none' data-price='0'>None</option>
                            <option value='evening' data-price='2000'>Evening Dress - ₹2000</option>
                            <option value='summer' data-price='1500'>Summer Dress -₹1500</option>
                            <option value='bridesmaid' data-price='1200'>Bridesmaid Dress - ₹1200</option>
                            <option value='cocktail' data-price='2500'>Cocktail Dress- ₹2500</option>
                            <option value='bohemian' data-price='1400'>Bohemian Maxi Dress -₹1400</option>
                            <option value='saree' data-price='2100'>Saree - ₹2100</option>
                            <option value='vintage' data-price='2199'>Vintage Lace Dress  - ₹2199</option>
                            <option value='salwar' data-price='900'>salwar suit  -₹900</option>
                            <option value='aline' data-price='1400'>Modern A-Line Dress - ₹1400</option>
                            <option value='qipao' data-price='2299'>Qipao - ₹2299</option>
                            <option value='embroidery' data-price='2100'>Embroidered Midi Dress - ₹2100</option>
                            <option value='skater' data-price='1200'>Pleated Skater Dress -₹1200</option>
                        </select>";
                    }else{
                        $sql="SELECT * FROM dress WHERE DRESS_ID=".$_SESSION["DRESS_ID"]."";
                        $data=mysqli_query($conn,$sql);
                        if($data){
                            $dress=mysqli_fetch_array($data);
                            echo "<label for='dress-style'>Your Dress Style:</label>
                                <select id='dress-style' name='dress-style' onchange='updatePrice()'>
                                    <option value='evening' data-price='".$dress['BASE_PRICE']."'>".$dress['NAME']." - ₹".$dress['BASE_PRICE']."</option>
                                </select>";
                        }
                        
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="fabric">Choose Fabric(Per meter):</label>
                <select id="fabric" name="fabric" onchange="updatePrice()">
                <option value="none" data-price="0">None</option>
                    <option value="lace" data-price="500">Lace - +₹500</option>
                    <option value="silk" data-price="700">Silk - +₹700</option>
                    <option value="cotton" data-price="300">Cotton - +₹300</option>
                    <option value="modal" data-price="900">Modal Silk - +₹900</option>
                    <option value="chiffon" data-price="350">Chiffon - +₹350</option>
                    <option value="tweed" data-price="1200">Tweed - +₹1200</option>
                    <option value="velvet" data-price="500">Velvet - +₹500</option>
                    <option value="denim" data-price="500">Denim - +₹500</option>
                    <option value="satin" data-price="800">Satin - +₹800</option>
                    <option value="linen" data-price="600">Linen - +₹600</option>
                    <option value="tulle" data-price="660">Tulle - +₹660</option>
                    <option value="crepe" data-price="400">Crepe - +₹400</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">Select Color:</label>
                <input type="color" id="color" name="color">
            </div>

            <div class="form-group">
                <label for="embellishments">Add Embellishments(Per meter):</label>
                <select id="embellishments" name="embellishments" onchange="updatePrice()">
                    <option value="none" data-price="0">None</option>
                    <option value="beads" data-price="50">BEADS - +₹50</option>
                    <option value="sequins" data-price="100">SEQUINS - +₹100</option>
                    <option value="embroidery" data-price="0">EMBROIDERY - +₹150 </option>
                    <option value="applique" data-price="15">APPLIQUÉ - + ₹50</option>
                    <option value="lace" data-price="20">LACE - +₹100</option>
                    <option value="fringe" data-price="0">FRINGE - +₹100</option>
                    <option value="pearl" data-price="15">PEARL - +₹200 </option>
                    <option value="piping" data-price="20">PIPING - +₹50</option>
                    <option value="rhinestone" data-price="20">RHINESTONE - +₹150</option>

                </select>
                <p style="color:palevioletred">(Price may vary depending on the complexity of the design)</p>
            </div>

            <div class="form-group">
                <label for="sizes">Choose Size:</label>
                <select id="sizes" name="sizes">
                    <option value="xs">XS</option>
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                    <option value="xl">XL</option>
                    <option value="xxl">XXL</option>
                </select>
            </div>
                <div class="form-group">
                <label for="dresslength">Dress Length:</label>
                <select id="dresslength" name="dresslength">
                    <option value="mini">MINI</option>
                    <option value="knee">KNEE-LENGTH</option>
                    <option value="tea">TEA-LENGTH</option>
                    <option value="midi">MIDI</option>
                    <option value="maxi">MAXI</option>
                    <option value="full">FULL-LENGTH</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sleevelength">Sleeve Length:</label>
                <select id="sleevelength" name="sleevelength">
                    <option value="sleeveless">SLEEVELESS</option>
                    <option value="short">SHORT</option>
                    <option value="elbow">ELBOW</option>
                    <option value="3/4">3/4</option>
                    <option value="full">FULL-LENGTH</option>
                    </select>
            </div>

            <div class="form-group">
                <label for="measurements">Enter Measurements (in inches):</label>
                <input type="text" id="shoulder" name="shoulder" placeholder="shoulder">
                <input type="text" id="bust" name="bust" placeholder="Bust">
                <input type="text" id="waist" name="waist" placeholder="Waist">
                <input type="text" id="hips" name="hips" placeholder="Hips">
            </div>

            <div class="form-group">
                <label for="additional-notes">Additional Notes:</label>
                <textarea id="additional-notes" name="additional-notes" placeholder="Enter any special requests..."></textarea>
            </div>
            <div class="form-group">
                <label for="file-upload">Upload file:</label>
                <input type="file" id="file-upload" name="file-upload">
            </div>

            <h3>Total Price: ₹<span id="total-price">0</span></h3>
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