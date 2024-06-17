<?php
// Start session
session_start();

// Generate random verification code
$code = substr(md5(mt_rand()), 0, 6);

// Store the code in session
$_SESSION['captcha_code'] = $code;

// Create image
$image = imagecreatetruecolor(100, 30);

// Set background color
$bg_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bg_color);

// Set text color
$text_color = imagecolorallocate($image, 0, 0, 0);

// Add code to image
imagestring($image, 5, 20, 8, $code, $text_color);

// Output image
header('Content-Type: image/png');
imagepng($image);

// Clean up
imagedestroy($image);
?>
