<?php
include 'db_connect.php'; // your connection file
// Fetch all ordinances

$sql = "SELECT * FROM sbordinances";
$result = $conn->query($sql);

$ordinances = [];

while ($row = $result->fetch_assoc()) {
    $ordinances[$row['author']][] = $row;
}

if (isset($_GET['author'])) {
    $author = $_GET['author'];

    $query = "SELECT ordinance_no, year, title, status FROM sbordinances WHERE author = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("SQL error: " . $conn->error . " | Query: " . $query);
    }

    $stmt->bind_param("s", $author);
    $stmt->execute();
    $result = $stmt->get_result();

    $enacted = [];
    $ongoing = [];

    while ($row = $result->fetch_assoc()) {
        if ($row['status'] == 'Enacted') {
            $enacted[] = $row;
        } else {
            $ongoing[] = $row;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>12th Sangguniang Bayan — Municipality of Ramos (2025–2028)</title>
  <style>
    :root {
      --bg: #f6f7fb;
      --card: #ffffff00;
      --muted: #070808;
      --accent: #0b5ed7;
      --radius: 14px;
      --max-width: 1000px;
      --shadow: 0 5px 10px rgba(20, 24, 36, 0.08);
    }

body {
  margin:0;
  font-family:Inter,Arial,sans-serif;
  background:linear-gradient(180deg,var(--bg),#4188e6);
  color:#111827;
  line-height:1.45;
  padding:32px 16px;
  display:flex;
  justify-content:center;
}

.container { width:100%; max-width:var(--max-width); }

/* ===== NEW HEADER STYLE ===== */
header {
  position:relative;
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:16px 24px;
  background:linear-gradient(90deg,#0b5ed7,#1e90ff);
  border-radius:16px;
  box-shadow:var(--shadow);
  color:white;
  overflow:hidden;
  margin-bottom:20px;
}

header::before, header::after {
  content:"";
  position:absolute;
  top:0;
  bottom:0;
  width:120px;
  transform:skewX(-30deg);
  background:rgba(255,255,255,0.08);
  animation:slideLines 6s linear infinite alternate;
}
header::after { right:-60px; }
header::before { left:-60px; }

@keyframes slideLines {
  from { transform:skewX(-30deg) translateX(0); }
  to { transform:skewX(-30deg) translateX(30px); }
}

.brand {
  display:flex;
  align-items:center;
  gap:14px;
  text-decoration:none;
  color:white;
  position:relative;
  z-index:2;
}

.logo-img {
  width:64px;
  height:64px;
  border-radius:50%;
  object-fit:cover;
  border:3px solid #fff;
  box-shadow:0 4px 10px rgba(0,0,0,0.3);
  transition:transform .3s ease;
}

.brand:hover .logo-img { transform:scale(1.08); }

.brand div strong {
  font-size:26px;
  font-weight:800;
  letter-spacing:1px;
  text-shadow:0 3px 6px rgba(0,0,0,0.3);
}

.brand div span {
  font-size:15px;
  color:rgba(255,255,255,0.9);
}

nav {
  display:flex;
  align-items:center;
  gap:14px;
  z-index:2;
}

nav a {
  color:white;
  text-decoration:none;
  padding:8px 14px;
  border-radius:8px;
  transition:background .3s;
}

nav a:hover { background:rgba(255,255,255,0.2); }

.header-border {
  height:6px;
  background:linear-gradient(90deg,#ffc107,#ff5722);
  border-radius:0 0 12px 12px;
  margin-top:-8px;
  margin-bottom:24px;
}

/* ===== BANNER ===== */
.header-banner {
  position:relative;
  width:100%;
  height:220px;
  border-radius:var(--radius);
  overflow:hidden;
  box-shadow:var(--shadow);
  margin-bottom:24px;
}

.header-banner img {
  width:100%;
  height:100%;
  object-fit:cover;
  filter:brightness(0.75);
}

.header-banner .header-text {
  position:absolute;
  bottom:20px;
  left:30px;
  color:white;
  text-shadow:0 2px 6px rgba(0,0,0,0.6);
}

.header-banner h1 { margin:0; font-size:32px; }
.header-banner p { margin:4px 0 0; font-size:16px; }

/* ===== MEMBERS ===== */
h1 { margin-top:0; text-align:center; color:#0b5ed7; font-size:28px; }
.grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:18px; }

.member {
  background:linear-gradient(180deg,#ffffff 70%,#f0f4ff);
  padding:16px;
  border-radius:18px;
  box-shadow:0 6px 15px rgba(0,0,0,0.12);
  text-align:center;
  transition:transform .25s ease,box-shadow .25s ease;
  border:3px solid #0b5ed7;
  position:relative;
  overflow:hidden;
}

.member::before {
  content:"";
  position:absolute;
  top:-40px;
  left:-40px;
  width:120%;
  height:120px;
  background:linear-gradient(135deg,#ffcc00,#e63946);
  transform:rotate(-5deg);
  z-index:0;
}

.member img {
  width:220px;
  height:260px;
  object-fit:cover;
  border-radius:12px;
  border:4px solid white;
  box-shadow:0 4px 10px rgba(0,0,0,0.2);
  position:relative;
  z-index:1;
  margin-top:30px;
  transition:transform .3s ease;
  cursor:pointer;
}

.member:hover img { transform:scale(1.05); }

.member h3 {
  margin:12px 0 4px;
  font-size:18px;
  font-weight:700;
  color:#0b5ed7;
  position:relative;
  z-index:1;
  text-transform:uppercase;
  line-height:1.3;
  min-height:48px;
}

.member p {
  margin:0;
  font-size:14px;
  color:#333;
  font-weight:500;
  position:relative;
  z-index:1;
}

.member:hover {
  transform:translateY(-6px);
  box-shadow:0 12px 25px rgba(0,0,0,0.18);
}

footer {
  margin-top:24px;
  padding:20px 0;
  color:var(--muted);
  font-size:14px;
  display:flex;
  justify-content:space-between;
}

.btn {
  display:inline-block;
  padding:10px 14px;
  border-radius:10px;
  text-decoration:none;
  background:var(--accent);
  color:white;
}

/* ===== POPUP IMAGE ===== */
.popup {
  display:none;
  position:fixed;
  z-index:1000;
  left:0;
  top:0;
  width:100%;
  height:100%;
  background:rgba(0,0,0,0.85);
  justify-content:center;
  align-items:center;
}

.popup img {
  max-width:90%;
  max-height:80%;
  border-radius:12px;
  box-shadow:0 0 20px rgba(255,255,255,0.3);
}

.close-btn {
  position:absolute;
  top:30px;
  right:50px;
  font-size:30px;
  color:white;
  text-decoration:none;
  background:rgba(0,0,0,0.5);
  padding:6px 12px;
  border-radius:8px;
  transition:.3s;
}

.member-info h3 {
  margin: 6px 0 4px;
  font-size: 20px;
  color: #0b5ed7;
  text-transform: uppercase;
}

.member-info p {
  margin: 0;
  color: #333;
  font-weight: 500;
}

.committees h4 {
  margin-top: 12px;
  color: #111;
  font-size: 16px;
}

.committees ul {
  text-align: left;
  margin-left: 40px;
  color: #333;
}

/* Ordinance Section (Right Side) */
.ordinance-info {
  flex: 0 0 50%;
  background: #eceff4;
  border-radius: 16px;
  padding: 25px;
  box-shadow: inset 0 0 10px rgba(0,0,0,0.1);
}

.ordinance-info h3 {
  color: #0b5ed7;
  font-size: 18px;
  border-bottom: 2px solid #0b5ed7;
  padding-bottom: 4px;
  margin-bottom: 8px;
}

.ordinance-info ul {
  margin-left: 25px;
  color: #333;
  line-height: 1.6;
}

.close-btn:hover { background:#e63946; }

.imagePopup {
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.6);
  align-items:center;
  justify-content:center;
  z-index:999;
  gap: 10px; /* space between left and right sections */
  padding:100px;
}

.imagePopup .left {
  flex:1; 
  display:flex; 
  justify-content:center; 
  align-items:center;
}

.imagePopup .left img {
  max-width:100%;
  max-height:80vh; 
  border-radius:10px; 
  box-shadow:0 4px 10px rgba(0,0,0,0.3);
}

.imagePopup .right {
    flex:1;
    background:#fff;
    border-radius:12px;
    padding:30px;
    box-shadow:0 4px 12px rgba(0,0,0,0.2);
    overflow-y:auto;
    max-height:80vh;
}
.imagePopup .right h2{
  color:#0b5ed7; margin-top:0;font-size:large;
}
.imagePopup .right h3 {
  color:#2c3e50; border-bottom:2px solid #0b5ed7; padding-bottom:4px;
}
.imagePopup .right ul {
  list-style:none; padding-left:10px;
} 



  </style>
</head>
<body>
  <div class="container">
    <header>
      <a href="#" class="brand">
        <img src="image/logo.jpg" alt="Ramos Seal" class="logo-img">
        <div>
          <strong>SANGGUNIANG BAYAN</strong><br>
          <span>Municipality of Ramos · Official Website</span>
        </div>
      </a>
      <nav>
        <a href="Landingpage.php">Home</a>
        <a href="ordinances.php">Ordinances</a>
        <a href="resolutions.php">Resolutions</a>
      </nav>
    </header>

    <div class="header-border"></div>

    <section class="header-banner">
      <img src="image/sb.jpg" alt="Municipality of Ramos Header">
      <div class="header-text"></div>
    </section>

    <main>
      <h1>12th Sangguniang Bayan (2025–2028)</h1>
      <p style="color:var(--muted);text-align:center">
        Meet the elected members of the Sangguniang Bayan of Ramos, Province of Tarlac.
      </p>

<div class="grid">
  <div class="member" onclick="openPopup('image/vice.jpg', 'EDGARDO FLORES SUÑIGA JR.')">
    <img src="image/vice.jpg" alt="Vice Mayor">
    <h3>HON. EDGARDO FLORES SUÑIGA JR.</h3>
    <p>Municipal Vice Mayor / Presiding Officer</p>
  </div>

  <div class="member" onclick="openPopup('image/doming.jpg', 'DOMINGO BUGARIN RAMOS')">
    <img src="image/doming.jpg" alt="Councilor 1">
    <h3>HON. DOMINGO BUGARIN RAMOS</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/rene.jpg', 'RENEE LAMBINO TOLENTINO')">
    <img src="image/rene.jpg" alt="Councilor 2">
    <h3>HON. RENEE LAMBINO TOLENTINO</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/pam.jpg', 'RICHARD VILLACENTINO POCO')">
    <img src="image/pam.jpg" alt="Councilor 3">
    <h3>HON. RICHARD VILLACENTINO POCO</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/alex.jpg', 'ALEXANDER CADIENTE ROSARIO')">
    <img src="image/alex.jpg" alt="Councilor 4">
    <h3>HON. ALEXANDER CADIENTE ROSARIO</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/jose.jpg', 'JOSE VICTOR AGUSTIN PADUA')">
    <img src="image/jose.jpg" alt="Councilor 5">
    <h3>HON. JOSE VICTOR AGUSTIN PADUA</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/joel.jpg', 'JOEL YEBES AQUINO')">
    <img src="image/joel.jpg" alt="Councilor 6">
    <h3>HON. JOEL YEBES AQUINO</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/aldrin.jpg', 'ALDRIN TANGONAN ANCHETA')">
    <img src="image/aldrin.jpg" alt="Councilor 7">
    <h3>HON. ALDRIN TANGONAN ANCHETA</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/purong.jpg', 'BARTOLOME MACARAEG JONATAS')">
    <img src="image/purong.jpg" alt="Councilor 8">
    <h3>HON. BARTOLOME MACARAEG JONATAS</h3>
    <p>Municipal Councilor</p>
  </div>

  <div class="member" onclick="openPopup('image/marlon.jpg', 'MARLON EPINO BANAG')">
    <img src="image/marlon.jpg" alt="ABC President">
    <h3>HON. MARLON EPINO BANAG</h3>
    <p>ABC President</p>
  </div>

  <div class="member" onclick="openPopup('image/wendy.jpg', 'WENDY AQUINO SORIANO')">
    <img src="image/wendy.jpg" alt="SK Chairman">
    <h3>HON. WENDY AQUINO SORIANO</h3>
    <p>MFSK President</p>
  </div>

  <div class="member" onclick="openPopup('image/maamja.jpg', 'JANICE MACARAEG - CABATBAT')">
    <img src="image/maamja.jpg" alt="Secretary">
    <h3>JANICE MACARAEG - CABATBAT</h3>
    <p>Secretary to the Sangguniang</p>
  </div>
</div>

    </main>

    <footer>
      <div>© Municipality of Ramos · All rights reserved</div>
    </footer>
  </div>

  <div id="popup-logo" class="popup">
    <a href="#" class="close-btn">&times;</a>
    <img src="image/logo.jpg" alt="Municipal Seal">
  </div>


  
  <div id="imagePopup" class="imagePopup">
  <div class="left">
    <img id="popupImage" src="" alt="Popup Image">
  </div>

  <div class="right">
    <!-- Ordinances will appear here via JS -->
  </div>
</div>

<script>
  const ordinancesData = <?php echo json_encode($ordinances); ?>;

  function openPopup(imgSrc, authorName) {
    document.getElementById("popupImage").src = imgSrc;
    document.getElementById("imagePopup").style.display = "flex";

    const container = document.querySelector(".right");
    const authorOrds = ordinancesData[authorName] || [];
    let html = `<h2>Ordinances by <span style='color:#0b5ed7;'>${authorName}</span></h2>`;

    if (authorOrds.length === 0) {
      html += "<p>No ordinances found for this member.</p>";
    } else {
      // We’ll define which statuses to display and in what order
      const sections = ["Enacted", "Ongoing"];

      sections.forEach(status => {
        const filtered = authorOrds.filter(
          o => o.status.toLowerCase() === status.toLowerCase()
        );

        html += `<h2>${status} Ordinances</h2><ul>`;
        if (filtered.length > 0) {
          filtered.forEach(o => {
            html += `<li><strong> Ordinance No. ${o.ordinance_no} - ${o.year}</strong> - ${o.title}</li>`;
          });
        } else {
          html += `<li>No ${status.toLowerCase()} ordinances yet.</li>`;
        }
        html += "</ul>";
      });
    }

    // Add Close button
    html += `
      <div style='text-align:right; margin-top:20px;'>
        <button onclick='closePopup()' 
          style="
            background:#e74c3c; 
            color:white; 
            padding:8px 16px; 
            border:none; 
            border-radius:6px; 
            cursor:pointer;
            font-weight:bold;
          ">
          ✖ Close
        </button>
      </div>`;

    container.innerHTML = html;
  }

  function closePopup() {
    document.getElementById("imagePopup").style.display = "none";
  }
</script>
</body>
</html>
