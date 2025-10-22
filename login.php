<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
      $_SESSION['username'] = $row['username'];
      header("Location: dashboard.php");
      exit();
    } else {
      echo "<script>alert('Incorrect password.');</script>";
    }
  } else {
    echo "<script>alert('User not found.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Municipality of Ramos</title>
  <link rel="icon" href="assets/logo.png">
  <style>
    body {
      margin: 0;
      font-family: "Inter", Arial, sans-serif;
      background: linear-gradient(to bottom right, #e9f0ff, #ffffff);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background: white;
      width: 360px;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 5px 18px rgba(0, 0, 0, 0.1);
      text-align: center;
    }
    .login-card img {
      width: 80px;
      margin-bottom: 10px;
    }
    .login-card h2 {
      color: #0d47a1;
      margin-bottom: 25px;
      font-size: 22px;
    }
    .form-group {
      text-align: left;
      margin-bottom: 18px;
    }
    .form-group label {
      font-weight: 600;
      font-size: 14px;
      color: #333;
      margin-bottom: 6px;
      display: block;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      outline: none;
      transition: 0.3s;
    }
    .form-group input:focus {
      border-color: #1565c0;
      box-shadow: 0 0 5px rgba(21, 101, 192, 0.2);
    }
    .btn-login {
      background-color: #1565c0;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 10px;
      width: 100%;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-login:hover {
      background-color: #0d47a1;
    }
  </style>
</head>
<body>
  <div class="login-card">
    <img src="image/logo.jpg" alt="Municipality Logo">
    <h2>Sangguinang Bayan</h2>

    <form method="POST" action="">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>
</body>
</html>