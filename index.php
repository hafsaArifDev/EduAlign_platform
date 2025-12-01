<?php
// index.php — Option A: Dark Neon Landing Dashboard (EduAlign theme)
// Single-file. Edit $main_admin_email to allow one admin.
// Place in project root (where admin/, faculty/, students/ folders live).

session_start();

// CHANGE this to the real admin email
$main_admin_email = "admin@example.com";

// For quick local testing you can uncomment to simulate logged-in admin user:
// $_SESSION['email'] = 'admin@example.com';

if (isset($_GET['portal'])) {
    $p = $_GET['portal'];
    if ($p === 'admin') {
        if (isset($_SESSION['email']) && $_SESSION['email'] === $main_admin_email) {
            header("Location: admin/");
            exit;
        } else {
            $error = "⚠️ Admin access restricted. Only the main admin can enter.";
        }
    } elseif ($p === 'faculty') {
        header("Location: faculty/");
        exit;
    } elseif ($p === 'student') {
        header("Location: students/");
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>EduAlign — Neon Dashboard</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  /* ---------- Base ---------- */
  :root{
    --teal: #1abc9c;
    --blue: #3498db;
    --bg:#05060a;         /* deep dark */
    --card:#0b0d12;       /* card dark */
    --muted:#aeb6c2;
    --glass: rgba(255,255,255,0.03);
  }
  *{box-sizing:border-box}
  html,body{height:100%;margin:0;font-family:Inter, "Arial", sans-serif;background:var(--bg);color:#eaf2f7;-webkit-font-smoothing:antialiased}
  a{color:inherit;}

  /* ---------- Header (top strip) ---------- */
  .topbar{
    display:flex;align-items:center;justify-content:space-between;
    padding:18px 36px;background:linear-gradient(90deg,var(--teal),var(--blue));
    box-shadow:0 6px 28px rgba(18,35,47,0.35);
  }
  .brand{font-weight:800;font-size:20px;letter-spacing:0.4px;color:#fff}
  .top-actions{display:flex;gap:10px;align-items:center}
  .btn-outline{
    background:transparent;border:2px solid rgba(255,255,255,0.12);color:#fff;padding:8px 14px;border-radius:10px;font-weight:600;cursor:pointer;
    transition:all .25s ease;
  }
  .btn-outline:hover{transform:translateY(-2px);box-shadow:0 6px 20px rgba(52,152,219,0.12)}

  /* ---------- Hero ---------- */
  .hero{
    position:relative;
    min-height:420px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    padding:60px 22px;
  }
  .hero-inner{width:100%;max-width:1180px;display:grid;grid-template-columns:1fr 460px;gap:36px;align-items:center}
  @media (max-width:980px){ .hero-inner{grid-template-columns:1fr; text-align:center} .hero-cards{justify-items:center} }

  /* left column text */
  .hero-left{padding:12px}
  .hero-title{
    font-size:64px;line-height:1;
    font-weight:900;margin:0 0 14px;
    color: #ffffff;
    text-shadow:0 6px 30px rgba(26,188,156,0.08);
  }
  .hero-sub{
    font-size:16px;color:var(--muted);margin-bottom:22px;max-width:640px;
  }

  /* search-like control (decorative) */
  .search-mock{
    display:flex;align-items:center;gap:14px;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
    padding:12px 16px;border-radius:999px;border:1px solid rgba(255,255,255,0.04);
    width:100%;max-width:640px;backdrop-filter: blur(4px);
  }
  .search-icon{width:38px;height:38px;border-radius:50%;display:inline-grid;place-items:center;background:linear-gradient(135deg,var(--teal),var(--blue));box-shadow:0 8px 30px rgba(52,152,219,0.14);font-weight:700;}
  .search-text{color:var(--muted);font-size:15px}

  /* CTA group */
  .cta-row{display:flex;gap:12px;margin-top:20px}
  .btn-cta{
    background:linear-gradient(90deg,var(--teal),var(--blue));
    color:#031017;padding:12px 18px;border-radius:12px;font-weight:800;border:none;cursor:pointer;box-shadow:0 12px 40px rgba(26,188,156,0.12);transition:transform .22s;
  }
  .btn-cta:hover{transform:translateY(-4px)}

  /* ---------- Right side — neon wave art ---------- */
  .hero-art{
    position:relative;height:360px;border-radius:18px;overflow:visible;
    display:flex;align-items:center;justify-content:center;
  }
  /* floating neon container to hold SVG waves */
  .neon-frame{
    width:100%;height:100%;border-radius:16px;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.02), 0 18px 60px rgba(2,6,23,0.6);
    position:relative;
  }
  /* the neon blobs/waves are SVG and animated via CSS transforms */
  .wave-svg{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;opacity:0.96;filter:drop-shadow(0 12px 28px rgba(52,152,219,0.12))}

  /* ---------- Cards area (below hero) ---------- */
  .cards-wrap{width:100%;max-width:1180px;margin:-50px auto 60px;display:flex;justify-content:center;gap:28px;padding:0 22px;flex-wrap:wrap}
  .card{
    width:320px;padding:26px;border-radius:14px;background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
    border:1px solid rgba(255,255,255,0.04);
    backdrop-filter: blur(8px);box-shadow:0 18px 40px rgba(2,6,23,0.6);transition:transform .28s, box-shadow .28s;
    text-decoration:none;color:#eaf2f7;display:block;position:relative;overflow:hidden;
  }
  .card:hover{transform:translateY(-12px);box-shadow:0 30px 70px rgba(2,6,23,0.75)}
  .card .icon{font-size:30px;padding:8px;border-radius:10px;background:linear-gradient(90deg,var(--teal),var(--blue));display:inline-block;margin-bottom:10px;box-shadow:0 10px 30px rgba(52,152,219,0.12)}
  .card h4{margin:6px 0 8px;font-size:20px}
  .card p{color:var(--muted);font-size:14px;margin:0}

  /* neon glow pulse on CTA inside card */
  .card .enter-btn{display:inline-block;margin-top:14px;padding:10px 14px;border-radius:10px;background:transparent;color:var(--teal);border:1px solid rgba(26,188,156,0.28);font-weight:700;text-decoration:none;transition:all .2s}
  .card:hover .enter-btn{background:linear-gradient(90deg,var(--teal),var(--blue));color:#021115;box-shadow:0 12px 40px rgba(26,188,156,0.12)}

  /* small badge for restricted */
  .badge-restrict{position:absolute;right:14px;top:14px;padding:8px 10px;border-radius:999px;background:rgba(255,255,255,0.03);font-size:12px;color:var(--muted);border:1px solid rgba(255,255,255,0.02)}

  /* ---------- Footer ---------- */
  .footer{padding:18px;text-align:center;color:rgba(255,255,255,0.72);background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00))}

  /* ---------- Animations (subtle) ---------- */
  .wave-a{animation: floatA 6s ease-in-out infinite}
  .wave-b{animation: floatB 8s ease-in-out infinite}
  @keyframes floatA{0%{transform:translateY(0) rotate(0)}50%{transform:translateY(-12px) rotate(2deg)}100%{transform:translateY(0) rotate(0)}}
  @keyframes floatB{0%{transform:translateY(0) rotate(0)}50%{transform:translateY(16px) rotate(-2deg)}100%{transform:translateY(0) rotate(0)}}

  /* subtle entrance */
  .fade-in{animation:fadeIn .8s ease both}
  @keyframes fadeIn{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}

  /* responsive tweaks */
  @media (max-width:760px){
    .hero-title{font-size:42px}
    .hero-inner{grid-template-columns:1fr}
    .cards-wrap{gap:18px;margin-top:18px}
  }
  
        /* FOOTER DESIGN */
        .main-footer {
            background: linear-gradient(135deg, #1abc9c, #3498db);
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 15px;
            font-weight: 600;
            margin-top: 40px;
            box-shadow: 0 -3px 12px rgba(0,0,0,0.15);
            height: 10px;
            align-content: center;
            margin-top: -20px;
        }

        p {
            margin-top: -4px;
        }
        /* Footer always stays at bottom */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Push footer to bottom when content is short */
        .content-wrapper {
            flex: 1;
        }

</style>
</head>
<body>

<!-- Topbar -->
<div class="topbar">
  <div class="brand">EduAlign — Student Portal</div>
  <div class="top-actions">
    <a class="btn-outline" href="?portal=student">Student</a>
    <a class="btn-outline" href="?portal=faculty">Faculty</a>
    <a class="btn-outline" href="?portal=admin">Admin</a>
  </div>
</div>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <!-- LEFT TEXT -->
    <div class="hero-left fade-in">
      <h1 class="hero-title">Welcome.</h1>
      <p class="hero-sub">
        EduAlign connects students, faculty and administrators — aligning academic goals with programs, profiles and intelligent suggestions. Explore your portal below.
      </p>

      <div class="search-mock" role="presentation">
        <div class="search-icon">🔍</div>
        <div class="search-text">Search programs, courses or profiles…</div>
      </div>

      <div class="cta-row" style="margin-top:18px">
        <button class="btn-cta">Get Started</button>
        <button class="btn-cta" style="background:transparent;border:1px solid rgba(255,255,255,0.06);color:#fff">Learn More</button>
      </div>
    </div>

    <!-- RIGHT ART -->
    <div class="hero-art fade-in">
      <div class="neon-frame">
        <!-- SVG Waves: two layered path groups animated by CSS -->
        <svg class="wave-svg" viewBox="0 0 800 380" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="g1" x1="0" x2="1">
              <stop offset="0%" stop-color="#1abc9c"/>
              <stop offset="100%" stop-color="#3498db"/>
            </linearGradient>
            <filter id="glow" x="-50%" y="-50%" width="200%" height="200%">
              <feGaussianBlur stdDeviation="8" result="coloredBlur"/>
              <feMerge>
                <feMergeNode in="coloredBlur"/>
                <feMergeNode in="SourceGraphic"/>
              </feMerge>
            </filter>
          </defs>

          <!-- big neon contour -->
          <g transform="translate(40,20)" fill="none" stroke="url(#g1)" stroke-width="2.4" filter="url(#glow)" class="wave-a">
            <path d="M20,180 C80,50 240,40 360,120 C460,185 620,120 760,150" stroke-opacity="0.95"/>
            <path d="M10,210 C90,90 230,80 360,150 C470,220 610,160 760,210" stroke-opacity="0.65"/>
          </g>

          <!-- inner purple-blue ripple -->
          <g transform="translate(30,40)" fill="none" stroke="rgba(120,80,200,0.95)" stroke-width="1.6" filter="url(#glow)" class="wave-b">
            <path d="M40,200 C120,90 260,110 360,140 C460,170 600,160 760,190" stroke-opacity="0.9"/>
            <path d="M60,220 C140,110 280,120 360,170 C460,220 620,190 760,220" stroke-opacity="0.55"/>
          </g>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- Portal Cards (floating) -->
<section class="cards-wrap fade-in">

  <a class="card" href="?portal=student" title="Student Portal">
    <div class="badge-restrict">Open</div>
    <div class="icon">🎓</div>
    <h4>Student Portal</h4>
    <p>Complete profile, view AI-suggested programs and manage your academic journey.</p>
    <span class="enter-btn">Enter Student</span>
  </a>

  <a class="card" href="?portal=faculty" title="Faculty Portal">
    <div class="badge-restrict">Open</div>
    <div class="icon">🧑‍🏫</div>
    <h4>Faculty Portal</h4>
    <p>Manage classes, upload materials and monitor student progress with ease.</p>
    <span class="enter-btn">Enter Faculty</span>
  </a>

  <a class="card" href="?portal=admin" title="Admin Portal">
    <div class="badge-restrict">Restricted</div>
    <div class="icon">🔐</div>
    <h4>Admin Portal</h4>
    <p>Visible to everyone; only the main administrator may access the admin area.</p>
    <span class="enter-btn">Admin Access</span>
  </a>

</section>

<!-- Optional error box -->
<?php if (!empty($error)): ?>
  <div style="max-width:1100px;margin:0 auto 18px;padding:0 22px">
    <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
  </div>
<?php endif; ?>

<footer class="main-footer">
    <p>© <?= date("Y") ?> EduAlign Platform</p>
</footer>

</body>
</html>