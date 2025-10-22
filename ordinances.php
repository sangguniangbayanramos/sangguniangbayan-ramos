<?php
// ======== DATABASE CONNECTION ========
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// ======== SEARCH FUNCTION ========
$search = "";
if (isset($_GET['search'])) {
  $search = $conn->real_escape_string($_GET['search']);
  $query = "SELECT * FROM sbordinances 
            WHERE ordinance_no LIKE '%$search%' 
               OR title LIKE '%$search%' 
               OR author LIKE '%$search%'
               OR year LIKE '%$search%'
            ORDER BY year DESC, ordinance_no ASC";
} else {
  $query = "SELECT * FROM sbordinances ORDER BY year DESC, ordinance_no ASC";
}

$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ordinances — Municipality of Ramos</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Poppins", sans-serif;
    }

    body {
      position: relative;
      min-height: 100vh;
      background-color: #f5f7fbe1;
      color: #1a1a1a;
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
      animation: wave 12s ease-in-out infinite alternate;
    }

    @keyframes wave {
      0% { background-position: center top; }
      100% { background-position: center bottom; }
    }

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

    main {
      max-width: 1100px;
      margin: 40px auto;
      text-align: center;
      position: relative;
      z-index: 2;
    }

    h1 {
      color: #1a4ed8;
      margin-bottom: 25px;
    }

    .search-container {
      display: flex;
      justify-content: center;
      margin-bottom: 40px;
    }
    .search-container input[type="text"] {
      padding: 10px 15px;
      width: 350px;
      border-radius: 25px 0 0 25px;
      border: 1px solid #ccc;
      outline: none;
    }
    .search-container button {
      background-color: #1a4ed8;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 0 25px 25px 0;
      cursor: pointer;
      transition: 0.3s;
    }
    .search-container button:hover {
      background-color: #0f3cc9;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
    }

    .card {
      background: rgba(255,255,255,0.9);
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      padding: 20px;
      text-align: left;
      position: relative;
      transition: all 0.3s ease;
      backdrop-filter: blur(5px);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .year-tag {
      background-color: #ffcc00;
      color: #000;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 12px;
      position: absolute;
      top: 15px;
      left: 15px;
    }

    .card h3 {
      color: #1a4ed8;
      margin-top: 40px;
      font-size: 17px;
      font-weight: 600;
    }

    .card p {
      margin-top: 8px;
      font-size: 14px;
      color: #333;
    }

    .btn {
      display: inline-block;
      margin-top: 10px;
      background: #1a4ed8;
      color: white;
      padding: 8px 16px;
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
      transition: background 0.2s ease;
    }
    .btn:hover {
      background: #0f3cc9;
    }

    footer {
      text-align: center;
      padding: 25px;
      background: #1a4ed8;
      color: white;
      margin-top: 50px;
      font-size: 14px;
      z-index: 2;
      position: relative;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <img src="image/SBlogo.jpg" alt="Municipality Logo" />
      <span>Municipality of Ramos<br><small>Sangguniang Bayan</small></span>
    </div>
    <nav>
      <a href="Landingpage.php">Home</a>
      <a href="resolutions.php">Resolutions</a>
      <a href="sangguniang.php">SB Members</a>
    </nav>
  </header>

  <main>
    <h1>Ordinances</h1>

    <form class="search-container" method="GET">
      <input type="text" name="search" placeholder="Search Ordinances by number, title, author, or year..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">Search</button>
    </form>

    <div class="grid">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <div class="year-tag"><?= htmlspecialchars($row['year']) ?></div>

            <h3>Ordinance No. <?= htmlspecialchars($row['ordinance_no']) ?></h3>
            <p><strong>Title:</strong> <?= htmlspecialchars($row['title']) ?></p>
            <p><strong>Author/Proponent:</strong> <?= htmlspecialchars($row['author']) ?></p>

            <?php if (!empty($row['file_path'])): ?>
              <a class="btn" href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">📄 View File</a>
            <?php else: ?>
              <p><em>No file uploaded.</em></p>
            <?php endif; ?>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center; color:#555;">No ordinances uploaded yet.</p>
      <?php endif; ?>
    </div>
  </main>

  <footer>
    &copy; <?= date("Y") ?> Municipality of Ramos — All Rights Reserved
  </footer>
</body>
</html>
