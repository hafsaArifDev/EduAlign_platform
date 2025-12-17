<?php
session_start();
require "../backend/db.php";

// Faculty login check
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit;
}

$faculty_id = $_SESSION['faculty_id'];

/* =========================
   FETCH FACULTY PROFILE
   ========================= */
$stmt = $conn->prepare("
    SELECT primary_teaching_subjects, skills, research_interest, preferred_departments 
    FROM faculty_profile 
    WHERE faculty_id = ?
");
$stmt->execute([$faculty_id]);
$faculty = $stmt->fetch(PDO::FETCH_ASSOC);

$faculty_text = "";
if ($faculty) {
    $faculty_text =
        ($faculty['primary_teaching_subjects'] ?? '') . " " .
        ($faculty['skills'] ?? '') . " " .
        ($faculty['research_interest'] ?? '') . " " .
        ($faculty['preferred_departments'] ?? '');
}

/* =========================
   FETCH ALL JOBS
   ========================= */
$jobs = $conn->query("SELECT * FROM jobs ORDER BY id DESC")
             ->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   AI SCORING FUNCTION
   ========================= */
function aiScore($text1, $text2) {

    if (trim($text1) === "" || trim($text2) === "") {
        return 0;
    }

    $payload = json_encode([
        "text1" => $text1,
        "text2" => $text2
    ]);

    $ch = curl_init("http://127.0.0.1:5000/match");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => $payload
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    return $data['score'] ?? 0;
}

/* =========================
   FILTER JOBS USING AI
   ========================= */
$matchedJobs = [];

foreach ($jobs as $job) {

    $job_text =
        ($job['job_title'] ?? '') . " " .
        ($job['required_subject'] ?? '') . " " .
        ($job['skills_required'] ?? '') . " " .
        ($job['department'] ?? '') . " " .
        ($job['description'] ?? '');

    $score = aiScore($faculty_text, $job_text);

    // Threshold (important)
    if ($score >= 0.30) {
        $job['ai_score'] = $score;
        $matchedJobs[] = $job;
    }
}

$jobs = $matchedJobs;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suggested Jobs</title>
    <link rel="stylesheet" href="css/faculty.css">

    <style>
        body {
            background: #f0f6f9;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            max-width: 1100px;
            margin: 40px auto;
        }
        h2 {
            font-size: 30px;
            font-weight: 700;
            background: linear-gradient(135deg,#1abc9c,#3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .job-card {
            background: #fff;
            padding: 22px;
            margin-bottom: 22px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .job-card h3 {
            margin: 0 0 10px;
            color: #1abc9c;
        }
        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit,minmax(200px,1fr));
            gap: 10px;
            font-size: 14px;
            color: #555;
        }
        .badge {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 12px;
            background: #e0f7f4;
            color: #0f766e;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .btn {
            display: inline-block;
            margin-top: 14px;
            padding: 10px 18px;
            background: linear-gradient(135deg,#1abc9c,#3498db);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }
        .empty {
            background: #fff;
            padding: 30px;
            border-radius: 14px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <h2>Suggested Jobs</h2>
    <p>AI-matched job opportunities based on your profile.</p>

    <?php if (count($jobs) === 0): ?>
        <div class="empty">
            No AI-matched jobs found for your profile.
        </div>
    <?php endif; ?>

    <?php foreach ($jobs as $j): ?>
        <div class="job-card">
            <h3><?= htmlspecialchars($j['job_title']) ?> (<?= htmlspecialchars($j['department']) ?>)</h3>

            <div class="meta">
                <div><strong>Institute:</strong> <?= htmlspecialchars($j['institute']) ?></div>
                <div><strong>City:</strong> <?= htmlspecialchars($j['city']) ?></div>
                <div><strong>Salary:</strong> <?= htmlspecialchars($j['salary']) ?></div>
                <div><strong>Deadline:</strong> <?= htmlspecialchars($j['deadline']) ?></div>
            </div>

            <p><?= nl2br(htmlspecialchars($j['description'])) ?></p>

            <span class="badge">
                Match: <?= round($j['ai_score'] * 100) ?>%
            </span><br>

            <a class="btn" href="apply-job.php?jid=<?= $j['id'] ?>">Apply Now</a>
        </div>
    <?php endforeach; ?>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
