
<?php
session_start();
  
    /** WHERE u_id ='".$_SESSION['id']."'*/
    include_once('DBConnect.php');
    $dbConnect = new DBConnect();
    $conn = $dbConnect->connectdb();

    $num_per_page = 25;
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    ;
    $start_from = ($page - 1) * $num_per_page;

    $count = 1;
    $sql_address = "SELECT u_id, a_id, name, address, phone FROM address WHERE u_id ='".$_SESSION['id']."' LIMIT $start_from, $num_per_page";
    $result = mysqli_query($conn, $sql_address);
    $result_address = mysqli_query($conn,$sql_address);
    $row_address=mysqli_fetch_array($result_address);
    ?>
    <!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Address Book</title>
<link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<header>
<h1>Address Book</h1>
</header>
<nav>
    <a href="myaccount.php">Back to My Account</a>
</nav>
<?php
    if (mysqli_num_rows($result) >= 0) {
        ?>
        <div class="cart-item" style="text-align:center;">
            <table class="list-table">
            <colgroup>
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                </colgroup>
            <thead>
                    <tr>
                        <th>User ID</th>
                       <th>Address ID</th>
                        <th>Name</th>
                        <th>Contact number</th>
                        <th>Address</th>
                        <th>Delete</th>
                    </tr>
                </thead>
       <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                        <td>
                                <?= $row['u_id'] ?>
                            </td>
                        <td>
                                <?= $row['a_id'] ?>
                            </td>
                            <td>
                                <?= $row['name'] ?>
                            </td>
                            <td>
                                <?= $row['phone'] ?>
                            </td>
                            <td>
                                <?= $row['address'] ?>
                            </td>
            
                            <td><a href="deleteaddress.php?a_id=<?= $row['a_id'] ?>"><button type="button">Delete</button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        $sql = "SELECT * FROM address";
        $rs_result = mysqli_query($conn, $sql);
        $total_records = mysqli_num_rows($rs_result);
        $total_pages = ceil($total_records / $num_per_page);

        echo "<a href='address_book.php?page=1'>" . '|<' . "</a> &nbsp;  &nbsp;";

        $i = $page;
        if ($i != 1) {
            echo "<a href='address_book.php?page=" . ($i - 1) . "'>Last Page</a> ";
        }
        if ($i != $total_pages) {
            echo "<a href='address_book.php?page=" . ($i + 1) . "'>Next Page</a> ";
        }
        echo "<a href='address_book.php?page=$total_pages'>" . '>|' . "</a> ";
        ?>
        <?php
    }
    ?>
    <a href="ADD_Address.php" class="checkout-button">Add Address</a>
    <footer>
        <p>&copy; Group2 Online Store</p>
    </footer>
</body>

</html>
