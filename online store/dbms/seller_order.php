<?php
session_start();
/**
 * receipt table
 */
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn= $dbConnect->connectdb();

$num_per_page=25;
if(isset($_GET["page"])){$page=$_GET["page"];}else{$page=1;};
$start_from = ($page-1) * $num_per_page;

$count  = 1;


$sql_order = "SELECT o.*, ho.s_id, hp.p_id
              FROM orders o
              JOIN have_os ho ON o.o_id = ho.o_id
              JOIN have_op hp ON o.o_id = hp.o_id
              WHERE ho.s_id = '".$_SESSION['id']."'
              LIMIT $start_from, $num_per_page";
$result = mysqli_query($conn,$sql_order);
$row_order = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header>
        <h1>My Online Store</h1>
    </header>
    <nav>
        <a href="seller_product.php">Products</a>
        <a href="seller_order.php">Order</a>
        <a href="logout.php">Log Out</a>
    </nav>


<?php 
if (mysqli_num_rows($result) >= 0){
    ?>
    <link rel="stylesheet" href="./css/table.css">
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px; background-color:#f5ae6f; border-color: #efa565">
            <div style="text-align: center;color: #ffffff;">Orders</a></div>
        </fieldset>
    <table class="list-table">
    <colgroup>
      <col width="150">
      <col width="150">
      <col width="150">
      <col width="150">
      <col width="150">
      <col width="150">
      <col width="150">
    </colgroup>
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Total price</th>
        <th>Payment method</th>
        <th>User ID</th>
        <th>Product ID</th>
        <th>Seller ID</th>
      </tr> 
    </thead>

<tbody>
    <?php
    while ($row=mysqli_fetch_array($result)){
        ?>
        <tr>
            <td><?=$row['o_id']?></td>
            <td><?=$row['total_price']?></td>
            <td><?=$row['payment_method']?></td>
            <td><?=$row['u_id']?></td>
            <td><?=$row['p_id']?></td>
            <td><?=$row['s_id']?></td>
    </tr>
		
    <?php
    }
    ?>
    </tbody>    
</table>  
<?php
	$sql = "SELECT * FROM orders"; 
	$rs_result = mysqli_query($conn,$sql);
	$total_records =mysqli_num_rows($rs_result); 
	$total_pages = ceil($total_records / $num_per_page);
	echo "<a href='seller_order.php?page=1'>".'|<'."</a> ";
	
	$i=$page; 
	if($i!=1){
	echo "<a href='seller_order.php?page=".($i-1)."'>Last Page</a> ";}
	if($i!=$total_pages){
	echo "<a href='seller_order.php?page=".($i+1)."'>Next Page</a> ";
	}
echo "<a href='seller_order.php?page=$total_pages'>".'>|'."</a> ";
	?>
<?php
}
?>
<footer>
        <p>&copy; Group2 Online Store</p>
    </footer>
</body>

</html>