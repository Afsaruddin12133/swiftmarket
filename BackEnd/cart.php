<?php
session_start();

if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "E_Commerce";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative">
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

    <main class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <section>
            <h2 class="text-2xl font-bold mb-4">Shopping Cart</h2>
            <table class="min-w-full bg-white border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Product Name</th>
                        <th class="border px-4 py-2">Quantity</th>
                        <th class="border px-4 py-2">Price</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;

          
                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        $sql = "SELECT * FROM products WHERE id = $product_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $name = $row['name'];
                            $price = $row['price'];
                            $item_total = $quantity * $price;
                            $total += $item_total;

                            echo "<tr>";
                            echo "<td class='border px-4 py-2'>$name</td>";
                            echo "<td class='border px-4 py-2'>$quantity</td>";
                            echo "<td class='border px-4 py-2'>$$price</td>";
                            echo "<td class='border px-4 py-2'>$$item_total</td>";
                            echo "<td class='border px-4 py-2'>
                                    <form method='post' action=''>
                                        <input type='hidden' name='product_id' value='$product_id'>
                                        <button type='submit' name='remove' class='btn btn-error'>Remove</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    }

                    // Display total
                    echo "<tr>";
                    echo "<td colspan='3' class='border px-4 py-2 font-bold'>Total:</td>";
                    echo "<td class='border px-4 py-2 font-bold'>$$total</td>";
                    echo "<td class='border px-4 py-2'></td>";
                    echo "</tr>";
                    ?>
                </tbody>
            </table>
            <form action="../FrontEnd/html/checkout.html" method="post" class="mt-4">
                <input type="submit" value="Checkout" class="btn btn-primary" />
            </form>
        </section>
    </main>
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

<?php $conn->close(); ?>
