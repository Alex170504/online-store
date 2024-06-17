<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['id'];
    $usr = $_POST["name"];
    $pho = $_POST["phone"];
    $adr = $_POST["address"];

    if (!empty($usr) && !empty($pho) && !empty($adr)) {
        // Check if the address already exists
        $check_sql = "SELECT * FROM address WHERE u_id = '$user_id' AND name = '$usr' AND phone = '$pho' AND address = '$adr'";
        $result_check = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($result_check) > 0) {
            echo "Address already exists.";
        } else {
            $sql = "INSERT INTO address (u_id, name, phone, address) VALUES ('$user_id', '$usr', '$pho', '$adr')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('New address created successfully'); window.location='address_book.php';</script>";
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Please fill in all the fields.";
    }
} else {
    
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Address</title>
  <link rel="stylesheet" href="./css/styles0.css">
</head>
<body>
  <form action="ADD_Address.php" method="POST">
    <h2 style="color: #d89152;">Add Address</h2>
	<input type="text" name="name" placeholder="Name">
    <input type="tel" name="phone" placeholder="Contact Number" maxlength="11" required>
    <input type="text" name="address" placeholder="Address">
    <input type="submit" value="Confirm" class="buttonstyle">
  </form>
  </body>
</html>
