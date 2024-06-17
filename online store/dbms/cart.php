<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

$num_per_page = 25;

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $num_per_page;
$logged_in_user_id = $_SESSION['id'];
$user_id = $_SESSION['id'];
$sql_product = "SELECT p.p_id, p.p_name, p.price, p.img_path
                FROM shopping_cart sc
                INNER JOIN product p ON sc.p_id = p.p_id
                WHERE sc.u_id = '$user_id'
                LIMIT $start_from, $num_per_page";

$result_product = mysqli_query($conn, $sql_product);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store - Cart</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <img src="./pic/logo.jpg" alt="logo of the online store" class="logo">
        <h1>Welcome to your Cart</h1>
    </header>
    <nav>
    <a href="user_product.php">Products</a>
    <a href="cart.php">Cart</a>
    <a href="myaccount.php">My Account</a>
    <input type="text" placeholder="Search...">
    <button>Search</button>
    <a href="logout.php">Log Out</a>
    </nav>

    <?php
    if ($result_product && mysqli_num_rows($result_product) >= 0) {
        ?>
        <link rel="stylesheet" href="./css/table.css">
        <div style="text-align:center;">
            <table class="list-table">
                <colgroup>
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                </colgroup>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result_product)) {
                        ?>
                        <tr>
                            <td>
                                <?= $row['p_id'] ?>
                            </td>
                            <td>
                                <?= $row['p_name'] ?>
                            </td>
                            <td>
                                <?= $row['price'] ?>
                            </td>
                            <td><img src="<?= $row['img_path'] ?>" alt="Product Image" style="width: 100px; height: auto;"></td>
                            <td><a href="deletecart.php?p_id=<?= $row['p_id'] ?>">Delete</a></td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div style="text-align: center;">
            <form method="post" action="checkout.php">
                <button type="submit" style="display: inline-block; font-size: 20px;">Checkout</button>
            </form>
        </div>



        <?php
        $total_records = mysqli_num_rows($result_product);
        $total_pages = ceil($total_records / $num_per_page);

        echo "<div style='text-align: center;'>";

        echo "<a href='cart.php?page=1'>" . '|<' . "</a> &nbsp;  &nbsp;";

        $i = $page;
        if ($i > 1) {
            echo "<a href='cart.php?page=" . ($i - 1) . "'>Last Page</a> ";
        }
        if ($i < $total_pages) {
            echo "<a href='cart.php?page=" . ($i + 1) . "'>Next Page</a> ";
        }
        echo "<a href='cart.php?page=$total_pages'>" . '>|' . "</a> ";

        echo "</div>";
    } else {
        // No results found
        echo "<p style='text-align: center;'>No favorites found.</p>";
    }
    ?>
    <footer>
        <p>&copy; Group2 Online Store</p>
    </footer>
</body>

</html>