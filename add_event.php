<?php
// ====== DATABASE CONNECTION ======
$servername = "localhost";
$username = "root";
$password = "";
$database = "ramos_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ====== EVENT UPLOAD PROCESS ======
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_desc = $_POST['event_desc'];
    $file = $_FILES['event_image'];

    // Directory for uploaded files
    $targetDir = "uploads/";

    // Create folder if not existing
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Make sure file is uploaded
    $event_image = "";
    if (!empty($file["name"])) {
        $fileName = time() . "_" . basename($file["name"]); // Unique filename
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allow only images
        $allowedTypes = array("jpg", "jpeg", "png", "gif");
        if (!in_array($fileType, $allowedTypes)) {
            echo "<script>alert('Only image files (JPG, PNG, GIF) are allowed.'); window.history.back();</script>";
            exit;
        }

        // Upload image
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            $event_image = $targetFilePath;
        } else {
            echo "<script>alert('Image upload failed.'); window.history.back();</script>";
            exit;
        }
    }

    // Delete old event (keep only one)
    $oldEventQuery = "SELECT event_image FROM events LIMIT 1";
    $oldResult = $conn->query($oldEventQuery);

    if ($oldResult && $oldResult->num_rows > 0) {
        $old = $oldResult->fetch_assoc();
        if (!empty($old['event_image']) && file_exists($old['event_image'])) {
            unlink($old['event_image']); // delete old image from folder
        }
        $conn->query("DELETE FROM events");
    }

    // Insert new event
    $stmt = $conn->prepare("INSERT INTO events (event_name, event_date, event_desc, event_image, created_at) VALUES (?, ?, ?, ?, NOW())");

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $event_name, $event_date, $event_desc, $event_image);

    if ($stmt->execute()) {
        echo "<script>alert('Event uploaded successfully!'); window.location.href='Landingpage.php';</script>";
    } else {
        echo "<script>alert('Database insert failed.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
