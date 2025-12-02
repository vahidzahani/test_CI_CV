<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_POST) {

    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $new_pass2 = $_POST['new_password2'];

    // چک خالی نبودن فیلدها
    if (empty($old_pass) || empty($new_pass) || empty($new_pass2)) {
        echo "تمام فیلدها لازم است.";
        exit;
    }

    // چک برابر بودن رمز جدید
    if ($new_pass !== $new_pass2) {
        echo "رمز جدید و تکرار آن یکسان نیست.";
        exit;
    }

    // گرفتن رمز فعلی از DB
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "کاربر یافت نشد.";
        exit;
    }

    // چک رمز قبلی
    if (!password_verify($old_pass, $user['password'])) {
        echo "رمز قبلی اشتباه است.";
        exit;
    }

    // هش رمز جدید
    $hashed = password_hash($new_pass, PASSWORD_BCRYPT);

    // آپدیت رمز جدید
    $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->execute([$hashed, $user_id]);

    echo "رمز عبور با موفقیت تغییر کرد. <a href='../dashboard.php'>بازگشت</a>";
    exit;
}
?>

<h2>تغییر رمز عبور</h2>

<form method="POST">

    <input type="password" name="old_password" placeholder="رمز قبلی"><br><br>

    <input type="password" name="new_password" placeholder="رمز جدید"><br><br>

    <input type="password" name="new_password2" placeholder="تکرار رمز جدید"><br><br>

    <button>تغییر رمز</button>
</form>

<br>
<a href="../dashboard.php">بازگشت</a>