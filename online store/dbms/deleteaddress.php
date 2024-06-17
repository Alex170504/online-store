<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

// 检查是否传递了产品 ID
if (isset($_GET['a_id'])) {
    $a_id = $_GET['a_id'];
    
    // 构建 SQL 查询来删除产品
    $sql_delete = "DELETE FROM address WHERE a_id = '$a_id'";
    
    // 执行删除操作
    if (mysqli_query($conn, $sql_delete)) {
        // 删除成功，显示 JavaScript 弹窗
        echo '<script>alert("Address deleted successfully."); window.location="address_book.php";</script>';
    } else {
        // 删除失败，输出错误信息并显示 JavaScript 弹窗
        echo '<script>alert("Error deleting address: ' . mysqli_error($conn) . '");</script>';
    }
}

// 重定向回产品列表页面
//header("Location: address_book.php");
//exit();
?>