<?php
// ======== DATABASE CONNECTION (optional, if needed later) ========
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>FAQ — Municipality of Ramos</title>
  <link rel="icon" type="image/x-icon" href="image/logo.jpg" />
  <style>
    :root {
      --bg:#eef3ff;
      --card:#ffffffd0;
      --muted:#6b7280;
      --accent:#0b5ed7;
      --radius:18px;
      --shadow:0 8px 25px rgba(0,0,0,0.08);
      --gradient:linear-gradient(135deg,#0b5ed7,#007bff,#00a2ff);
    }

    body {
      margin:0;
      font-family:Inter,Arial,sans-serif;
      background:linear-gradient(180deg,var(--bg),#ffffff);
      color:#111827;
      line-height:1.45;
      padding:32px 16px;
      display:flex;
      justify-content:center;
      background-attachment:fixed;
      background-image:radial-gradient(circle at top left,rgba(11,94,215,0.15),transparent 50%),
                       radial-gradient(circle at bottom right,rgba(0,162,255,0.12),transparent 50%);
    }

    .container { width:100%; max-width:1000px; 
    }

    header {
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:16px 24px;
      background:var(--gradient);
      border-radius:16px;
      box-shadow:var(--shadow);
      color:white;
    }

    .brand {
      display:flex;
      align-items:center;
      gap:14px;
      text-decoration:none;
      color:white;
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

    .faq-section {
      margin-top: 40px;
      background: rgba(255,255,255,0.9);
      border-radius: var(--radius);
      padding: 30px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(6px);
    }

    .faq-section h3 {
      text-align: center;
      font-size: 28px;
      margin-bottom: 25px;
      color: #0b5ed7;
    }

    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      margin-bottom: 10px;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .faq-question {
      width: 100%;
      background: var(--gradient);
      color: white;
      text-align: left;
      font-weight: 600;
      padding: 16px 20px;
      border: none;
      cursor: pointer;
      outline: none;
      transition: background 0.3s ease;
    }

    .faq-question:hover {
      background: linear-gradient(135deg,#0a53be,#0b5ed7);
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      background: #f9fafb;
      transition: max-height 0.4s ease, padding 0.3s ease;
      padding: 0 20px;
    }

    .faq-answer p {
      color: #444;
      line-height: 1.6;
      margin: 15px 0;
    }

    .faq-item.active .faq-answer {
      max-height: 200px;
      padding: 15px 20px;
    }

    .faq-item.active .faq-question {
      background: linear-gradient(135deg,#007bff,#00a2ff);
    }

    footer {
      margin-top: 40px;
      padding: 20px 0;
      color: var(--muted);
      font-size: 14px;
      text-align: center;
    }

    .back-link {
      display: inline-block;
      margin-top: 10px;
      text-decoration: none;
      color: var(--accent);
      font-weight: 600;
      transition: color 0.3s;
    }

    .back-link:hover {
      color: #073477ff;
      text-decoration: underline;
    }

      h2 {
    color: #0b5ed7;
    margin-bottom: 20px;
  }

  label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-weight: 500;
    color: #333;
  }

  input, textarea, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: 0.2s;
    font-size: 14px;
  }

  input:focus, textarea:focus, select:focus {
    border-color: #0b5ed7;
    box-shadow: 0 0 4px rgba(11, 94, 215, 0.5);
  }

  button {
    background: #0b5ed7;
    color: white;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
  }

  button:hover {
    background: #004aad;
  }

  /* Popup Styling */
  .popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 16px;
    padding: 30px 50px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    text-align: center;
    z-index: 1000;
    animation: fadeIn 0.3s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translate(-50%, -45%); }
    to { opacity: 1; transform: translate(-50%, -50%); }
  }

  .popup-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
  }

  .popup img {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    object-fit: cover;
  }

  .popup h3 {
    color: #0b5ed7;
    margin-bottom: 10px;
    font-size: 22px;
  }

  .popup p {
    font-size: 16px;
    color: #333;
    margin: 5px 0;
  }

  .popup button {
    margin-top: 20px;
    background: #0b5ed7;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
  }

  .popup button:hover {
    background: #004aad;
  }

  /* Overlay */
  .overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 999;
  }

  .emoji {
    font-size: 40px;
    margin-bottom: 10px;
  }

  .aray {
    font-weight: bold;
    color: #ff4747;
    font-size: 18px;
  }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <a href="index.php" class="brand">
        <img src="image/logo.jpg" alt="Ramos Seal" class="logo-img">
        <div>
          <strong>SANGGUNIANG BAYAN</strong><br>
          <span>Municipality of Ramos · Official Website</span>
        </div>
      </a>
      <a href="Landingpage.php" class="back-link">Home</a>
    </header>

    <section class="faq-section">
      <h3>Frequently Asked Questions</h3>

      <div class="faq-container">
        <div class="faq-item">
          <button class="faq-question">How can I request a copy of an ordinance?</button>
          <div class="faq-answer">
            <p>You can request a certified copy by visiting the Sangguniang Bayan Office or emailing <strong>sboffice@ramos.gov.ph</strong>.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Where can I view approved Resolutions?</button>
          <div class="faq-answer">
            <p>All approved resolutions are available in the <a href="resolutions.php">Resolutions</a> page of this website.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Where can I view enacted Ordinances?</button>
          <div class="faq-answer">
            <p>All enacted ordinances are available in the <a href="ordinances.php">Ordinances</a> page of this website.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">Who are the Sangguniang Bayan officials?</button>
          <div class="faq-answer">
            <p>You can find a complete list with their photos in the <a href="sangguniang.php">Sangguniang Bayan Members</a> page.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">How do I contact the Municipality of Ramos?</button>
          <div class="faq-answer">
            <p>You may reach the municipal office via phone at (045) 470-9933 or visit us at the Legislative Building, Municipal Hall Compound, Pob. Center, Ramos, Tarlac.</p>
          </div>
        </div>
      </div>

        <h2>Suggestion & Question Form</h2>
  <form id="suggestionForm">
    <label for="name">Your Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="type">Type</label>
    <select id="type" name="type" required>
      <option value="">-- Select Type --</option>
      <option value="Suggestion">Suggestion</option>
      <option value="Question">Question</option>
    </select>

    <label for="message">Message</label>
    <textarea id="message" name="message" rows="4" placeholder="Enter your message here..." required></textarea>

    <button type="submit">Submit</button>
  </form>
    </section>

    <footer>
      © Municipality of Ramos · All rights reserved
    </footer>
  </div>
<!-- Popup -->
<div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
  <div class="emoji">😄</div>
  <h3>Thank You!</h3>
  <div class="popup-content">
    <div>
      <p id="popupMessage">Thank you for sharing your feedback!</p>
    </div>
  </div>
  <button id="closePopup">Close</button>
</div>



  <script>
    document.querySelectorAll(".faq-question").forEach(btn => {
      btn.addEventListener("click", () => {
        const item = btn.parentElement;
        item.classList.toggle("active");
        document.querySelectorAll(".faq-item").forEach(other => {
          if (other !== item) other.classList.remove("active");
        });
      });
    });

  const form = document.getElementById('suggestionForm');
  const popup = document.getElementById('popup');
  const overlay = document.getElementById('overlay');
  const popupMessage = document.getElementById('popupMessage');
  const closePopup = document.getElementById('closePopup');

  form.addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value.trim();
    const type = document.getElementById('type').value;
    const message = document.getElementById('message').value.trim();

    if (name && type && message) {
      const confirmSubmit = confirm(`Submit your ${type.toLowerCase()}?`);
      if (confirmSubmit) {
        // Save locally for now
        const entry = { name, type, message, date: new Date().toLocaleString() };
        const existing = JSON.parse(localStorage.getItem('entries')) || [];
        existing.push(entry);
        localStorage.setItem('entries', JSON.stringify(existing));

        // Show popup
        popupMessage.textContent = `Thank you for sharing your feedback, ${name}!`;
        popup.style.display = 'block';
        overlay.style.display = 'block';

        // Reset form
        form.reset();
      }
    } else {
      alert('Please fill out all fields.');
    }
  });

  closePopup.addEventListener('click', () => {
    popup.style.display = 'none';
    overlay.style.display = 'none';
  });
  </script>
</body>
</html>
