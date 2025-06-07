<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../forms/account_login.php");
    exit;
}

// Ambil data user dari session (bisa dikembangkan ambil dari database jika diperlukan)
$nama = $_SESSION['nama_lengkap'] ?? 'Pengguna';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
  <div class="flex">

    <?php include '../../components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col">
      <?php include '../../components/header.php'; ?>

      <main class="p-6">
        <h1 class="text-2xl font-bold text-pink-700 mb-4">Profil Anda</h1>

        <div class="bg-white p-6 rounded-lg shadow-md max-w-xl space-y-4">
          <div>
            <p class="text-lg font-semibold text-gray-800">Nama Lengkap:</p>
            <p class="text-gray-600"><?= htmlspecialchars($nama) ?></p>
          </div>

          <div class="space-y-3 pt-4">
            <a href="../forms/account_change_password.php" class="block w-full bg-yellow-300 text-yellow-900 text-center py-2 rounded hover:bg-yellow-400 font-medium">
              Ganti Password
            </a>

            <a href="../../logout.php" class="block w-full bg-pink-500 text-white text-center py-2 rounded hover:bg-pink-600 font-medium">
              Logout
            </a>

            <a href="../forms/account_delete.php" class="block w-full bg-red-200 text-red-700 text-center py-2 rounded hover:bg-red-300 font-medium">
              Hapus Akun
            </a>
          </div>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
