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
$payment_method = $_POST['payment'];


/// 计算购物车中商品的总价
$sql_total_price = "SELECT SUM(p.price) AS total_price
FROM shopping_cart sc
JOIN product p ON sc.p_id = p.p_id
WHERE sc.u_id = ?";
$stmt_total_price = mysqli_prepare($conn, $sql_total_price);
mysqli_stmt_bind_param($stmt_total_price, "i", $logged_in_user_id);
mysqli_stmt_execute($stmt_total_price);
$result_total_price = mysqli_stmt_get_result($stmt_total_price);
$row = mysqli_fetch_assoc($result_total_price);
$total_price = $row['total_price'];

// 查询购物车中的产品
$sql_shopping_cart = "SELECT p.p_id, p.s_id
                      FROM shopping_cart sc
                      JOIN product p ON sc.p_id = p.p_id
                      WHERE sc.u_id = ?";
$stmt_shopping_cart = mysqli_prepare($conn, $sql_shopping_cart);
mysqli_stmt_bind_param($stmt_shopping_cart, "i", $logged_in_user_id);
mysqli_stmt_execute($stmt_shopping_cart);
$result_shopping_cart = mysqli_stmt_get_result($stmt_shopping_cart);

if (mysqli_num_rows($result_shopping_cart) >= 0) {
    // 插入订单信息到订单表中
    $sql_insert_order = "INSERT INTO orders (total_price, payment_method, u_id)
                         VALUES (?, ?, ?)";
    $stmt_insert_order = mysqli_prepare($conn, $sql_insert_order);
    mysqli_stmt_bind_param($stmt_insert_order, "isi", $total_price, $payment_method, $logged_in_user_id);
    $result_insert_order = mysqli_stmt_execute($stmt_insert_order);

    if ($result_insert_order) {
        // 获取刚插入的订单 ID
        $order_id = mysqli_insert_id($conn);
        echo "<script>alert('Confirm successfully, order_id :$order_id'); window.location='my_order.php';</script>";
        // 清空购物车
        $sql_clear_shopping_cart = "DELETE FROM shopping_cart WHERE u_id = ?";
        $stmt_clear_shopping_cart = mysqli_prepare($conn, $sql_clear_shopping_cart);
        mysqli_stmt_bind_param($stmt_clear_shopping_cart, "i", $logged_in_user_id);
        $result_clear_shopping_cart = mysqli_stmt_execute($stmt_clear_shopping_cart);

        if ($result_clear_shopping_cart) {
            echo "Cart cleared successfully";
        } else {
            echo "Cart not cleared successfully";
        }

        // 遍历购物车中的产品，插入到 have_op 和 have_os 表中
        $sql_insert_have_op = "INSERT INTO have_op (o_id, p_id) VALUES (?, ?)";
        $stmt_insert_have_op = mysqli_prepare($conn, $sql_insert_have_op);

        $sql_insert_have_os = "INSERT INTO have_os (o_id, s_id) VALUES (?, ?)";
        $stmt_insert_have_os = mysqli_prepare($conn, $sql_insert_have_os);

        while ($row = mysqli_fetch_assoc($result_shopping_cart)) {
            $product_id = $row['p_id'];
            $store_id = $row['s_id'];

            // 插入 have_op 记录
            mysqli_stmt_bind_param($stmt_insert_have_op, "ii", $order_id, $product_id);
            mysqli_stmt_execute($stmt_insert_have_op);

            // 插入 have_os 记录
            mysqli_stmt_bind_param($stmt_insert_have_os, "ii", $order_id, $store_id);
            mysqli_stmt_execute($stmt_insert_have_os);
        }
    } else {
        $error_message = mysqli_error($conn);
    echo "SQL Error: " . $error_message;
    }
} else {
    echo "No products in cart";
}