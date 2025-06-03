<?php
require_once '../../config/koneksi.php'; // adjust path if needed

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) {
        $error = "Konfirmasi password tidak cocok.";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $hashed);

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
  <meta charset="UTF-8">
  <title>Sign Up - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

  <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Sign Up</h2>

    <?php if ($error): ?>
      <p class="mb-4 text-red-600"><?= $error ?></p>
    <?php elseif ($success): ?>
      <p class="mb-4 text-green-600"><?= $success ?></p>
    <?php endif; ?>

    <label class="block mb-2 text-sm">Username</label>
    <input type="text" name="username" required class="w-full px-3 py-2 border rounded mb-4">

    <label class="block mb-2 text-sm">Password</label>
    <input type="password" name="password" required class="w-full px-3 py-2 border rounded mb-4">

    <label class="block mb-2 text-sm">Konfirmasi Password</label>
    <input type="password" name="confirm" required class="w-full px-3 py-2 border rounded mb-6">

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Sign Up</button>
    <p class="text-center text-sm mt-4">Sudah punya akun? <a href="account_login.php" class="text-blue-600 hover:underline">Login</a></p>
  </form>

</body>
</html>
