<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $position = trim($_POST['position']);
  $password = trim($_POST['password']);

  // Encrypt password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Insert user
  $stmt = $conn->prepare("INSERT INTO users (username, email, position, password, created_at) VALUES (?, ?, ?, ?, NOW())");
  $stmt->bind_param("ssss", $username, $email, $position, $hashed_password);

  if ($stmt->execute()) {
    echo "<script>alert('✅ User successfully added!'); window.location='list.php';</script>";
  } else {
    echo "<script>alert('❌ Error adding user: " . $stmt->error . "');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add User</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e9f0ff, #f4f5f5);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: #1eb5e4;
  }
  .container {
    background: #fff;
    padding: 30px 40px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    width: 350px;
    text-align: center;
  }
  .logo {
    width: 80px;
    height: 80px;
    margin-bottom: 10px;
    border-radius: 50%;
    object-fit: cover;
  }
  h2 {
    margin-bottom: 20px;
    color: #0b5ed7;
  }
  label {
    display: block;
    text-align: left;
    margin-bottom: 6px;
    font-weight: 500;
  }
  input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: 0.2s;
  }
  input:focus, select:focus {
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
</style>
</head>
<body>

<div class="container">
  <img src="image/logo.jpg" alt="Logo" class="logo">
  <h2>Add New User</h2>

  <form method="POST" action="">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="position">Position</label>
    <select id="position" name="position" required>
      <option value="">-- Select Position --</option>
      <option value="Admin">Admin</option>
      <option value="Staff">Staff</option>
    </select>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Add User</button>
  </form>
</div>

</body>
</html>
