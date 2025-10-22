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

// ====== FILE UPLOAD PROCESS ======
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['res_number'];
    $author = $_POST['res_author'];
    $title = $_POST['res_title'];
    $file = $_FILES['res_file'];

    // Directory for uploaded files
    $targetDir = "uploads/";

    // Create folder if not existing
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Check if file is PDF
    if ($fileType != "pdf") {
        echo "<script>alert('Only PDF files are allowed.'); window.history.back();</script>";
        exit;
    }

    // Move file to uploads folder
    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
        // Insert record into resoluition table
        $stmt = $conn->prepare("INSERT INTO resolutions (number, author, title, file_path,uploaded_at) VALUES (?, ?, ?, ?, NOW())");

        if (!$stmt) {
            die("SQL Error: " . $conn->error);
        }

        $stmt->bind_param("ssss", $number, $author, $title, $targetFilePath);

        if ($stmt->execute()) {
            echo "<script>alert('Upload Successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Database insert failed.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('File upload failed.'); window.history.back();</script>";
    }
}