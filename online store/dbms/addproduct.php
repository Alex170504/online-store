
<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_id = $_POST["p_id"];
    $p_name = $_POST["p_name"];
    $inventory = $_POST["inventory"];
    $price = $_POST["price"];
    $s_id = $_POST["s_id"];

    $target_dir = "uploads/"; // 图片上传目录
    $target_file = $target_dir . basename($_FILES["img_path"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 检查文件是否为图像
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img_path"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // 检查文件大小
    if ($_FILES["img_path"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // 允许特定的文件格式
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.location='addproduct.php';</script>";
        $uploadOk = 0;
    }

    // 检查 $uploadOk 是否为 0
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.'); window.location='addproduct.php';</script>";
    } else {
        // 如果一切都符合要求，尝试上传文件
        if (move_uploaded_file($_FILES["img_path"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["img_path"]["name"]) . " has been uploaded.";

            // 将数据插入数据库
            $sql = "INSERT INTO product (p_id, p_name, inventory, price, img_path, s_id ) VALUES ('$p_id', '$p_name', '$inventory', '$price', '$target_file', '$s_id')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New product created successfully'); window.location='seller_product.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Sorry, there was an error adding your product. Please try it again.'); window.location='addproduct.php';</script>";
        }
    }
}

// 关闭连接
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <link rel="stylesheet" href="./css/styles0.css">
</head>

<body>
    <link rel="stylesheet" href="./css/book.css">
    <form class="book-form" name="myForm" action="addproduct.php" enctype="multipart/form-data" method="post" onsubmit="return validateForm()">
        <div class="book-form-item">
            <div class="book-form-item">
                <label class="book-form-label">ID</label>
                <div class="book-input-block">
                    <input type="number" name="p_id" placeholder="Please enter the id" class="book-input" min="0">
                </div>
            </div>
            <label class="book-form-label">Name</label>
            <div class="book-input-block">
                <input type="text" name="p_name" placeholder="Please enter the product name" class="book-input">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Inventory</label>
            <div class="book-input-block">
                <input type="number" name="inventory" placeholder="Please enter the inventory" class="book-input"
                    min="0" step="1">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Price</label>
            <div class="book-input-block">
                <input type="number" name="price" placeholder="Please enter the price" class="book-input" min="0.01"
                    step="0.01">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Seller ID</label>
            <div class="book-input-block">
                <input type="number" name="s_id" placeholder="Please enter the Seller ID" class="book-input" min="0">
                   
            </div>
        </div>
        <div>
            <label class="book-form-label">Image</label>
            <div class="book-input-block">
                <input type="file" name="img_path" accept="image/*">
            </div>
        </div>

        </div>
        <div class="book-form-item">
            <div class="book-input-block">
                <button style="margin-right:100px;" type="submit" class="book-btn" lay-submit="" lay-filter="demo1">Add</button>
                <a href="seller_product.php"><button style="margin-left:60px;" type="button">Cancel</button></a>
            </div>
        </div>
    </form>
</body>

</html>