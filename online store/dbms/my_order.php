<?php
session_start();

include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

$num_per_page = 25;
if (isset($_GET["page"])) {
  $page = $_GET["page"];
} else {
  $page = 1;
}

$start_from = ($page - 1) * $num_per_page;

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit;
}

$sql_order = "SELECT * FROM orders WHERE u_id = '" . $_SESSION['id'] . "' LIMIT $start_from, $num_per_page";
$result_order = mysqli_query($conn, $sql_order);

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
    <img src="./pic/logo.jpg" alt="logo of the online store" class="logo">
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
  if ($result_order) {
    if (mysqli_num_rows($result_order) > 0) {
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
              <th>Order ID</th>
              <th>Total Price</th>
              <th>Payment Method</th>
              <th>User ID</th>
              <th>Add Review</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row_order = mysqli_fetch_array($result_order)) {
              ?>
              <tr>
                <td>
                  <?= $row_order['o_id'] ?>
                </td>
                <td>
                  <?= $row_order['total_price'] ?>
                </td>
                <td>
                  <?= $row_order['payment_method'] ?>
                </td>
                <td>
                  <?= $row_order['u_id'] ?>
                </td>
                <td><a href="ADD_Review.php?o_id=<?= $row_order['o_id'] ?>">Add Review</a></td>
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
      <?php
    } else {
      echo "<p>No orders found.</p>";
    }
  } else {
    echo "Error: " . mysqli_error($conn);
  }
  ?>

  <footer>
    <p>&copy; Group2 Online Store</p>
  </footer>
</body>

</html>