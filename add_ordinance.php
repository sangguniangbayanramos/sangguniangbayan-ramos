<?php
include 'db_connect.php'; // Database connection


// ===== ADD NEW ORDINANCE =====
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $ordinance_no = $_POST['ordinance_no'];
    $year = $_POST['year'];
    $title = $_POST['title'];
    $author = ($_POST['author'] === 'Others') ? $_POST['other_author'] : $_POST['author'];
    $status = $_POST['status'];

    $file_path = null;
    if (isset($_FILES['ord_file']) && $_FILES['ord_file']['error'] === 0) {
        $file_type = mime_content_type($_FILES['ord_file']['tmp_name']);
        if ($file_type !== "application/pdf") {
            echo "<script>alert('Only PDF files are allowed.'); window.history.back();</script>";
            exit;
        }
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = time() . "_" . basename($_FILES['ord_file']['name']);
        $target_file = $upload_dir . $file_name;
        move_uploaded_file($_FILES['ord_file']['tmp_name'], $target_file);
        $file_path = $target_file;
    }

    if ($file_path) {
        $stmt = $conn->prepare("INSERT INTO sbordinances (ordinance_no, year, title, author, status, file_path)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $ordinance_no, $year, $title, $author, $status, $file_path);
        $stmt->execute();
        echo "<script>alert('✅ Ordinance added successfully!'); window.location.href='add_ordinance.php';</script>";
    }
}

// ===== UPDATE ORDINANCE =====
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $ordinance_no = $_POST['ordinance_no'];
    $year = $_POST['year'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = $_POST['status'];

    if (isset($_FILES['ord_file']) && $_FILES['ord_file']['error'] === 0) {
        $file_type = mime_content_type($_FILES['ord_file']['tmp_name']);
        if ($file_type !== "application/pdf") {
            echo "<script>alert('Only PDF files are allowed.'); window.history.back();</script>";
            exit;
        }
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $file_name = time() . "_" . basename($_FILES['ord_file']['name']);
        $target_file = $upload_dir . $file_name;
        move_uploaded_file($_FILES['ord_file']['tmp_name'], $target_file);

        // Delete old file
        $res = $conn->query("SELECT file_path FROM sbordinances WHERE id = $id");
        $old = $res->fetch_assoc();
        if ($old && file_exists($old['file_path'])) unlink($old['file_path']);

        $stmt = $conn->prepare("UPDATE sbordinances SET ordinance_no=?, year=?, title=?, author=?, status=?, file_path=? WHERE id=?");
        $stmt->bind_param("ssssssi", $ordinance_no, $year, $title, $author, $status, $target_file, $id);
    } else {
        $stmt = $conn->prepare("UPDATE sbordinances SET ordinance_no=?, year=?, title=?, author=?, status=? WHERE id=?");
        $stmt->bind_param("sssssi", $ordinance_no, $year, $title, $author, $status, $id);
    }

    $stmt->execute();
    echo "<script>alert('✏️ Ordinance updated successfully!'); window.location.href='add_ordinance.php';</script>";
}

// ===== DELETE ORDINANCE =====
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT file_path FROM sbordinances WHERE id = $id");
    $file = $res->fetch_assoc();
    if ($file && file_exists($file['file_path'])) unlink($file['file_path']);
    $conn->query("DELETE FROM sbordinances WHERE id = $id");
    echo "<script>alert('🗑️ Deleted successfully!'); window.location.href='add_ordinance.php';</script>";
    exit;
}

// ===== FETCH EXISTING ORDINANCES =====
$result = $conn->query("SELECT * FROM sbordinances ORDER BY year DESC, id DESC");

// ===== COUNCILORS LIST =====
$councilors = [
    "EDGARDO FLORES SUÑIGA JR.",
    "DOMINGO BUGARIN RAMOS",
    "RENEE LAMBINO TOLENTINO",
    "RICHARD VILLACENTINO POCO",
    "ALEXANDER CADIENTE ROSARIO",
    "JOSE VICTOR AGUSTIN PADUA",
    "JOEL YEBES AQUINO",
    "ALDRIN TANGONAN ANCHETA",
    "BARTOLOME MACARAEG JONATAS",
    "MARLON EPINO BANAG",
    "WENDY AQUINO SORIANO",
    "Others"
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Ordinance — Municipality of Ramos</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: linear-gradient(180deg, #f6f7fb, #4188e6);
  margin: 0;
  padding: 40px;
}
.form-container {
  background: #fff;
  padding: 30px 40px;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  width: 420px;
  margin: 0 auto 40px;
  text-align: center;
}
h2 { color: #0b5ed7; margin-bottom: 20px; }
form { display: flex; flex-direction: column; gap: 12px; }
input, select, textarea {
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 14px;
}
button {
  background: #0b5ed7;
  color: white;
  border: none;
  padding: 12px;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
}
button:hover { background: #094bb0; }
.table-container {
  background: #fff;
  padding: 20px;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
  width: 90%;
  margin: auto;
}
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
th, td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
  text-align: center;
}
th { background: #0b5ed7; color: white; }
.action-btn {
  padding: 6px 10px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  color: white;
}
.edit { background: #f39c12; }
.delete { background: #e74c3c; }
.view { background: #2ecc71; }

/* ===== MODAL STYLES ===== */
.modal {
  display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.6); justify-content: center; align-items: center;
}
.modal-content {
  background: white; padding: 25px; border-radius: 12px; width: 400px;
  position: relative; animation: fadeIn 0.3s;
}
@keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
.close-btn {
  position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer;
  color: #e74c3c; font-weight: bold;
}
</style>
</head>
<body>

<div class="form-container">
  <h2>Add New Ordinance</h2>

  <form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="add" value="1">
    <input type="text" name="ordinance_no" placeholder="Ordinance Number" required>
    <input type="text" name="year" placeholder="Year" required>
    <textarea name="title" placeholder="Ordinance Title" required></textarea>

    <select name="author" id="authorSelect" onchange="toggleOtherAuthor()">
      <option value="">-- Select Author (Councilor) --</option>
      <?php foreach ($councilors as $councilor): ?>
        <option value="<?php echo $councilor; ?>"><?php echo $councilor; ?></option>
      <?php endforeach; ?>
    </select>

    <input type="text" name="other_author" id="otherAuthorInput" placeholder="Enter Author Name" style="display:none;">

    <select name="status" required>
      <option value="">-- Select Status --</option>
      <option value="Enacted">Enacted</option>
      <option value="Ongoing">Ongoing</option>
    </select>

    <label>Upload File (PDF)</label>
    <input type="file" name="ord_file" accept=".pdf" required>

    <button type="submit">Save Ordinance</button>
  </form>
</div>

<div class="table-container">
  <h2>📜 Existing Ordinances</h2>
  <table>
    <tr>
      <th>#</th>
      <th>Ordinance No</th>
      <th>Year</th>
      <th>Author</th>
      <th>Title</th>
      <th>Status</th>
      <th>File</th>
      <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): 
      $i = 1;
      while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['ordinance_no']) ?></td>
          <td><?= htmlspecialchars($row['year']) ?></td>
          <td><?= htmlspecialchars($row['author']) ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td><a href="<?= $row['file_path'] ?>" target="_blank" class="action-btn view">View</a></td>
      <td>
        <button class="action-btn edit" onclick="openModal(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
        <a href="?delete=<?= $row['id'] ?>" class="action-btn delete" onclick="return confirm('Delete this ordinance?')">Delete</a>
      </td>
        </tr>
    <?php endwhile; else: ?>
      <tr><td colspan="8">No ordinances found.</td></tr>
    <?php endif; ?>
  </table>
</div>

<!-- ===== MODAL POPUP FORM ===== -->
<div class="modal" id="editModal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">×</span>
    <h3>Edit Ordinance</h3>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="update" value="1">
      <input type="hidden" name="id" id="edit_id">
      <input type="text" name="ordinance_no" id="edit_no" placeholder="Ordinance No" required>
      <input type="text" name="year" id="edit_year" placeholder="Year" required>
      <textarea name="title" id="edit_title" placeholder="Title" required></textarea>

      <!-- Author Dropdown -->
      <select name="author" id="edit_author" required onchange="toggleEditOtherAuthor()">
        <option value="">-- Select Author --</option>
        <?php foreach ($councilors as $c): ?>
          <option value="<?= $c ?>"><?= $c ?></option>
        <?php endforeach; ?>
        <option value="Others">Others</option>
      </select>

      <!-- Shown only when "Others" is selected -->
      <input type="text" name="other_author" id="edit_other_author" placeholder="Enter Author Name" style="display:none;">

      <select name="status" id="edit_status" required>
        <option value="Enacted">Enacted</option>
        <option value="Ongoing">Ongoing</option>
      </select>

      <label>Replace File (PDF, optional)</label>
      <input type="file" name="ord_file" accept=".pdf">

      <button type="submit">Update Ordinance</button>
    </form>
  </div>
</div>
<div style="text-align:center;"> <button type="button" onclick="window.location.href='Dashboard.php'" >
  GO BACK
</button></div>


<script>
function toggleOtherAuthor() {
  const authorSelect = document.getElementById('authorSelect');
  const otherAuthorInput = document.getElementById('otherAuthorInput');
  if (authorSelect.value === 'Others') {
    otherAuthorInput.style.display = 'block';
    otherAuthorInput.required = true;
  } else {
    otherAuthorInput.style.display = 'none';
    otherAuthorInput.required = false;
  }
}

// 🟦 For Edit Modal — show text input if "Others" is selected
function toggleEditOtherAuthor() {
  const authorSelect = document.getElementById('edit_author');
  const otherInput = document.getElementById('edit_other_author');
  if (authorSelect.value === 'Others') {
    otherInput.style.display = 'block';
    otherInput.required = true;
  } else {
    otherInput.style.display = 'none';
    otherInput.required = false;
  }
}

function openModal(data) {
  document.getElementById('edit_id').value = data.id;
  document.getElementById('edit_no').value = data.ordinance_no;
  document.getElementById('edit_year').value = data.year;
  document.getElementById('edit_title').value = data.title;
  document.getElementById('edit_author').value = data.author;
  document.getElementById('edit_status').value = data.status;

  // Show "Other Author" field if author is not in dropdown
  const authorSelect = document.getElementById('edit_author');
  const otherInput = document.getElementById('edit_other_author');
  const exists = Array.from(authorSelect.options).some(opt => opt.value === data.author);

  if (!exists) {
    authorSelect.value = "Others";
    otherInput.style.display = 'block';
    otherInput.value = data.author;
  } else {
    otherInput.style.display = 'none';
    otherInput.value = '';
  }

  document.getElementById('editModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('editModal').style.display = 'none';
}
window.onclick = function(e) {
  if (e.target == document.getElementById('editModal')) closeModal();
}
</script>
</body>
</html>
