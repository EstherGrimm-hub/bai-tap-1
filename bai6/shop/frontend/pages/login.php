<?php
// Kiểm tra session, nếu đã đăng nhập rồi, chuyển hướng tới trang chính
session_start();

if (isset($_SESSION['id'])) {
  header('Location: /shop/frontend/index.php');
  exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  include_once(__DIR__ . '/../../dbconnect.php');
  $conn = connectDb();

  $username = trim($_POST['username']);
  $password = $_POST['password'];

  // Truy vấn user theo username
  $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) { 
    $user = $result->fetch_assoc(); 
    if (password_verify($password, $user['password'])) { 
      $_SESSION['id'] = $user['id']; // đổi thành 'id' thay vì 'user_id' để đồng bộ toàn hệ thống
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role']; // lưu role vào session

      header('Location: /shop/frontend/index.php'); 
      exit(); 
    } else { 
      $error = "Invalid Username or Password!"; 
    } 
  } else { 
    $error = "Invalid Username or Password!"; 
  } 
  $conn->close(); 
} 
?> 

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <?php include_once(__DIR__ . '/../layouts/styles.php'); ?>
  <style>
    body {
      background-color: #f5f5f5;
    }
    .error-message {
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 bg-white p-4 rounded shadow-sm">
      <h2 class="text-center mb-4">Login</h2>

      <?php if (!empty($error)) : ?>
        <div class="error-message text-center">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" required />
        </div>
        <div class="form-group mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required />
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <p class="text-center mt-3">Chưa có tài khoản? <a href="/shop/frontend/pages/register.php">Đăng ký</a></p>
    </div>
  </div>

  <?php include_once(__DIR__ . '/../layouts/partials/footer.php'); ?>
  <?php include_once(__DIR__ . '/../layouts/scripts.php'); ?>
</body>
</html>
