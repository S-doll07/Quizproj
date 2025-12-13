<?php
// FILE: index.php
session_start();

// If user is not logged in → send to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>CyberTech Quiz Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
<style>
  :root{ --bg:#02021a; --accent:#00f5a0; --accent2:#7c3aed; --muted:rgba(255,255,255,0.6); }
  *{box-sizing:border-box}
  body{
    margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center;
    background: radial-gradient(800px 300px at 10% 20%, rgba(124,58,237,0.06), transparent 10%),
                radial-gradient(800px 300px at 90% 80%, rgba(0,245,160,0.04), transparent 10%),
                linear-gradient(180deg,#02020a 0%, #061028 100%);
    font-family: Inter, system-ui, Arial, sans-serif; color:#e6f7ff; padding:24px;
  }
  .panel{ width:100%; max-width:980px; padding:36px; border-radius:14px; background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border:1px solid rgba(255,255,255,0.03); box-shadow: 0 18px 50px rgba(0,0,0,0.7); display:grid; grid-template-columns: 1fr 380px; gap:24px; align-items:center; position:relative;  }

  /* Logout Button */
  .logout-btn{
      position:absolute;
      top:18px;
      right:18px;
      background: #ff2965;
      padding:8px 14px;
      border-radius:6px;
      color:white;
      text-decoration:none;
      font-size:14px;
      font-weight:bold;
      box-shadow:0 0 12px rgba(255,0,80,0.4);
  }
  .logout-btn:hover{
      background:#ff0037;
  }

  /* Username Display */
  .user-tag{
      position:absolute;
      top:60px;
      right:18px;
      font-size:14px;
      color:var(--muted);
  }

  .glitch { font-family: 'Orbitron', sans-serif; font-size:42px; margin:0; color:transparent; -webkit-text-stroke: 1px rgba(124,58,237,0.9); position:relative; }
  .glitch::before,.glitch::after{ content:"CyberTech Quiz Portal"; position:absolute; left:0; top:0; width:100%; }
  .glitch::before{ color: rgba(124,58,237,0.9); transform:translate(2px,-2px); mix-blend-mode:screen; opacity:0.9; animation: g1 2.7s infinite; }
  .glitch::after{ color: rgba(0,245,160,0.9); transform:translate(-2px,2px); mix-blend-mode:screen; opacity:0.9; animation: g2 2.7s infinite; }

  @keyframes g1 { 0%{transform:translate(0)}10%{transform:translate(-2px,-2px)}20%{transform:translate(2px,2px)}30%{transform:translate(0)} }
  @keyframes g2 { 0%{transform:translate(0)}15%{transform:translate(2px,2px)}30%{transform:translate(-2px,-2px)}50%{transform:translate(0)} }

  .start-box{ display:flex; flex-direction:column; gap:12px; align-items:center; justify-content:center; background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00)); border-radius:12px; padding:18px; border:1px solid rgba(255,255,255,0.03); }
  .start-btn{ background: linear-gradient(90deg,var(--accent2), var(--accent)); color:#061026; font-weight:800; padding:12px 18px; border-radius:10px; text-decoration:none; font-size:16px; box-shadow: 0 12px 30px rgba(124,58,237,0.12); }
  .meta{ font-size:13px; color:var(--muted) }
  @media (max-width:900px){ .panel{grid-template-columns:1fr;padding:20px} .glitch{font-size:34px} }
</style>
</head>
<body>

  <div class="panel">

    <!-- Logout -->
    <a href="logout.php" class="logout-btn">Logout</a>

    <!-- Username Display -->
    <div class="user-tag">Logged in as: <b><?php echo $_SESSION['username']; ?></b></div>

    <div>
      <h1 class="glitch">CyberTech Quiz Portal</h1>
      <p style="color:var(--muted);margin-top:8px">Futuristic quiz interface • 10 questions • 10 minutes</p>
      <p style="color:var(--muted);margin-top:18px">Rules: Timer begins when you click Start. You cannot preview answers before submission. Submit asks for confirmation. A 1-minute HURRY warning appears near the end.</p>
    </div>

    <div class="start-box">
      <a class="start-btn" href="quiz.php?start=1">Start Quiz</a>
      <div class="meta">Questions: <strong>10</strong> • Time: <strong>10 minutes</strong></div>
      <div style="font-size:12px;color:var(--muted)">Preview available only after submission.</div>
    </div>

  </div>
</body>
</html>
