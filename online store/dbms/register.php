<?php
session_start();
/**
 * Registration page
 */

include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

//Register
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $identity = $_POST["identity"];
    $submitted_code = $_POST['verify-code'];
    if (empty($id)) {
        echo '<script>alert("Please enter your id, it is jumping...."); window.location.href = "register.php";</script>';
    }
    if (empty($name)) {
        echo '<script>alert("Please enter your name, it is jumping...."); window.location.href = "register.php";</script>';
    }
    if (empty($password)) {
        echo '<script>alert("Please enter your password, it is jumping...."); window.location.href = "register.php";</script>';
    }
    if ($password !== $confirm_password) {
        echo '<script>alert("Please confirm your password, it is jumping...."); window.location.href = "register.php";</script>';
    }
     // Check if verification code is correct
     $submitted_code = $_POST['verify-code'];
     if (empty($submitted_code) || $submitted_code !== $_SESSION['captcha_code']) {
      echo '<script>alert("Verification code is incorrect, it is jumping...");  window.location.href = "register.php";</script>';
     exit;
 }
    if (empty($identity)) {
        echo '<script>alert("Please select your identity, it is jumping...."); window.location.href = "register.php";</script>';
        exit;
    }

// Your existing code...
if ($identity == "user") {
    $check_account1 = "SELECT * FROM users WHERE  u_id= '" . $id . "'";
    $result1 = mysqli_query($conn, $check_account1);
    if (mysqli_num_rows($result1) > 0) {
        echo '<script>alert("ID already exists."); window.location.href = "register.php";</script>';
    } else {
        $sql1 = "INSERT INTO users(u_id, u_name, password) VALUES ('$id', '$name', '$password')";
        if (mysqli_query($conn, $sql1)) {
            $sql1 = "INSERT INTO users(u_id, u_name, password) VALUES ('$id', '$name', '$password')";
            echo "<script>alert('User successful registration, it is jumping....');</script>";
            header("refresh:1;url=login.php");
            exit;
        } else {
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            echo "<script>alert('Registration failed, it is jumping....');</script>";
            
           
            exit;
        }
    }

    } else if ($identity == "seller") {
        $check_account2 = "SELECT * FROM seller WHERE  s_id= '" . $id . "'";
        $result2 = mysqli_query($conn, $check_account2);
        if (mysqli_num_rows($result2) > 0) {
            echo "ID already exists, it is jumping";
            header("Location: register.php"); // 重定向回产品页面
            exit();
        } else {
            $sql2 = "INSERT INTO seller(s_id, store_name, password) VALUES ('$id', '$name', '$password')";
            if (mysqli_query($conn, $sql2)) {
                echo '<script>alert("Seller successful registration, it is jumping...."); window.location.href = "login.php";</script>';
                exit;
            } else {
                echo '<script>alert("Registration failed, it is jumping....");window.location.href = "register.php"</script>';
                exit;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Registration</title>
    <link rel="stylesheet" href="./css/styles0.css">
</head>

<body id="register_bg">
    <div class="register_box">
        <form id="register_form" action="register.php" method="POST">
            <h1>Registration</h1>
            <div id="input_box">
                <label>ID</label>
                <input type="number" name="id" value="" class="register_input" placeholder="Please enter your ID">
            </div>
            <div id="input_box">
                <label>Name</label>
                <input type="text" name="name" value="" class="register_input" placeholder="Please enter your name">
            </div>
            <div id="input_box">
                <label>Password</label>
                <input type="password" name="password" class="register_input" placeholder="Please enter your password">
            </div>
            <div id="input_box">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="register_input"
                    placeholder="Please confirm password">
            </div>
            <div>
                <label for="verify-code">Verification code:</label>
                <input type="text" id="verify-code" class="register_input" name="verify-code" required>
            </div>
            <div id="verify">
                <img id="verify-image" src="generate_code.php" alt="Verification code image">
                <button id="refresh-verify-code" class="verify_button">Refresh code</button>
            </div>
            <p>
                <label>
                    <input type="radio" name="identity" value="user" id="identity_0">
                    User</label>
                <label>
                    <input type="radio" name="identity" value="seller" id="identity_1">
                    Seller</label>
            </p>
            <button type="submit" id="register_button">
                Register
            </button><br>
            <p>
                Already have an account?<a href="login.php">Login</a>
            </p>
        </form>

    </div>
</body>

</html>