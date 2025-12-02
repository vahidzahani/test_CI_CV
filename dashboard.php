<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

echo "<h2>داشبورد</h2>";
echo "<a href='resume/create.php'>ساخت رزومه</a><br>";
echo "<a href='resume/view.php'>مشاهده رزومه</a><br>";
echo "<a href='resume/edit.php'>ویرایش رزومه</a><br>";
echo "<a href='auth/change_password.php'>تغییر رمز عبور</a><br>";
echo "<a href='auth/logout.php'>خروج</a>";
