<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

if (isset($_GET['p_id'])&& isset($_SESSION['id'])) {
    $p_id = $_GET['p_id'];
    $u_id = $_SESSION['id'];
    $f_id = mt_rand(1, 9999); // Change the range as needed

    $sql_favorite = "INSERT INTO favorite (f_id, u_id, p_id) VALUES ('$f_id', '$u_id', '$p_id')";
    
    if (mysqli_query($conn, $sql_favorite)) {
        echo '<script>alert("Add to favorite successfully, it is jumping...."); window.location.href = "user_product.php";</script>';
    } else {
        echo "Error adding to favorites: " . mysqli_error($conn); // Output error message for debugging
        echo "SQL: " . $sql_favorite; // Output the SQL query for debugging
    }
} else {
    echo "Missing product ID or user ID."; // Output message for missing parameters
    header("Location: seller_product.php"); // 重定向到登录页面
    exit;
}

?>
