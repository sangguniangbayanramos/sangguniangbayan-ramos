<?php
// edit_entry.php
// Update ordinances, resolutions, or events from Dashboard modal/form.
// Adjust table/column names to match your DB if different.

$mysqli = new mysqli("localhost", "root", "", "ramos_db");
if ($mysqli->connect_error) {
    die("DB connect error: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

// Required fields
$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';

if (!$id || !$type) {
    die("Missing id or type.");
}

// Helper: send JS alert and redirect
function reply_and_redirect($msg, $success = true) {
    $script = "<script>alert(" . json_encode($msg) . "); window.location.href='Dashboard.php';</script>";
    echo $script;
    exit;
}

// Prepare variables from POST (common names)
$number = isset($_POST['number']) ? trim($_POST['number']) : '';
$author = isset($_POST['author']) ? trim($_POST['author']) : '';
$title  = isset($_POST['title']) ? trim($_POST['title']) : '';
$desc   = isset($_POST['description']) ? trim($_POST['description']) : '';
$targetPath   = isset($_POST['file_path']) ? trim($_POST['file_path']) : '';
// for events
$event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';

/*
 Expected DB columns (based on your earlier code):
 - ordinances: id, ord_number, ord_author, title, file_path, uploaded_at
 - resolutions: id, res_number, res_author, title, file_path, uploaded_at
 - events: id, event_name, event_date, event_desc, event_image, created_at
*/

// We'll handle file upload replacements if provided
$uploadDir = __DIR__ . "/uploads/";

// Ensure upload dir exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// ================= ORDINANCE =================
if ($type === 'ordinance') {
    $hasFile = isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE;

    if ($hasFile) {
        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            reply_and_redirect("Invalid file type. Only PDF allowed.", false);
        }
        $newName = "ordinance_{$id}_" . time() . ".pdf";
        $targetPath = "uploads/" . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Delete old file
            $old = $mysqli->query("SELECT file_path FROM ordinances WHERE id = $id");
            if ($old && $r = $old->fetch_assoc()) {
                if (file_exists($r['file_path'])) unlink($r['file_path']);
            }

            $stmt = $mysqli->prepare("UPDATE ordinances SET number=?, author=?, title=?, file_path=? WHERE id=?");
            if (!$stmt) die("SQL prepare error: " . $mysqli->error);
            $stmt->bind_param("ssssi", $number, $author, $title, $targetPath, $id);
        } else {
            reply_and_redirect("Failed to upload file.", false);
        }
    } else {
        $stmt = $mysqli->prepare("UPDATE ordinances SET number=?, author=?, title=? WHERE id=?");
        if (!$stmt) die("SQL prepare error: " . $mysqli->error);
        $stmt->bind_param("sssi", $number, $author, $title, $id);
    }

    if ($stmt->execute()) reply_and_redirect("Ordinance updated successfully.");
    else reply_and_redirect("Failed to update ordinance: " . $stmt->error, false);
}

// ================= RESOLUTION =================
elseif ($type === 'resolution') {
    $hasFile = isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE;

    if ($hasFile) {
        $file = $_FILES['file'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            reply_and_redirect("Invalid file type. Only PDF allowed.", false);
        }
        $newName = "resolution_{$id}_" . time() . ".pdf";
        $targetPath = "uploads/" . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Delete old file
            $old = $mysqli->query("SELECT file_path FROM resolutions WHERE id = $id");
            if ($old && $r = $old->fetch_assoc()) {
                if (file_exists($r['file_path'])) unlink($r['file_path']);
            }

            $stmt = $mysqli->prepare("UPDATE resolutions SET number=?, author=?, title=?, file_path=? WHERE id=?");
            if (!$stmt) die("SQL prepare error: " . $mysqli->error);
            $stmt->bind_param("ssssi", $number, $author, $title, $targetPath, $id);
        } else {
            reply_and_redirect("Failed to upload file.", false);
        }
    } else {
        $stmt = $mysqli->prepare("UPDATE resolutions SET number=?, author=?, title=? WHERE id=?");
        if (!$stmt) die("SQL prepare error: " . $mysqli->error);
        $stmt->bind_param("sssi", $number, $author, $title, $id);
    }

    if ($stmt->execute()) reply_and_redirect("Resolution updated successfully.");
    else reply_and_redirect("Failed to update resolution: " . $stmt->error, false);

} elseif ($type === 'event') {
    // Update event_name, event_date, event_desc and optional image
    $hasImage = isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE;
    if ($hasImage) {
        $img = $_FILES['image'];
        $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            reply_and_redirect("Invalid image type. Allowed: " . implode(',', $allowed), false);
        }
        $newName = "evt_{$id}_" . time() . "." . $ext;
        $target = $uploadDir . $newName;
        if (!move_uploaded_file($img['tmp_name'], $target)) {
            reply_and_redirect("Failed to move uploaded image.", false);
        }
        $imgPathDb = "uploads/" . $newName;

        // Delete old image
        $old = $mysqli->query("SELECT event_image FROM events WHERE id = $id");
        if ($old && $r = $old->fetch_assoc()) {
            if (!empty($r['event_image']) && file_exists(__DIR__ . '/' . $r['event_image'])) {
                @unlink(__DIR__ . '/' . $r['event_image']);
            }
        }

        $stmt = $mysqli->prepare("UPDATE events SET event_name = ?, event_date = ?, event_desc = ?, event_image = ? WHERE id = ?");
        if (!$stmt) die("SQL prepare error: " . $mysqli->error);
        $stmt->bind_param("ssssi", $title, $event_date, $desc, $imgPathDb, $id);
    } else {
        $stmt = $mysqli->prepare("UPDATE events SET event_name = ?, event_date = ?, event_desc = ? WHERE id = ?");
        if (!$stmt) die("SQL prepare error: " . $mysqli->error);
        $stmt->bind_param("sssi", $title, $event_date, $desc, $id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        reply_and_redirect("Event updated successfully.");
    } else {
        $err = $stmt->error ?: $mysqli->error;
        $stmt->close();
        reply_and_redirect("Failed updating event: " . $err, false);
    }

} else {
    die("Unknown type.");
}

