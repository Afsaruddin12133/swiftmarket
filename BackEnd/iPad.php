<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "E_Commerce";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, name, description, slug, price, photo, date_view, counter FROM products where type='iPad'";
$result = $conn->query($sql);


if (isset($_POST["add_to_cart"])) {

    $product_id = $_POST["product_id"];


    $product_quantity = $_POST["product_quantity"];


    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    $_SESSION["cart"][$product_id] = $product_quantity;
    header("location:./cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Website</title>
    <link rel="stylesheet" href="../css/home.css">
    <script src="https://kit.fontawesome.com/40d2e52eb8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative ">
    <!-- navigation section -->
    <div class="navbar bg-base-100 sticky z-10 top-0">
        <div class="flex-1">
            <a href="../FrontEnd/html/home.html"><img class="h-auto max-w-xs" src="../images/logo/logo.png" alt=""></a>
        </div>
        <div>
            <ul class="menu menu-horizontal px-1">
                <li><a href="../FrontEnd/html/home.html">Home</a></li>
                <li>
                    <details>
                        <summary>Product</summary>
                        <ul class="p-2">
                            <li><a href="./laptop.php">laptop</a></li>
                            <li><a href="./iPad.php">iPad</a></li>
                            <li><a href="./mobile.php">Mobile</a></li>
                            <li><a href="./pc.php">PC</a></li>
                        </ul>
                    </details>
                </li>
                <li><a href="../FrontEnd/html/aboutus.html">About Us</a></li>
            </ul>
        </div>
        <div class="flex-none gap-2">
            <div class="form-control">
                <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
            </div>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                    </div>
                </div>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li>
                        <a class="justify-between">
                            Profile
                            <span class="badge">New</span>
                        </a>
                    </li>
                    <li><a>Settings</a></li>
                    <li><a href="./logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

    <main class="z-0">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imagePath = "../images/Product_images/lap_Images/" . $row["photo"];
                    echo "<div class='card w-96 bg-base-100 shadow-xl'>";
                    echo "<figure><img src='" . $imagePath . "' alt='" . $row["name"] . "' /></figure>";
                    echo "<div class='card-body'>";
                    echo "<h2 class='card-title'>" . $row["name"] . "</h2>";
                    echo "<p>" . $row["description"] . "</p>";
                    echo "<p><strong>Price: </strong>$" . $row["price"] . "</p>";
                    echo "<div class='card-actions justify-end'>";
                    echo "<form method='post' action=''>";
                    echo "<input type='hidden' name='product_id' value='" . $row["id"] . "'>";
                    echo "<label for='quantity_" . $row["id"] . "'>Quantity:</label>";
                    echo "<input type='number' id='quantity_" . $row["id"] . "' name='product_quantity' value='1' min='1' max='10' class='input input-bordered w-24 md:w-auto'>";
                    echo "<button type='submit' name='add_to_cart' class='btn btn-primary'>Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No products found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</main>

    <!-- footer section -->
    <footer class="footer p-10 bg-neutral text-neutral-content">
        <nav>
            <h6 class="footer-title">Services</h6>
            <a class="link link-hover">Branding</a>
            <a class="link link-hover">Design</a>
            <a class="link link-hover">Marketing</a>
            <a class="link link-hover">Advertisement</a>
        </nav>
        <nav>
            <h6 class="footer-title">Company</h6>
            <a class="link link-hover">About us</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Jobs</a>
            <a class="link link-hover">Press kit</a>
        </nav>
        <nav>
            <h6 class="footer-title">Legal</h6>
            <a class="link link-hover">Terms of use</a>
            <a class="link link-hover">Privacy policy</a>
            <a class="link link-hover">Cookie policy</a>
        </nav>
    </footer>
</body>
</html>
