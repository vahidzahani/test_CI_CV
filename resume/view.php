<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM resumes WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$resume = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resume) {
    echo "هنوز رزومه‌ای ایجاد نکرده‌اید";
    exit;
}
?>

<h2><?php echo $resume['full_name']; ?></h2>
<h4><?php echo $resume['job_title']; ?></h4>

<p><strong>درباره من:</strong><br><?php echo nl2br($resume['about']); ?></p>
<p><strong>مهارت‌ها:</strong><br><?php echo nl2br($resume['skills']); ?></p>
<p><strong>سوابق کاری:</strong><br><?php echo nl2br($resume['experience']); ?></p>