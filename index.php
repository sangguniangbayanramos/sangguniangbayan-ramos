
  padding: 0;
}

/* add global section spacing */
section, header, footer, .hero, .event_latest_wrapper {
  width: 100%;
  margin: 0 auto;
  padding: 20px 60px;
  box-sizing: border-box;
}

    /* ===== HEADER ===== */
    header {
      position:relative;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:16px 24px;
      background:var(--gradient);
      border-radius:16px;
      box-shadow:var(--shadow);
      color:white;
      overflow:hidden;
    }

    header::before {
      content:"";
      position:absolute;
      width:220px;
      height:220px;
      background:radial-gradient(circle at center,rgba(255,255,255,0.2),transparent 70%);
      top:-70px;
      left:-60px;
      animation:moveGlow 8s infinite alternate;
    }

    @keyframes moveGlow {
      from { transform:translate(0,0); }
      to { transform:translate(40px,20px); }
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
    .brand:hover .logo-img { transform:scale(1.08) rotate(5deg); }

    .brand div strong {
      font-size:30px;
      font-weight:800;
      letter-spacing:1px;
      text-shadow:0 3px 6px rgba(0,0,0,0.3);
    }

    .brand div span {
      font-size:15px;
      color:rgba(255,255,255,0.9);
    }

    nav a {
      color:white;
      text-decoration:none;
      padding:10px 16px;
      border-radius:10px;
      transition:all .3s ease;
      background:rgba(255,255,255,0.15);
      backdrop-filter:blur(8px);
    }
    nav a:hover {
      background:rgba(255,255,255,0.3);
      transform:translateY(-2px);
    }

    .header-border {
      height:6px;
      background:linear-gradient(90deg,#ffc107,#ff5722,#ff9800);
      border-radius:0 0 12px 12px;
      margin-top:-8px;
      animation:gradientFlow 6s ease infinite alternate;
      background-size:200% 100%;
    }

    @keyframes gradientFlow {
      0% { background-position:0% 50%; }
      100% { background-position:100% 50%; }
    }

    .header-banner {
      position:relative;
      width:100%;
      height:250px;
      border-radius:var(--radius);
      overflow:hidden;
      box-shadow:var(--shadow);
      margin-top:24px;
    }

    .header-banner img {
      width:100%;
      height:100%;
      object-fit:cover;
      filter:brightness(0.8);
      transition:transform 6s ease;
      position: absolute;
      top: 0;
      left: 0;
    }
    .header-banner:hover img { transform:scale(1.05); }

    .header-banner .header-text {
      position:absolute;
      bottom:20px;
      left:30px;
      color:white;
      text-shadow:0 3px 10px rgba(0,0,0,0.6);
      animation:fadeUp 1.2s ease;
    }



    @keyframes fadeUp {
      from { opacity:0; transform:translateY(20px); }
      to { opacity:1; transform:translateY(0); }
    }

    .hero {
      background:rgba(255,255,255,0.9);
      border-radius:var(--radius);
      padding:30px;
      box-shadow:var(--shadow);
      display:grid;
      grid-template-columns:1fr 380px;
      gap:18px;
      align-items:center;
      margin-top:24px;
      backdrop-filter:blur(6px);
    }

    .hero h1 { margin:0; font-size:30px; font-weight:800; }
    .hero p { color:var(--muted); margin-top:8px; font-size:15px; }
    .hero .quick-links { display:flex; flex-wrap:wrap; gap:10px; margin-top:14px; }
    .pill {
      background:linear-gradient(90deg,rgba(11,94,215,0.15),rgba(13,148,136,0.08));
      padding:10px 14px;
      border-radius:999px;
      font-weight:600;
      text-decoration:none;
      color:#0b5ed7;
      transition:all .3s ease;
    }
    .pill:hover {
      background:linear-gradient(90deg,rgba(11,94,215,0.25),rgba(13,148,136,0.15));
      transform:translateY(-2px);
    }

    .card {
      background:var(--card);
      padding:18px;
      border-radius:12px;
      box-shadow:var(--shadow);
    }

    /* ==== EVENTS ==== */
    h3 { text-align:center; font-size:26px; margin-top:40px; margin-bottom:20px; }

    .event_latest_wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      align-items: flex-start;
    }

    .event_grid {
      flex: 1.5;
      min-width: 320px;
    }

    .latest_updates {
      flex: 1;
      min-width: 280px;
      background: #fff;
      border-radius: 16px;
      box-shadow: var(--shadow);
      padding: 20px;
    }

    .latest_updates h4 {
      text-align: center;
      color: var(--accent);
      margin-bottom: 15px;
    }

    .update_card {
      background: rgba(240,240,255,0.8);
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    }

    .update_card h5 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }

    .update_card p {
      margin: 4px 0;
      font-size: 14px;
      color: #444;
    }

    .event_card {
      background:rgba(255,255,255,0.85);
      border-radius:20px;
      padding:25px;
      box-shadow:0 6px 20px rgba(0,0,0,0.08);
      transition:all 0.4s ease;
      max-width:550px;
      width:100%;
      backdrop-filter:blur(10px);
      position:relative;
      margin-bottom: 25px;
    }

    .event_card:hover {
      transform:translateY(-6px) scale(1.02);
      box-shadow:0 12px 25px rgba(0,0,0,0.15);
    }

    .date-tag {
      background-color:#ffcc00;
      color:#000;
      font-weight:700;
      font-size:15px;
      padding:6px 14px;
      border-radius:30px;
      position:absolute;
      top:15px;
      right:15px;
      box-shadow:0 3px 6px rgba(0,0,0,0.15);
    }

    .event_card h3 {
      color:#1a4ed8;
      font-size:24px;
      text-align:center;
      margin-bottom:15px;
      margin-top:35px;
      font-weight:700;
      letter-spacing:.5px;
    }

    .event_card img {
      width:100%;
      max-width:450px;
      display:block;
      margin:15px auto;
      border-radius:14px;
      box-shadow:0 4px 15px rgba(0,0,0,0.15);
      transition:transform .4s ease;
    }

    .event_card img:hover { transform:scale(1.05); }

    .desc {
      font-size:16px;
      color:#444;
      margin-top:12px;
      text-align:center;
      font-style:italic;
      line-height:1.6;
    }

    footer {
      margin-top:24px;
      padding:20px 0;
      color:var(--muted);
      font-size:14px;
      display:flex;
      justify-content:space-between;
    }
  .mmv-section {
    margin-top: 60px;
    text-align: center;
  }

  .mmv-section h2 {
    font-size: 30px;
    font-weight: 800;
    color: #0b5ed7;
    margin-bottom: 25px;
    text-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }

  .mmv-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
  }

  .mmv-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-top: 6px solid #0b5ed7;
  }

  .mmv-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
  }

  .mmv-card h3 {
    color: #0b5ed7;
    font-size: 22px;
    margin-bottom: 12px;
  }

  .mmv-card p {
    font-size: 16px;
    color: #333;
    line-height: 1.6;
  }
.fb-icon {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
.fb-icon:hover {
  transform: scale(1.2);
  box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

  .media-container {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-top: 20px;
  }

  .media-box {
    flex: 1;
    min-width: 300px;
    text-align: center;
  }

  .media-box video,
  .media-box img {
    width: 100%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    cursor: pointer;
    transition: transform 0.2s ease;
  }

  .media-box img:hover {
    transform: scale(1.02);
  }

  .media-box h3 {
    margin-bottom: 10px;
    color: #333;
  }

  /* Popup overlay */
  #mapPopup {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.8);
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  #mapPopup img {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.5);
  }

  #mapPopup button {
    position: absolute;
    top: 20px;
    right: 30px;
    background: #e74c3c;
    color: #fff;
    border: none;
    padding: 8px 14px;
    font-size: 18px;
    border-radius: 6px;
    cursor: pointer;
  }

  #mapPopup button:hover {
    background: #c0392b;
  }

.slideshow-container {
  position: relative;
  max-width: 800px;
  margin: 30px auto;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  background: white;
}

.slide {
  display: none;
  text-align: center;
}

.slide img {
  width: 100%;
  height: 400px;
  object-fit: cover;
}

.slide p {
  background: rgba(255, 255, 255, 0.85);
  padding: 10px;
  font-size: 16px;
  font-weight: 500;
  color: #444;
}

.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  padding: 12px;
  border-radius: 50%;
  background-color: rgba(0,0,0,0.5);
  color: white;
  font-weight: bold;
  font-size: 18px;
  user-select: none;
}

.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.7);
}

.prev {
  left: 10px;
}

.next {
  right: 10px;
}

  </style>
</head>
<body>
 <div class="container">
  <header>
  <a href="login.php" class="brand" title="Municipality of Ramos">
    <img src="image/logo.jpg" alt="Ramos Seal" class="logo-img">
    <div>
      <strong>SANGGUNIANG BAYAN</strong><br>
      <span>Municipality of Ramos · Official Website</span><br>
      <span id="clock" style="font-size:14px; font-weight:600; color:white;"></span>
    </div>
    </a>
    
    <script>
function updateClock() {
  const options = {
    timeZone: "Asia/Manila",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: true
  };
  const timeString = new Date().toLocaleTimeString("en-PH", options);
  document.getElementById("clock").textContent = "🕒 " + timeString;
}
setInterval(updateClock, 1000);
updateClock();
</script>


    <!-- Hidden login button (removed for public view) -->
    <!-- <nav>
      <a href="login.php" class="btn btn-primary">Log In</a>
    </nav> -->
  </header>


    <div class="header-border"></div>

    <section class="header-banner">
      <img src="image/sb.jpg" alt="Municipality of Ramos Header">
      <div class="header-text">
      </div>
    </section>

    <section class="hero">
      <div>
        <h1>Welcome to the Municipality of Ramos</h1>
        <p>Working together for a cleaner, safer, and more prosperous community.</p>
        <div class="quick-links">
          <a class="pill" href="sangguniang.php">Sangguniang Bayan</a>
          <a class="pill" href="ordinances.php">View Ordinances</a>
          <a class="pill" href="resolutions.php">View Resolutions</a>
          <a class="pill" href="faq.php">FAQ</a>
        </div>
      </div>
      <aside class="card">
        <h3>Important Notice</h3>
        <p><strong>ADDRESS: </strong><i class="fa-solid fa-location-dot"></i>  Legislative Building, Municipal Hall Compound, Pob. Center, Ramos, Tarlac.</p>
        <p><strong>CONTACT US:</strong> <i class="fa-solid fa-phone"></i> (054) 470-9933</p>
        <p><strong>FOLLOW US:</strong>  <a href="https://web.facebook.com/profile.php/?id=61578169541072&_rdc=1&_rdr#" target="_blank" 
        title="Visit Sangguniang Bayan Ramos, Tarlac on Facebook"><i class="fa-brands fa-facebook"></i> Facebook</p> </a>
      </aside>
    </section>

  

  <!-- NEW FLEX WRAPPER FOR EVENTS + LATEST UPDATES -->
  <div class="event_latest_wrapper">
    <!-- LEFT SIDE: EVENTS -->
    <div class="event_grid" id="events">
      <h3>Upcoming Events</h3>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <div class="event_card">
            <div class="date-tag"><?= date("F j, Y", strtotime($row['event_date'])) ?></div>
            <h3><?= htmlspecialchars($row['event_name']) ?></h3>
            <?php if (!empty($row['event_image'])): ?>
              <img src="<?= htmlspecialchars($row['event_image']) ?>" alt="Event Image">
            <?php endif; ?>
            <p class="desc"><?= nl2br(htmlspecialchars($row['event_desc'])) ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center; color:#555;">No upcoming events added yet.</p>
      <?php endif; ?>
    </div>

    <!-- RIGHT SIDE: LATEST ORDINANCE & RESOLUTION -->
    <div class="latest_updates">
      <h4>📜 Latest Ordinance & Resolution</h4>

      <div class="update_card">
        <h5>Latest Ordinance</h5>
        <?php
          $latestOrdinance = $conn->query("SELECT ordinance_no, year, title, author FROM sbordinances ORDER BY id DESC LIMIT 1");
          if ($latestOrdinance && $latestOrdinance->num_rows > 0) {
            $ord = $latestOrdinance->fetch_assoc();
            echo "<p><strong>Ordinance No.</strong> " . htmlspecialchars($ord['ordinance_no']) . " - "  . htmlspecialchars($ord['year']) .  "</p>";
            echo "<p><strong>Title:</strong> " . htmlspecialchars($ord['title']) . "</p>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($ord['author']) . "</p>";
          } else {
            echo "<p>No ordinances found.</p>";
          }
        ?>
      </div>

      <div class="update_card">
        <h5>Latest Resolution</h5>
        <?php
          $latestResolution = $conn->query("SELECT number, title, author FROM resolutions ORDER BY id DESC LIMIT 1");
          if ($latestResolution && $latestResolution->num_rows > 0) {
            $res = $latestResolution->fetch_assoc();
            echo "<p><strong>Resolution No.</strong> " . htmlspecialchars($res['number']) . "</p>";
            echo "<p><strong>Title:</strong> " . htmlspecialchars($res['title']) . "</p>";
            echo "<p><strong>Author:</strong> " . htmlspecialchars($res['author']) . "</p>";
          } else {
            echo "<p>No resolutions found.</p>";
          }
        ?>
      </div>
    </div>
  </div>



<section class="mmv-section">
  <h2>Mandate · Mission · Vision</h2>
  <div class="mmv-container">

    <div class="mmv-card">
      <h3>Mandate</h3>
      <p>Enact ordinances, approve resolutions and appropriate funds for the welfare of the LGU and its inhabitants. Approve ordinances and pass resolutions necessary for an efficient local government.</p>
    </div>

    <div class="mmv-card">
      <h3>Mission</h3>
      <p>The legislative branch of the Local Government Unit of Ramos envisions a progressive municipality responding to the basic needs of its constituents through responsive social and developmental legislations.</p>
    </div>

    <div class="mmv-card">
      <h3>Vision</h3>
      <p>The Sangguniang Bayan of Ramos, as the legislative body of the municipality, shall perform its ordained duties and functions in this realm of RA 7160 and legislate in synergy with the Municipal Sustainable Development Plans and Programs to attain participatory good governance, efficient delivery of basic services, with a seal of transparency and accountability to people.</p>
    </div>
  </div>
</section>

<h3>📸 Featured Photos</h3>

<div class="slideshow-container" id="photoSlideshow"></div>

<p id="noPhotoMessage" class="no-photo" style="display: none;">
  No photos selected yet. Please visit the admin page to upload and select photos.
</p>

</div>

<div class="media-container">
  <div class="media-box">
    <h3>Awit ng Ramos</h3>
    <video controls>
      <source src="uploads/AWIT NG RAMOS.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>
  </div>

  <div class="media-box">
    <h3>Ramos Map</h3>
    <img src="uploads/map.jfif" alt="Ramos Map" onclick="openMapPopup(this.src)">
  </div>
</div>

<!-- Map Popup -->
<div id="mapPopup">
  <button onclick="closeMapPopup()">×</button>
  <img id="popupMap" src="" alt="Full Map">
</div>


    <footer>
      <div>© Municipality of Ramos · All rights reserved</div>
      <div class="muted">Designed for accessibility and responsiveness</div>
    </footer>
  </div>

<script>
  function openMapPopup(src) {
    document.getElementById('popupMap').src = src;
    document.getElementById('mapPopup').style.display = 'flex';
  }

  function closeMapPopup() {
    document.getElementById('mapPopup').style.display = 'none';
  }

function loadSelectedPhotos() {
  const photos = JSON.parse(localStorage.getItem("photos") || "[]");
  const selectedPhotos = photos.filter(photo => photo.selected);
  const slideshow = document.getElementById("photoSlideshow");
  const noPhotoMsg = document.getElementById("noPhotoMessage");

  slideshow.innerHTML = "";

  if (selectedPhotos.length === 0) {
    noPhotoMsg.style.display = "block";
    return;
  } else {
    noPhotoMsg.style.display = "none";
  }

  selectedPhotos.forEach((photo, index) => {
    const slide = document.createElement("div");
    slide.classList.add("slide");
    slide.innerHTML = `
      <img src="${photo.src}" alt="Municipality Photo">
      <p>${photo.caption || "(No caption)"}</p>
    `;
    slideshow.appendChild(slide);
  });

  // Add navigation buttons
  slideshow.innerHTML += `
    <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
    <a class="next" onclick="changeSlide(1)">&#10095;</a>
  `;

  showSlide(slideIndex);
}

let slideIndex = 1;

function showSlide(n) {
  const slides = document.getElementsByClassName("slide");
  if (slides.length === 0) return;

  if (n > slides.length) { slideIndex = 1 }
  if (n < 1) { slideIndex = slides.length }

  for (let slide of slides) {
    slide.style.display = "none";
  }

  slides[slideIndex - 1].style.display = "block";
}

function changeSlide(n) {
  showSlide(slideIndex += n);
}

// Auto-advance slideshow every 5 seconds
setInterval(() => changeSlide(1), 5000);

// Load on start
loadSelectedPhotos();
</script>

</body>
</html>
