<?php
// Connect to the database
$dbcon = mysqli_connect("localhost", "root", "", "fashion");
if (!$dbcon) {
    die("Connection failed: " . mysqli_connect_error());
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

        .hero {
            background-image: url('IMG_1711.JPG');
            background-size: cover;
            background-position: center;
            padding: 100px 20px;
            text-align: center;
            color: white;
            height: 110px;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: white;
            margin-top: -50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: palevioletred;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .dress-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease;
            flex: 1;
        }

        .dress-card img {
            width: 100%;
            border-radius: 10px 10px 0 0;
        }

        .dress-card h3 {
            margin: 15px 0 10px;
            font-size: 1.2em;
        }

        .dress-card button {
            background-color: palevioletred;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dress-card button:hover {
            background-color: #d06c9f;
        }

        .dress-card:hover {
            transform: translateY(-5px);
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
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            border-radius: 10px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
    <div class="hero"></div>

    <div class="container">
        <h1>Choose Your Fabric</h1>
        <p>Browse through our selection of high-quality fabrics and choose the perfect one for your custom dress.</p>
        
        <div class="card-container">
            <?php
            // Display each fabric
            $fabrics_query = "SELECT * FROM fabrics";
            $result = mysqli_query($dbcon, $fabrics_query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='dress-card'>";
                    echo "<img src='" . $row['IMAGE_URL'] . "' alt='" . $row['DESCRIPTION'] . "'>";
                    echo "<h3>" . htmlspecialchars($row['NAME']) . "</h3>";
                    echo "<button onclick=\"showFabricDetails('" . htmlspecialchars($row['NAME']) . "', '" . htmlspecialchars($row['IMAGE_URL']) . "', '" . htmlspecialchars($row['DESCRIPTION']) . "', '₹" . htmlspecialchars($row['PRICE_PER_UNIT']) . "')\">View Details</button>";
                    echo "</div>";
                }
            } else {
                echo "<p>No fabrics available at the moment.</p>";
            }
            ?>
        </div>
    </div>

<?php
// Close database connection
mysqli_close($dbcon);
?>

    <!-- Modal structure -->
    <div id="fabricModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle"></h2>
            <img id="modalImage" src="" alt="" style="width: 100%; border-radius: 10px;">
            <p id="modalDescription"></p>
            <p id="modalPrice"></p>
        </div>
    </div>

    <script>
    function showFabricDetails(name, imageUrl, description, price) {
        document.getElementById('modalTitle').textContent = name;
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalDescription').textContent = description;
        document.getElementById('modalPrice').textContent = price;

        var modal = document.getElementById('fabricModal');
        modal.style.display = "block";

        var closeModal = document.getElementsByClassName("close")[0];
        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
    </script>
    
    <div class="footer">
        <p>&copy; 2024 Women's Boutique. All Rights Reserved.</p>
    </div>
</body>
</html>
