<?php
session_start();
include_once('DBConnect.php');
$dbConnect = new DBConnect();
$conn = $dbConnect->connectdb();

if (isset($_GET['o_id']) && isset($_SESSION['id'])) {
    $o_id = $_GET['o_id'];
    $u_id = $_SESSION['id']; // Use the session ID instead of getting it from the URL
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["content"]) && !empty($_POST["content"])) {
            $content = $_POST["content"];

            $sql_review = "INSERT INTO review (content, u_id, o_id) VALUES ('$content', '$u_id', '$o_id')";

            if (mysqli_query($conn, $sql_review)) {
                echo '<script>alert("Review added successfully. Redirecting..."); window.location.href = "my_review.php";</script>';
            } else {
                echo "Error adding review: " . mysqli_error($conn);
            }
        } else {
            echo "Content is required to add a review.";
        }
    }
} else {
    echo "Missing Order ID or user ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
    <link rel="stylesheet" href="./css/styles0.css">
</head>
<body>
    <form action="ADD_Review.php?o_id=<?php echo $o_id; ?>" method="POST">
        <h2 style="color: #d89152;">Add Review</h2>
        <input type="text" name="content" placeholder="Content">
        <button type="submit" name="submit" value="confirm" class="buttonstyle">Confirm</button>
    </form>
</body>
</html>
