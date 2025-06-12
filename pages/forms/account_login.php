<?php
session_start();
require_once '../../config/koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../tables/dashboard.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Akun tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-image: url('../../photo/bg.png');
      background-size: cover;
      background-position: center;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-black/40 backdrop-blur-sm px-4">

  <form method="POST" class="bg-white/90 p-8 rounded-2xl shadow-2xl w-full max-w-md space-y-6 backdrop-blur-md">
    <div class="text-center">
      <h2 class="text-3xl font-extrabold text-pink-500">Login to <span class="text-yellow-400">BudgetIn</span></h2>
      <p class="text-gray-600 text-sm mt-2">Kelola keuanganmu dengan mudah</p>
    </div>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded-md text-sm"><?= $error ?></div>
    <?php endif; ?>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Username</label>
      <input type="text" name="username" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Password</label>
      <input type="password" name="password" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
    </div>

    <button type="submit" class="w-full py-3 bg-yellow-400 text-pink-800 font-semibold rounded-lg hover:bg-yellow-500 transition">Login</button>

    <p class="text-center text-sm text-gray-600">
      Belum punya akun? 
      <a href="account_sign_up.php" class="text-pink-500 hover:underline font-medium">Sign Up</a>
    </p>
  </form>

</body>
</html>
