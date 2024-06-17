<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    $sql = "SELECT * FROM product WHERE p_id = '$p_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p_id = $_POST["p_id"];
    $name1 = $_POST["name1"];
    $inventory1 = $_POST["inventory1"];
    $price1 = $_POST["price1"];
    $img_path1 = $_POST["img_path1"];
    $s_id1 = $_POST["s_id1"];
    $pm_id1 = $_POST["pm_id1"];

    // 构建更新语句，只更新用户填写的字段
    $sql = "UPDATE product SET ";

    $updateFields = array();
    if (!empty($name1)) {
        $updateFields[] = "name='$name1'";
    }
    if (!empty($inventory1)) {
        $updateFields[] = "inventory='$inventory1'";
    }
    if (!empty($price1)) {
        $updateFields[] = "price='$price1'";
    }
    if (!empty($img_path1)) {
        $updateFields[] = "img_path='$img_path1'";
    }
    if (!empty($s_id1)) {
        $updateFields[] = "s_id='$s_id1'";
    }
    if (!empty($pm_id1)) {
        $updateFields[] = "pm_id='$pm_id1'";
    }

    $sql .= implode(", ", $updateFields); // 将需要更新的字段组合到 SQL 查询中
    $sql .= " WHERE p_id='$p_id'";
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: seller_product.php"); // 重定向回产品页面
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit Product</title>
    <link rel="stylesheet" href="./css/book.css">
    <link rel="stylesheet" href="./css/styles0.css">
</head>

<body>
    <form class="book-form" action="editproduct.php" method="post">
        <div class="book-form-item">
            <label class="book-form-label">Product Name</label>
            <div class="book-input-block">
                <div>Old Name:
                    <?= $row['name'] ?>
                </div>
                <input type="text" name="name1" placeholder="Please enter the product name" class="book-input">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Price</label>
            <div class="book-input-block">
                <div>Old Price:
                    <?= $row['price'] ?>
                </div>
                <input type="number" name="price1" placeholder="Please enter price" class="book-input" step="0.01">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Inventory</label>
            <div class="book-input-block">
                <div>Old Inventoty:
                    <?= $row['inventory'] ?>
                </div>
                <input type="number" name="inventory1" placeholder="Please enter inventory" class="book-input">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Seller ID</label>
            <div class="book-input-block">
                <div>Old Seller ID:
                    <?= $row['s_id'] ?>
                </div>
                <input type="number" name="s_id1" placeholder="Please enter the Seller ID" class="book-input">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Promotion ID</label>
            <div class="book-input-block">
                <div>Old Promotion ID:
                    <?= $row['pm_id'] ?>
                </div>
                <input type="number" name="pm_id1" placeholder="Please enter the Promotion ID" class="book-input">
            </div>
        </div>
        <div class="book-form-item">
            <label class="book-form-label">Image_path</label>
            <div class="book-input-block">
                <div>Old image_path:
                    <?= $row['img_path'] ?>
                </div>
                <input type="number" name="img_path1" placeholder="Please enter inventory" class="book-input">
            </div>
        </div>
        <input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
        <table width="100%" border="0">
            <tbody>
                <tr>
                    <td><button type="submit" class="book-btn" lay-submit="" lay-filter="demo1">Modification</button>
                    </td>
                    <td><a href="seller_product.php"><button type="button">Cancel</button></a></td>
                    <td><a href="deleteproduct.php?p_id=<?= $row['p_id'] ?>"><button type="button">Delete</button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</body>

</html>