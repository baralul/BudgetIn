<?php
session_start();
require_once '../../config/koneksi.php'; // adjust path if needed

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
            header("Location: ../tables/riwayat.php");
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
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

  <form method="POST" class="bg-white p-8 rounded shadow-md w-full max-w-sm">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    <?php if ($error): ?>
      <p class="mb-4 text-red-600"><?= $error ?></p>
    <?php endif; ?>

    <label class="block mb-2 text-sm">Username</label>
    <input type="text" name="username" required class="w-full px-3 py-2 border rounded mb-4">

    <label class="block mb-2 text-sm">Password</label>
    <input type="password" name="password" required class="w-full px-3 py-2 border rounded mb-6">

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    <p class="text-center text-sm mt-4">Belum punya akun? <a href="account_sign_up.php" class="text-blue-600 hover:underline">Sign Up</a></p>
  </form>

</body>
</html>
