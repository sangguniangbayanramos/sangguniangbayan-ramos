<?php
// ===== DATABASE CONNECTION =====
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ===== DELETE HANDLER =====
if (isset($_GET['delete']) && isset($_GET['type'])) {
  $id = intval($_GET['delete']);
  $type = $_GET['type'];

  if ($type === 'ordinance') {
    $res = $conn->query("SELECT file_path FROM ordinances WHERE id = $id");
    if ($res && $row = $res->fetch_assoc()) {
      if (file_exists($row['file_path'])) unlink($row['file_path']);
    }
    $conn->query("DELETE FROM ordinances WHERE id = $id");
  } elseif ($type === 'resolution') {
    $res = $conn->query("SELECT file_path FROM resolutions WHERE id = $id");
    if ($res && $row = $res->fetch_assoc()) {
      if (file_exists($row['file_path'])) unlink($row['file_path']);
    }
    $conn->query("DELETE FROM resolutions WHERE id = $id");
  } elseif ($type === 'event') {
    $res = $conn->query("SELECT event_image FROM events WHERE id = $id");
    if ($res && $row = $res->fetch_assoc()) {
      if (file_exists($row['event_image'])) unlink($row['event_image']);
    }
    $conn->query("DELETE FROM events WHERE id = $id");
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
  $id = intval($_POST['edit_id']);
  $type = $_POST['edit_type'];
  $number = $_POST['edit_number'];
  $author = $_POST['edit_author'];
  $title = $_POST['edit_title'];

  if ($type === 'ordinance') {
    $conn->query("UPDATE ordinances SET ord_number='$number', author='$author', title='$title' WHERE id=$id");
  } elseif ($type === 'resolution') {
    $conn->query("UPDATE resolutions SET res_number='$number', author='$author', title='$title' WHERE id=$id");
  }}

  header("Location: dashboard.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Dashboard — Municipality of Ramos</title>
  <style>
    :root {
      --bg: #f6f7fb;
      --card: #ffffff;
      --accent: #0b5ed7;
      --muted: #374151;
      --radius: 14px;
      --shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    body {
      margin: 0;
      font-family: "Inter", Arial, sans-serif;
      background: linear-gradient(180deg, var(--bg), #4188e6);
      color: #111827;
      display: flex;
      min-height: 100vh;
    }

  /* 🔹 SIDEBAR */
  .sidebar {
    width: 230px;
    background: linear-gradient(180deg, #0b5ed7, #004aad);
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 25px 15px;
    position: fixed;
    top: 0;
    bottom: 0;
    box-shadow: 2px 0 8px rgba(0,0,0,0.15);
  }
  .sidebar img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid white;
    margin-bottom: 10px;
  }
  .sidebar h2 {
    font-size: 18px;
    text-align: center;
    margin-bottom: 30px;
  }
  .sidebar a {
    width: 100%;
    color: white;
    text-decoration: none;
    padding: 12px 16px;
    margin: 5px 0;
    border-radius: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
    transition: background 0.3s ease, transform 0.2s ease;
  }
  .sidebar a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
  }

    /* MAIN CONTENT */
    .main-content {
      margin-left: 240px;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }


    .brand {
      display: flex;
      align-items: center;
      gap: 14px;
      text-decoration: none;
      color: inherit;
    }
    .brand img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border: 3px solid white;
      object-fit: cover;
    }

    .container {
      width: 95%;
      max-width: 1200px;
      padding: 40px 20px;
    }

    h1 {
      text-align: center;
      color: #0b5ed7;
      margin-bottom: 40px;
      font-size: 32px;
      text-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 24px;
    }

    .card {
      background: var(--card);
      padding: 20px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      transition: transform 0.3s ease;
      border-top: 5px solid var(--accent);
    }
    .card:hover { transform: translateY(-6px); }

    label {
      font-weight: 600;
      color: var(--muted);
      display: block;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="file"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
      margin-bottom: 12px;
      box-sizing: border-box;
    }

    textarea { resize: vertical; min-height: 80px; }

    button {
      background: var(--accent);
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: background 0.3s ease;
    }
    button:hover { background: #004aad; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
      font-size: 14px;
    }
    th { background: var(--accent); color: white; }
    tr:nth-child(even) { background: #f9f9f9; }

    .edit-btn, .delete-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 8px;
      text-decoration: none;
      transition: all 0.25s ease;
    }
    .edit-btn { background: #ffc107; color: #212529; }
    .edit-btn:hover { background: #ffca2c; }
    .delete-btn { background: #dc3545; color: white; }
    .delete-btn:hover { background: #c82333; }

    footer {
      text-align: center;
      color: #555;
      font-size: 14px;
      padding: 20px 0;
      border-top: 1px solid #ddd;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<!-- 🔹 SIDEBAR -->
<aside class="sidebar">
  <img src="image/logo.jpg" alt="Municipal Seal">
  <h2>Municipality of Ramos</h2>
  <a href="Landingpage.php">🏠 Home</a>
  <a href="ordinances.php">📜 Ordinances</a>
  <a href="resolutions.php">🧾 Resolutions</a>
  <a href="events.php">🎉 Events</a>
  <a href="receive.php"> Receive</a>
  <a href="list.php">User List</a>
  <a href="add_ordinance.php">Add Ordinance</a>
  <a href="upload_photo.php">Upload Photo</a>
  <a href="Landingpage.php">Logout</a> 
</aside>

<!-- ✅ MAIN CONTENT -->
<div class="main-content">
<div class="container">
  <h1>Administrative Dashboard</h1>
  <div class="grid">


    <!-- Resolutions -->
    <div class="card">
      <h2>Upload Resolution</h2>
      <form action="upload_resolution.php" method="POST" enctype="multipart/form-data">
        <label>Resolution Number</label>
        <input type="text" name="res_number" required>
        <label>Author/Proponent</label>
        <input type="text" name="res_author" required>
        <label>Title</label>
        <textarea name="res_title"></textarea>
        <label>Upload File (PDF)</label>
        <input type="file" name="res_file" accept=".pdf" required>
        <button type="submit">Upload Resolution</button>
      </form>
      

<h3>Existing Resolutions</h3>
<table>
  <tr>
    <th>No.</th>
    <th>Title</th>
    <th>Author</th>
    <th>Actions</th>
  </tr>
  <?php
  $res = $conn->query("SELECT * FROM resolutions ORDER BY uploaded_at DESC");
  if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
echo "<tr>
        <td>" . htmlspecialchars($row['number']) . "</td>
        <td>" . htmlspecialchars($row['title']) . "</td>
        <td>" . htmlspecialchars($row['author']) . "</td>
        <td>
          <a href='#' class='edit-btn' onclick='openModal(" 
               . json_encode($row['id']) . ","
               . json_encode('resolution') . ","
               . json_encode($row['number'] ?? '') . ","
               . json_encode($row['author'] ?? '') . ","
               . json_encode($row['title'] ?? '') .","
               . json_encode($row['file_path'] ?? '') .
             ")'>Edit</a>
          &nbsp;
          <a href='?delete={$row['id']}&type=resolution' class='delete-btn' onclick='return confirm(\"Delete this ordinance?\")'>Delete</a>
        </td>
      </tr>";
    }
  } else echo "<tr><td colspan='4' style='text-align:center;'>No resolutions found.</td></tr>";
  ?>
</table>
    </div>

    <!-- Events -->
    <div class="card">
      <h2>Upcoming Event</h2>
      <form action="add_event.php" method="POST" enctype="multipart/form-data">
        <label>Event Name</label>
        <input type="text" name="event_name" required>
        <label>Date</label>
        <input type="date" name="event_date" id="event_date" required>
        <label>Description</label>
        <textarea name="event_desc"></textarea>
        <label>Upload Event Image</label>
        <input type="file" name="event_image" accept="image/*" required>
        <button type="submit">Add Event</button>
      </form>

      <h3>Current Event</h3>
      <table>
        <tr><th>ID</th><th>Event Name</th><th>Date</th><th>Action</th></tr>
        <?php
        $res = $conn->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 1");
        if ($res->num_rows > 0) {
while ($row = $res->fetch_assoc()) {
  echo "<tr>
          <td>{$row['id']}</td>
          <td>".htmlspecialchars($row['event_name'])."</td>
          <td>".htmlspecialchars($row['event_date'])."</td>
          <td>
            <a href='#' class='edit-btn' onclick=\"openModal(
                 {$row['id']},
                 'event',
                 ".json_encode($row['event_name']).",
                 '',
                 ".json_encode($row['event_desc']).",
                 ".json_encode($row['event_date'])."
               )\">Edit</a>
            <a href='?delete={$row['id']}&type=event' class='delete-btn' onclick='return confirm(\"Delete this event?\")'>Delete</a>
          </td>
        </tr>";
}
        } else echo "<tr><td colspan='4' style='text-align:center;'>No event found.</td></tr>";
        ?>
      </table>
    </div>
  </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); align-items:center; justify-content:center; z-index:9999;">
  <div style="background:#fff; padding:20px; border-radius:10px; width:90%; max-width:600px; position:relative;">
    <button onclick="closeModal()" style="position:absolute; right:12px; top:12px; background:#e74c3c; color:#fff; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;">×</button>
    <h3 id="modalTitle">Edit Entry</h3>

    <form id="editForm" method="post" action="edit_entry.php" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit_id">
      <input type="hidden" name="type" id="edit_type">

      <!-- Ordinance / Resolution Fields -->
      <div id="ordiResoFields">
        <label>Ordinance/Resolution Number</label>
        <input type="text" name="number" id="edit_number" style="width:100%; padding:8px; margin:6px 0;">

        <label>Author / Proponent</label>
        <input type="text" name="author" id="edit_author" style="width:100%; padding:8px; margin:6px 0;">

        <label>Title</label>
        <textarea name="title" id="edit_title" style="width:100%; padding:8px; margin:6px 0;"></textarea>

        <label>Replace PDF file (optional):</label>
        <input type="file" name="file" accept=".pdf">
      </div>

      <!-- Event Fields -->
      <div id="eventFields" style="display:none;">
        <label>Event Name</label>
        <input type="text" name="event_name" id="edit_event_name" style="width:100%; padding:8px; margin:6px 0;">

        <label>Event Date</label>
        <input type="date" name="event_date" id="edit_event_date" style="width:100%; padding:8px; margin:6px 0;">
        
        <label>Description</label>
        <textarea name="event_desc" id="edit_event_desc" style="width:100%; padding:8px; margin:6px 0;"></textarea>

        <label>Replace Event Image (optional):</label>
        <input type="file" name="event_image" accept="image/*">
      </div>

      <div style="text-align:right; margin-top:8px;">
        <button type="button" onclick="closeModal()" style="margin-right:8px; padding:8px 12px;">Cancel</button>
        <button type="submit" style="background:#0b5ed7; color:#fff; padding:8px 12px; border:none; border-radius:6px;">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id, type, number = '', author = '', title = '', date = '', desc = '') {
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_type').value = type;

  const ordiResoFields = document.getElementById('ordiResoFields');
  const eventFields = document.getElementById('eventFields');
  const modalTitle = document.getElementById('modalTitle');

  // Check entry type
  if (type === 'event') {
    modalTitle.textContent = 'Edit Event';
    ordiResoFields.style.display = 'none';
    eventFields.style.display = 'block';

    document.getElementById('edit_event_name').value = number || '';
    document.getElementById('edit_event_date').value = date || '';
    document.getElementById('edit_event_desc').value = title || ''; // title param used for desc
  } else {
    modalTitle.textContent = 'Edit Ordinance/Resolution';
    ordiResoFields.style.display = 'block';
    eventFields.style.display = 'none';

    document.getElementById('edit_number').value = number || '';
    document.getElementById('edit_author').value = author || '';
    document.getElementById('edit_title').value = title || '';
  }

  document.getElementById('editModal').style.display = 'flex';
}

document.addEventListener("DOMContentLoaded", () => {
  const today = new Date().toISOString().split("T")[0];
  const dateInput = document.getElementById("event_date");
  if (dateInput) dateInput.setAttribute("min", today);
});

function closeModal() {
  document.getElementById('editModal').style.display = 'none';
}
</script>

<footer>
  © 2025 Municipality of Ramos · Administrative Dashboard
</footer>

</body>
</html>



