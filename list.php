<?php
// ===== DATABASE CONNECTION =====
$conn = new mysqli("localhost", "root", "", "ramos_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ===== DELETE HANDLER =====
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM users WHERE id = $id");
  header("Location: list.php");
  exit;
}

// ===== FETCH USERS =====
$result = $conn->query("SELECT id, username, email, position FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - User List</title>
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #e0f7fa, #ffffff);
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }

  .dashboard {
    background: #fff;
    width: 90%;
    max-width: 900px;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    margin-top: 40px;
    padding: 30px 50px;
  }

  h2 {
    text-align: center;
    color: #0b5ed7;
    margin-bottom: 30px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    font-size: 15px;
  }

  th {
    background: #0b5ed7;
    color: white;
  }

  tr:nth-child(even) {
    background-color: #f8f9fa;
  }

  tr:hover {
    background-color: #eef4ff;
  }

  .btn {
    background: #0c4191ff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
  }

  .btn:hover {
    background: #093e91;
  }

  .delete-btn {
    background: #dc3545;
  }

  .delete-btn:hover {
    background: #b02a37;
  }

  .no-data {
    text-align: center;
    color: #777;
    font-style: italic;
    margin-top: 20px;
  }

  footer {
    text-align: center;
    margin-top: 25px;
    color: #777;
    font-size: 13px;
  }

  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .top-bar a {
    background: #0b5ed7;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 15px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
  }

  .top-bar a:hover {
    background: #093e91;
  }
</style>
</head>
<body>

<div class="dashboard">
  <div class="top-bar">
    <h2>👥 Registered Users</h2>
    <a href="add_users.php">➕ Add New User</a>
  </div>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>Position</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
          echo "
          <tr>
            <td>{$count}</td>
            <td>{$row['username']}</td>
            <td>{$row['email']}</td>
            <td>{$row['position']}</td>
            <td>
              <a href='list.php?delete={$row['id']}' class='btn delete-btn' onclick='return confirm(\"Delete this user?\")'>Delete</a>
            </td>
          </tr>";
          $count++;
        }
      } else {
        echo "<tr><td colspan='5' class='no-data'>No registered users found.</td></tr>";
      }
      ?>
    </tbody>
  </table>

  <footer>© 2025 Municipal Feedback System | Admin Panel</footer>
</div>

</body>
</html>
