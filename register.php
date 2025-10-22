<?php include 'config.php'; ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Create Account — Admin</title>
  <style>
    body {
      font-family: Inter, sans-serif;
      background: linear-gradient(135deg,#0b5ed7,#0056b3);
      display:flex;justify-content:center;align-items:center;
      height:100vh;color:white;
    }
    form {
      background:white;color:#111;
      padding:30px;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,0.2);
      width:320px;
    }
    input {
      width:100%;padding:10px;margin-bottom:14px;
      border:1px solid #ccc;border-radius:8px;
    }
    button {
      background:#0b5ed7;color:white;border:none;padding:10px;
      width:100%;border-radius:8px;font-weight:600;cursor:pointer;
    }
    button:hover {background:#004aad;}
    a {color:#0b5ed7;text-decoration:none;font-size:14px;}
  </style>
</head>
<body>
<form method="POST">
  <h2>Create Admin Account</h2>
  <input type="text" name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit" name="register">Register</button>
  <p>Already have an account? <a href="login.php">Login</a></p>
</form>

<?php
if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = $conn->prepare("SELECT * FROM users WHERE username=?");
  $check->bind_param("s", $username);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo "<script>alert('Username already exists!');</script>";
  } else {
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    echo "<script>alert('Account created successfully!');window.location='login.php';</script>";
  }
}
?>
</body>
</html>
