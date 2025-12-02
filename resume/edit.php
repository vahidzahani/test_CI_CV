<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// گرفتن رزومه کاربر
$stmt = $pdo->prepare("SELECT * FROM resumes WHERE user_id = ?");
$stmt->execute([$user_id]);
$resume = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resume) {
    echo "شما هنوز رزومه‌ای ایجاد نکرده‌اید. <a href='create.php'>ایجاد رزومه</a>";
    exit;
}

// اگر فرم ارسال شد
if ($_POST) {

    $full_name = $_POST['full_name'];
    $job_title = $_POST['job_title'];
    $about = $_POST['about'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience'];

    $stmt = $pdo->prepare("
        UPDATE resumes SET 
            full_name = ?, 
            job_title = ?, 
            about = ?, 
            skills = ?, 
            experience = ?
        WHERE user_id = ?
    ");

    $stmt->execute([
        $full_name,
        $job_title,
        $about,
        $skills,
        $experience,
        $user_id
    ]);

    echo "رزومه با موفقیت بروزرسانی شد. <a href='view.php'>مشاهده</a>";
    exit;
}
?>

<h2>ویرایش رزومه</h2>

<form method="POST">
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($resume['full_name']); ?>"
        placeholder="نام کامل"><br><br>

    <input type="text" name="job_title" value="<?php echo htmlspecialchars($resume['job_title']); ?>"
        placeholder="عنوان شغلی"><br><br>

    <textarea name="about" placeholder="درباره من"><?php echo htmlspecialchars($resume['about']); ?></textarea><br><br>

    <textarea name="skills" placeholder="مهارت‌ها"><?php echo htmlspecialchars($resume['skills']); ?></textarea><br><br>

    <textarea name="experience"
        placeholder="سوابق کاری"><?php echo htmlspecialchars($resume['experience']); ?></textarea><br><br>

    <button>ذخیره تغییرات</button>
</form>

<br>
<a href="view.php">بازگشت به مشاهده رزومه</a>