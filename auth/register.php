<?php
session_start();
require_once "../config/db.php";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "پر کردن همه فیلدها لازم است";
        exit;
    }

    // هش رمز
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    // ذخیره
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

    try {
        $stmt->execute([$username, $hashed]);
        echo "ثبت‌نام انجام شد <a href='login.php'>ورود</a>";
    } catch (PDOException $e) {
        echo "خطا در ثبت‌نام: " . $e->getMessage();
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="نام کاربری">
    <input type="password" name="password" placeholder="رمز عبور">
    <button>ثبت‌نام</button>
</form>