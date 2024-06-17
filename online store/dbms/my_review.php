<?php
session_start();
/**
 * Review List 
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
$sql_product = "SELECT * FROM review  WHERE u_id = '".$_SESSION['id']."' LIMIT $start_from, $num_per_page";
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
      <img src="./pic/logo.jpg" alt="logo of the online store" class="logo" >
    <h1>Welcome to our Online Store</h1>
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
    if (mysqli_num_rows($result) >= 0) {
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
                        <th>Review ID</th>
                        <th>Review content</th>
                        <th>User ID</th>
                        <th>Order ID</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td>
                                <?= $row['r_id'] ?>
                            </td>
                            <td>
                                <?= $row['content'] ?>
                            </td>
                            <td>
                                <?= $row['u_id'] ?>
                            </td>
                            <td>
                                <?= $row['o_id'] ?>
                            </td>
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

        echo "<a href='my_review.php?page=1'>" . '|<' . "</a> &nbsp;  &nbsp;";

        $i = $page;
        if ($i != 1) {
            echo "<a href='my_review.php?page=" . ($i - 1) . "'>Last Page</a> ";
        }
        if ($i != $total_pages) {
            echo "<a href='my_review.php?page=" . ($i + 1) . "'>Next Page</a> ";
        }
        echo "<a href='my_review.php?page=$total_pages'>" . '>|' . "</a> ";
        ?>
        <?php
    }
    ?>
  <footer>
    <p>&copy; Group2 Online Store</p>
  </footer>
</body>
</html>
