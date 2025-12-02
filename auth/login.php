<?php
session_start();
require_once "../config/db.php";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // گرفتن کاربر
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        echo "اطلاعات اشتباه است";
        exit;
    }

    $_SESSION['user_id'] = $user['id'];
    header("Location: ../dashboard.php");
    exit;
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="نام کاربری">
    <input type="password" name="password" placeholder="رمز عبور">
    <button>ورود</button>
</form>