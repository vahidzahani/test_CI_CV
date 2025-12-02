<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_POST) {
    $full_name = $_POST['full_name'];
    $job_title = $_POST['job_title'];
    $about = $_POST['about'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience'];

    // حذف رزومه قبلی (اگر خواستی فقط یک رزومه داشته باشند)
    $pdo->prepare("DELETE FROM resumes WHERE user_id = ?")->execute([$_SESSION['user_id']]);

    $stmt = $pdo->prepare("
        INSERT INTO resumes (user_id, full_name, job_title, about, skills, experience)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $full_name,
        $job_title,
        $about,
        $skills,
        $experience
    ]);

    echo "رزومه ذخیره شد <a href='view.php'>مشاهده</a>";
}
?>

<form method="POST">
    <input type="text" name="full_name" placeholder="نام کامل">
    <input type="text" name="job_title" placeholder="عنوان شغلی">
    <textarea name="about" placeholder="درباره من"></textarea>
    <textarea name="skills" placeholder="مهارت‌ها"></textarea>
    <textarea name="experience" placeholder="سوابق کاری"></textarea>
    <button>ذخیره</button>
</form>