<?php
session_start();
/**
 * Product List 
 */
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

$num_per_page = 25;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
;
$start_from = ($page - 1) * $num_per_page;

$count = 1;


// 检查卖家身份
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // 重定向到登录页面
    exit;
}
$sql_product = "SELECT p_id, p_name, inventory, price, img_path, s_id FROM product WHERE s_id = '".$_SESSION['id']."' LIMIT $start_from, $num_per_page";
$result_product=mysqli_query($conn,$sql_product);
$result = mysqli_query($conn,$sql_product);
$row_product=mysqli_fetch_array($result_product);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>My Online Store</h1>
    </header>
    <nav>
        <a href="seller_product.php">Products</a>
        <a href="seller_order.php">Order</a>
        <a href="logout.php">Log Out</a>
    </nav>


    <?php
    if (mysqli_num_rows($result) >= 0) {
        ?>
        <link rel="stylesheet" href="./css/table.css">
        <fieldset class="layui-elem-field layui-field-title"
            style="margin-top: 20px; background-color:#f5ae6f; border-color: #efa565">
            <div style="text-align: center;"><a href="addproduct.php"
                    style="color: #ffffff; text-decoration: none; font-size: 18px">Click here to add product</a></div>
        </fieldset>
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
                        <th>Inventory</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Seller_id</th>
                        <th>Operation</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td>
                                <?= $row['p_id'] ?>
                            </td>
                            <td>
                                <?= $row['p_name'] ?>
                            </td>
                            <td>
                                <?= $row['inventory'] ?>
                            </td>
                            <td>
                                <?= $row['price'] ?>
                            </td>
                            <td>
                                <img src="<?= $row['img_path'] ?>" alt="Product Image" style="width: 100px; height: auto;">
                            </td>
                            <td>
                                <?= $row['s_id'] ?>
                            </td>
                            <td><a href="editproduct.php?p_id=<?= $row['p_id'] ?>">Edit Product</a></td>
                        </tr>

                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <?php
        $sql = "SELECT * FROM product";
        $rs_result = mysqli_query($conn, $sql);
        $total_records = mysqli_num_rows($rs_result);
        $total_pages = ceil($total_records / $num_per_page);

        echo "<a href='seller_product.php?page=1'>" . '|<' . "</a> &nbsp;  &nbsp;";

        $i = $page;
        if ($i != 1) {
            echo "<a href='seller_product.php?page=" . ($i - 1) . "'>Last Page</a> ";
        }
        if ($i != $total_pages) {
            echo "<a href='seller_product.php?page=" . ($i + 1) . "'>Next Page</a> ";
        }
        echo "<a href='seller_product.php?page=$total_pages'>" . '>|' . "</a> ";
        ?>
        <?php
    }
    ?>

    <footer>
        <p>&copy; Group2 Online Store</p>
    </footer>
</body>

</html>