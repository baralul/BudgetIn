<?php
require_once '../../config/koneksi.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nama_lengkap, $username, $hashed);

        if ($stmt->execute()) {
            $success = "Akun berhasil dibuat. Silakan login.";
        } else {
            $error = "Gagal membuat akun. Username mungkin sudah digunakan.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign Up - BudgetIn</title>
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

  <form method="POST" class="bg-white/90 p-8 rounded-2xl shadow-2xl max-w-md w-full space-y-5 backdrop-blur-md">
    <div class="text-center">
      <h2 class="text-3xl font-extrabold text-pink-500">Sign Up</h2>
      <p class="text-gray-600 text-sm">Buat akun baru untuk mulai mengelola keuangan</p>
    </div>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded text-sm"><?= $error ?></div>
    <?php elseif ($success): ?>
      <div class="bg-green-100 text-green-700 px-4 py-2 rounded text-sm"><?= $success ?></div>
    <?php endif; ?>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" />
    </div>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Username</label>
      <input type="text" name="username" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" />
    </div>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Password</label>
      <input type="password" name="password" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" />
    </div>

    <div>
      <label class="block text-sm font-medium text-pink-600 mb-1">Konfirmasi Password</label>
      <input type="password" name="confirm" required class="w-full px-4 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400" />
    </div>

    <button type="submit" class="w-full py-3 bg-yellow-400 text-pink-800 font-semibold rounded-lg hover:bg-yellow-500 transition">Sign Up</button>

    <p class="text-center text-sm text-gray-600">
      Sudah punya akun?
      <a href="account_login.php" class="text-pink-500 hover:underline font-medium">Login</a>
    </p>
  </form>

</body>
</html>
