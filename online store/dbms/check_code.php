<?php
// Start session
session_start();

// Get the verification code from session
$code = isset($_SESSION['captcha_code']) ? $_SESSION['captcha_code'] : '';

// Get the code submitted by user
$submitted_code = isset($_POST['verify-code']) ? $_POST['verify-code'] : '';

// Check if the submitted code matches the verification code
if ($code === $submitted_code) {
  // Verification code is correct
  echo 'true';
} else {
  // Verification code is incorrect
  echo 'false';
}
?>
