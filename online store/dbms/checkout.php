<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit;
}

$logged_in_user_id = $_SESSION['id'];
// 获取用户的地址信息
$sql_address = "SELECT * FROM address WHERE u_id = '$logged_in_user_id'";
$result_address = mysqli_query($conn, $sql_address);
$addresses = mysqli_fetch_all($result_address, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
  <header>
    <h1>Checkout</h1>
  </header>
  <nav>
    <br>
  </nav>
  <div class="checkout-form">
    <h2 style="color: #f5ae6f;">Select Address</h2>
    <form action="confirm_order.php" method="POST">
      <select name="address">
        <?php foreach ($addresses as $address): ?>
          <option value="<?= $address['address_id'] ?>">
            <?= $address['address'] ?>
          </option>
        <?php endforeach; ?>
      </select>
      <h2 style="color: #f5ae6f;">Payment Method</h2>
      <input type="radio" id="Alipay" name="payment" value="Alipay">
      <label for="alipay">Alipay</label><br>
      <input type="radio" id="Weixin Pay" name="payment" value="Weixin Pay">
      <label for="weixinpay">Weixin Pay</label><br>
      <input type="radio" id="Credit Card" name="payment" value="Credit Card">
      <label for="creditcard">Credit Card</label><br>
      <input type="radio" id="Paypal" name="payment" value="Paypal">
      <label for="paypal">PayPal</label><br><br>
      <button type="submit" style="width: 200px; height: 30px;">Confirm Order</button>
    </form>
  </div>
  <a href="cart.php" class="cancel-button">Cancel Order</a>
  <footer>
    <p>&copy; Group2 Online Store</p>
  </footer>
</body>

</html>