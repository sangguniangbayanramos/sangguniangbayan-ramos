<?php
// ===== DATABASE CONNECTION =====
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Database connection failed: " . $conn->connect_error);
}

// ===== DELETE FUNCTION =====
if (isset($_GET['delete_type']) && isset($_GET['id'])) {
  $type = $_GET['delete_type'];
  $id = intval($_GET['id']);

  if ($type === 'ordinance') {
    $conn->query("DELETE FROM ordinances WHERE id = $id");
  } elseif ($type === 'resolution') {
    $conn->query("DELETE FROM resolutions WHERE id = $id");
  } elseif ($type === 'event') {
    $result = $conn->query("SELECT event_image FROM events WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
      if (!empty($row['event_image']) && file_exists($row['event_image'])) {
        unlink($row['event_image']); // delete old image file
      }
    }
    $conn->query("DELETE FROM events WHERE id = $id");
  }

  header("Location: admin_dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — Municipality of Ramos</title>
  <style>
    * { box-sizing: border-box; font-family: "Poppins", sans-serif; }
    body {
      margin: 0;
      background-color: #f5f7fb;
    }
    header {
      background-color: #1a4ed8;
      color: white;
      padding: 15px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h1 { font-size: 20px; margin: 0; }
    nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: 500;
    }
    nav a:hover { text-decoration: underline; }

    main {
      padding: 40px;
      max-width: 1000px;
      margin: auto;
    }
    h2 {
      color: #1a4ed8;
      margin-bottom: 10px;
    }
    .card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 40px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    form input, form textarea, form button {
      display: block;
      width: 100%;
      margin-top: 10px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    form button {
      background-color: #1a4ed8;
      color: white;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: 0.2s;
    }
    form button:hover { background-color: #153bb3; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th { background-color: #1a4ed8; color: white; }
    tr:nth-child(even) { background-color: #f9f9f9; }
    .delete-btn {
      color: white;
      background-color: crimson;
      padding: 6px 10px;
      border-radius: 5px;
      text-decoration: none;
    }
    .delete-btn:hover { background-color: darkred; }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard — Municipality of Ramos</h1>
    <nav>
      <a href="index.php">View Website</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <!-- Ordinances Section -->
    <div class="card">
      <h2>Upload Ordinance</h2>
      <form action="add_ordinance.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="ordinance_title" placeholder="Ordinance Title" required>
        <textarea name="ordinance_desc" placeholder="Ordinance Description"></textarea>
        <input type="file" name="ordinance_file" accept=".pdf" required>
        <button type="submit">Upload Ordinance</button>
      </form>

      <h3>Uploaded Ordinances</h3>
      <table>
        <tr><th>ID</th><th>Title</th><th>Description</th><th>Action</th></tr>
        <?php
        $res = $conn->query("SELECT * FROM ordinances ORDER BY id DESC");
        if ($res && $res->num_rows > 0):
          while ($row = $res->fetch_assoc()):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['ordinance_title']) ?></td>
            <td><?= htmlspecialchars($row['ordinance_desc']) ?></td>
            <td><a href="?delete_type=ordinance&id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this ordinance?')">Delete</a></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="4" style="text-align:center;">No ordinances uploaded yet.</td></tr>
        <?php endif; ?>
      </table>
    </div>

    <!-- Resolutions Section -->
    <div class="card">
      <h2>Upload Resolution</h2>
      <form action="add_resolution.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="resolution_title" placeholder="Resolution Title" required>
        <textarea name="resolution_desc" placeholder="Resolution Description"></textarea>
        <input type="file" name="resolution_file" accept=".pdf" required>
        <button type="submit">Upload Resolution</button>
      </form>

      <h3>Uploaded Resolutions</h3>
      <table>
        <tr><th>ID</th><th>Title</th><th>Description</th><th>Action</th></tr>
        <?php
        $res = $conn->query("SELECT * FROM resolutions ORDER BY id DESC");
        if ($res && $res->num_rows > 0):
          while ($row = $res->fetch_assoc()):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['resolution_title']) ?></td>
            <td><?= htmlspecialchars($row['resolution_desc']) ?></td>
            <td><a href="?delete_type=resolution&id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this resolution?')">Delete</a></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="4" style="text-align:center;">No resolutions uploaded yet.</td></tr>
        <?php endif; ?>
      </table>
    </div>

    <!-- Events Section -->
    <div class="card">
      <h2>Upload Event</h2>
      <form action="add_event.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="event_name" placeholder="Event Name" required>
        <input type="date" name="event_date" required>
        <textarea name="event_desc" placeholder="Event Description"></textarea>
        <input type="file" name="event_image" accept="image/*" required>
        <button type="submit">Upload Event</button>
      </form>

      <h3>Current Event</h3>
      <table>
        <tr><th>ID</th><th>Name</th><th>Date</th><th>Action</th></tr>
        <?php
        $res = $conn->query("SELECT * FROM events ORDER BY uploaded_at DESC LIMIT 1");
        if ($res && $res->num_rows > 0):
          while ($row = $res->fetch_assoc()):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['event_name']) ?></td>
            <td><?= htmlspecialchars($row['event_date']) ?></td>
            <td><a href="?delete_type=event&id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Delete this event?')">Delete</a></td>
          </tr>
        <?php endwhile; else: ?>
          <tr><td colspan="4" style="text-align:center;">No events uploaded yet.</td></tr>
        <?php endif; ?>
      </table>
    </div>
  </main>
</body>
</html>