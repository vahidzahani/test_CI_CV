<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<h2>سامانه رزومه‌ساز</h2>

<a href="auth/login.php">ورود</a> |
<a href="auth/register.php">ثبت‌نام</a>