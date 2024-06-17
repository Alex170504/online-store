<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

// 检查是否传递了产品 ID
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    
    // 构建 SQL 查询来删除产品
    $sql_delete = "DELETE FROM shopping_cart WHERE p_id = '$p_id'";
    
    // 执行删除操作
    if (mysqli_query($conn, $sql_delete)) {
        // 删除成功，显示 JavaScript 弹窗
        echo '<script>alert("Delete successfully, it is jumping...."); window.location.href = "cart.php";</script>';
    } else {
        // 删除失败，输出错误信息并显示 JavaScript 弹窗
        echo '<script>alert("Error deleting product: ' . mysqli_error($conn) . '");</script>';
        header("Location: cart.php"); // 重定向到登录页面
    exit;
    }
}

?>
