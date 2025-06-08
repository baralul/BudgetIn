<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../forms/account_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT nama_lengkap, username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $nama_lengkap = $user['nama_lengkap'];
    $username = $user['username'];
} else {
    header("Location: ../forms/account_login.php");
    exit;
}

$success = '';
$error = '';
if (isset($_POST['update_profile'])) {
    $new_nama = trim($_POST['nama_lengkap']);
    if ($new_nama !== '') {
        $update = $conn->prepare("UPDATE users SET nama_lengkap = ? WHERE id = ?");
        $update->bind_param("si", $new_nama, $user_id);
        if ($update->execute()) {
            $nama_lengkap = $new_nama;
            $_SESSION['nama_lengkap'] = $new_nama;
            $success = "Profil berhasil diperbarui!";
        } else {
            $error = "Gagal memperbarui profil.";
        }
    } else {
        $error = "Nama lengkap tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Profile - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>
<body class="bg-pink-50 min-h-screen">
  <div class="flex">

    <?php include '../../components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col">
      <?php include '../../components/header.php'; ?>

      <main class="flex-1 p-6">

        <div class="mb-8">
          <h1 class="text-3xl font-bold text-pink-700 mb-2">Profil Anda</h1>
          <p class="text-pink-600">Kelola informasi akun dan pengaturan Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8 w-full min-h-[calc(100vh-10rem)] flex flex-col justify-between">

          <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-8 py-6 rounded-lg mb-8">
            <div class="flex items-center space-x-4">
              <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center">
                <i class="fas fa-user text-pink-500 text-2xl"></i>
              </div>
              <div>
                <h2 class="text-2xl font-bold text-white">Selamat datang!</h2>
                <p class="text-pink-100">Kelola profil Anda dengan mudah</p>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-grow">

            <div>
              <div class="flex items-center mb-4">
                <i class="fas fa-user-circle text-pink-500 text-xl mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-800">Informasi Pengguna</h3>
              </div>

              <?php if ($error): ?>
                <div class="mb-4 p-2 bg-red-100 text-red-700 rounded"><?= htmlspecialchars($error) ?></div>
              <?php elseif ($success): ?>
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded"><?= htmlspecialchars($success) ?></div>
              <?php endif; ?>

              <div class="bg-pink-50 rounded-lg p-4 border-l-4 border-pink-300">
                <div class="flex justify-between items-center">
                  <div>
                    <p class="text-sm font-medium text-gray-600 mb-1">Nama Lengkap</p>
                    <p class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($nama_lengkap) ?></p>
                  </div>
                  <i class="fas fa-id-card text-pink-400 text-2xl"></i>
                </div>

                <button
                  onclick="document.getElementById('editForm').classList.toggle('hidden')"
                  class="mt-4 px-4 py-2 bg-pink-500 text-white rounded hover:bg-pink-600 transition"
                >
                  Edit Nama Lengkap
                </button>

                <form id="editForm" method="POST" class="hidden mt-4">
                  <input
                    type="text"
                    name="nama_lengkap"
                    value="<?= htmlspecialchars($nama_lengkap) ?>"
                    required
                    class="w-full px-3 py-2 border border-pink-300 rounded mb-2 focus:outline-none focus:ring-2 focus:ring-pink-400"
                  />
                  <button
                    type="submit"
                    name="update_profile"
                    class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition"
                  >
                    Simpan
                  </button>
                </form>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex items-center mb-4">
                <i class="fas fa-cogs text-pink-500 text-xl mr-3"></i>
                <h3 class="text-lg font-semibold text-gray-800">Pengaturan Akun</h3>
              </div>

              <a href="../forms/account_change_password.php" 
                 class="group flex items-center justify-between w-full bg-gradient-to-r from-yellow-300 to-yellow-400 hover:from-yellow-400 hover:to-yellow-500 text-yellow-900 p-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                <div class="flex items-center">
                  <i class="fas fa-lock text-yellow-700 text-lg mr-3"></i>
                  <div>
                    <p class="font-semibold">Ganti Password</p>
                    <p class="text-sm text-yellow-700 opacity-80">Perbarui kata sandi Anda</p>
                  </div>
                </div>
                <i class="fas fa-chevron-right text-yellow-700 group-hover:translate-x-1 transition-transform"></i>
              </a>

              <a href="../../logout.php" 
                 class="group flex items-center justify-between w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white p-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                <div class="flex items-center">
                  <i class="fas fa-sign-out-alt text-white text-lg mr-3"></i>
                  <div>
                    <p class="font-semibold">Logout</p>
                    <p class="text-sm text-pink-100 opacity-80">Keluar dari akun Anda</p>
                  </div>
                </div>
                <i class="fas fa-chevron-right text-white group-hover:translate-x-1 transition-transform"></i>
              </a>

              <a href="../forms/account_delete.php" 
                 class="group flex items-center justify-between w-full bg-gradient-to-r from-red-100 to-red-200 hover:from-red-200 hover:to-red-300 text-red-700 p-4 rounded-lg transition-all duration-200 transform hover:scale-[1.02] shadow-md hover:shadow-lg border border-red-200">
                <div class="flex items-center">
                  <i class="fas fa-trash-alt text-red-600 text-lg mr-3"></i>
                  <div>
                    <p class="font-semibold">Hapus Akun</p>
                    <p class="text-sm text-red-600 opacity-80">Hapus akun secara permanen</p>
                  </div>
                </div>
                <i class="fas fa-chevron-right text-red-600 group-hover:translate-x-1 transition-transform"></i>
              </a>
            </div>
          </div>

          <div class="mt-10 pt-6 border-t border-gray-100 text-sm text-gray-500 flex items-center">
            <i class="fas fa-info-circle mr-2"></i>
            <p>Perubahan yang Anda buat akan tersimpan secara otomatis</p>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
