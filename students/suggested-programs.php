<?php
session_start();
require "../backend/db.php";

/* =========================
   AUTH CHECK
   ========================= */
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

/* =========================
   STUDENT PROFILE (AI TEXT)
   ========================= */
$profile = $conn->prepare("
    SELECT preferences 
    FROM students_profiles 
    WHERE student_id = ?
");
$profile->execute([$student_id]);
$student_pref = $profile->fetch(PDO::FETCH_ASSOC);

$studentText = $student_pref
    ? $student_pref['preferences']
    : "";

/* =========================
   FETCH PROGRAMS
   ========================= */
$query = $conn->query("SELECT * FROM programs ORDER BY id DESC");
$programs = $query->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   AI FUNCTION (PHP → PYTHON)
   ========================= */
function ai_match_score($text1, $text2) {

    $payload = json_encode([
        "text1" => $text1,
        "text2" => $text2
    ]);

    $ch = curl_init("http://127.0.0.1:5000/match");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);
    curl_close($ch);

    if (!$response) return 0;

    $data = json_decode($response, true);
    return $data["score"] ?? 0;
}

/* =========================
   CALCULATE AI SCORE
   ========================= */
foreach ($programs as &$p) {

    $programText =
        $p['program_name'] . " " .
        $p['degree_level'] . " " .
        $p['city'] . " " .
        $p['description'];

    $p['ai_score'] = ai_match_score($studentText, $programText);
}
unset($p);

/* =========================
   SORT BY AI SCORE (DESC)
   ========================= */
usort($programs, function ($a, $b) {
    return $b['ai_score'] <=> $a['ai_score'];
});

/* =========================
   SPLIT: SUGGESTED vs ALL
   ========================= */
$suggested = array_filter($programs, fn($p) => $p['ai_score'] >= 0.15);
$all_programs = $programs;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suggested Programs</title>
    <link rel="stylesheet" href="css/student.css">
</head>
<body>

<?php include "includes/header.php"; ?>

<div class="container">

    <!-- SUGGESTED PROGRAMS -->
    <h2 class="section-title">Suggested Programs</h2>
    <p class="section-desc">
        AI-matched degree programs based on your preferences.
    </p>

    <?php if (count($suggested) === 0): ?>
        <div class="empty">No programs match your interests.</div>
    <?php else: ?>
        <div class="program-grid">
            <?php foreach ($suggested as $p): ?>
                <div class="program-box">
                    <h3>
                        <?= htmlspecialchars($p['program_name']) ?>
                        (<?= htmlspecialchars($p['degree_level']) ?>)
                    </h3>

                    <p><strong>University:</strong> <?= htmlspecialchars($p['university_name']) ?></p>
                    <p><strong>City:</strong> <?= htmlspecialchars($p['city']) ?></p>
                    <p><strong>Fee:</strong> <?= htmlspecialchars($p['fee']) ?></p>
                    <p><strong>Deadline:</strong> <?= htmlspecialchars($p['deadline']) ?></p>

                    <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>

                    <a class="btn" href="apply-program.php?pid=<?= $p['id'] ?>">
                        Apply Now
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <hr>

    <!-- ALL PROGRAMS -->
    <h2 class="section-title">All Available Programs</h2>
    <p class="section-desc">
        These are all programs added by Admin.
    </p>

    <div class="program-grid">
        <?php foreach ($all_programs as $p): ?>
            <div class="program-box">
                <h3>
                    <?= htmlspecialchars($p['program_name']) ?>
                    (<?= htmlspecialchars($p['degree_level']) ?>)
                </h3>

                <p><strong>University:</strong> <?= htmlspecialchars($p['university_name']) ?></p>
                <p><strong>City:</strong> <?= htmlspecialchars($p['city']) ?></p>
                <p><strong>Fee:</strong> <?= htmlspecialchars($p['fee']) ?></p>
                <p><strong>Deadline:</strong> <?= htmlspecialchars($p['deadline']) ?></p>

                <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>

                <a class="btn" href="apply-program.php?pid=<?= $p['id'] ?>">
                    Apply Now
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include "includes/footer.php"; ?>

</body>
</html>
