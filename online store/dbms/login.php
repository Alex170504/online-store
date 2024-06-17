<?php
session_start();
/**
 * Login page
 */

//Login

include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();
$conn1 = $dbConnect->connectdb();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $password = $_POST["password"];
    $identity = $_POST["identity"];

    if (empty($id)) {
        echo '<script>alert("Please enter your id, it is jumping...."); window.location.href = "login.php";</script>';
    } elseif (empty($password)) {
        echo '<script>alert("Please enter your password, it is jumping...."); window.location.href = "login.php";</script>';

    } elseif (empty($identity)) {
        echo '<script>alert("Please select your identity, it is jumping...."); window.location.href = "login.php";</script>';
    }

    if ($identity === "user") {
        $sql = "SELECT * FROM users WHERE u_id = ? AND password = ?";
    } elseif ($identity === "seller") {
        $sql = "SELECT * FROM seller WHERE s_id = ? AND password = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $password);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $usersrow = $result->fetch_assoc();

        if ($identity == "user") {
            echo "User login successful";
            $_SESSION['id'] = $usersrow["u_id"];
            header("Location: user_product.php");
        } else {
            echo "Seller login successful";
            $_SESSION['id'] = $usersrow["s_id"];
            header("Location: seller_product.php");
        }
        exit;
    } else {
        echo "Login failed, account or password error";
    }
    header("refresh:1;url=login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/styles0.css">
</head>

<body>
    <form action="login.php" method="post">
        <h1 style="color: #d89152;">Login</h1>
        <input type="number" name="id" placeholder="Please enter your id">
        <input type="password" name="password" placeholder="Please enter your password">
        <button type="submit">Login</button>
        <p>
            <label>
                <input type="radio" name="identity" value="user"> User
            </label>
            <label>
                <input type="radio" name="identity" value="seller"> Seller
            </label>
            <br><br>
            Don't have an account? <a href="register.php">Register</a>
        </p>
    </form>
</body>

</html>