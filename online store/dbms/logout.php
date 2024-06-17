<?php
/**
 * Logout Operation
 */
session_start();

if(isset($_SESSION['s_id']))
{
    unset($_SESSION['s_id']);
}
session_destroy();
echo "<script>alert('Logout successfully, it is jumping....');</script>";
header("refresh:1;url=login.php");
exit;
?>