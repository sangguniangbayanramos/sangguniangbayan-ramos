<?php
// ======== DATABASE CONNECTION ========
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// ======== FETCH EVENTS ========
$query = "SELECT * FROM events ORDER BY event_date ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upcoming Events — Municipality of Ramos</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    /* ===== BACKGROUND FLAG ===== */
    body {
      position: relative;
      min-height: 100vh;
      background-color: #f5f7fb;
      overflow-x: hidden;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('image/flag.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.15;
      z-index: -1;
      animation: wave 10s ease-in-out infinite alternate;
    }
    @keyframes wave {
      0% { background-position: center top; }
      100% { background-position: center bottom; }
    }

    /* ===== HEADER ===== */
    header {
      background-color: #1a4ed8;
      color: white;
      padding: 15px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    header .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 600;
      font-size: 18px;
    }
    header img {
      width: 45px;
      height: 45px;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
      transition: 0.2s;
    }
    nav a:hover {
      text-decoration: underline;
    }

    /* ===== MAIN ===== */
    main {
      max-width: 1000px;
      margin: 40px auto;
      padding: 20px;
      position: relative;
      z-index: 2;
    }
    h1 {
      text-align: center;
      color: #1a4ed8;
      margin-bottom: 30px;
    }

    /* ===== CARD GRID ===== */
    .grid {
      display: center;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
    }
    .card {
      background: rgba(255,255,255,0.95);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      position: center;
      backdrop-filter: blur(5px);
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    .date-tag {
      background-color: #ffcc00;
      color: #000;
      font-weight: 600;
      font-size: 20px;
      padding: 5px 10px;
      border-radius: 15px;
      position: absolute;
      top: 15px;
      right: 15px;
    }
    .card h3 {
      color: #1a4ed8;
      font-size: 50px;
      text-align: center;
      margin-bottom: 8px;
      margin-top: 20px;
    }
    .card p {
      font-size: 30px;
      color: #333;
      margin-top: 5px;
    }
    .desc {
      font-size: 15px;
      color: #555;
      margin-top: 10px;
      font-style: italic;
      text-align: center;
    }

    footer {
      text-align: center;
      padding: 25px;
      background: #1a4ed8;
      color: white;
      margin-top: 50px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="image/SBlogo.jpg" alt="Municipality Logo">
      <span>Municipality of Ramos<br><small>Sangguniang Bayan</small></span>
    </div>
    <nav>
      <a href="index.php">Home</a>
      <a href="resolutions.php">Resolutions</a>
      <a href="events.php">Events</a>
      <a href="sangguniang.php">SB Members</a>
    </nav>
  </header>

  <main>
    <h1>Upcoming Events</h1>

<div class="grid">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php $row = $result->fetch_assoc(); ?>
      <div class="card">
        <div class="date-tag"><?= date("F j, Y", strtotime($row['event_date'])) ?></div>
        <h3><?= htmlspecialchars($row['event_name']) ?></h3>
        <?php if (!empty($row['event_image'])): ?>
          <img src="<?= htmlspecialchars($row['event_image']) ?>" alt="Event Image" style="width:100%; border-radius:10px; margin-top:10px;">
        <?php endif; ?>
        <p class="desc"><?= nl2br(htmlspecialchars($row['event_desc'])) ?></p>
      </div>
  <?php else: ?>
    <p style="text-align:center; color:#555;">No upcoming events added yet.</p>
  <?php endif; ?>
</div>

  <footer>
    &copy; <?= date("Y") ?> Municipality of Ramos — All Rights Reserved
  </footer>
</body>
</html>
