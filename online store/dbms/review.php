<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="./css/styles.css"> 
</head>
<body>
    <header>
        <h1>Reviews</h1>
    </header>

    <footer>
        <p>&copy; Group2 Online Store</p>
    </footer>
</body>
</html>
<section id="reviews">
        <?php
        session_start(); 
        include_once('DBConnect.php'); 
        $dbConnect = new DBConnect();
        $conn = $dbConnect->connectdb();

        
        $sql = "SELECT r_id, content FROM review";
        $result = mysqli_query($conn, $sql);

        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="review-item">';
                echo '<h3>Review ID: ' . $row['r_id'] . '</h3>';
                echo '<h3>Order ID: ' . $row['o_id'] . '</h3>';
                echo '<p>' . htmlspecialchars($row['content']) . '</p>'; 
                echo '</div>';
            }
        } else {
        echo '<p>No reviews yet.</p>'; 
    }

mysqli_close($conn);
?>
    </section>