<?php
include '../../config/koneksi.php';
session_start();

$query = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kategori - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
  <div class="flex">

    <?php include '../../components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col">
      <?php include '../../components/header.php'; ?>

      <main class="p-6">
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-2xl font-bold text-pink-700">Kategori</h1>
          <a href="../forms/tambah_kategori.php" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
            + Tambah Kategori
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full bg-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-pink-200 text-pink-800">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Nama Kategori</th>
                <th class="px-4 py-2 text-left">Jenis</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; while ($data = mysqli_fetch_assoc($query)) { ?>
              <tr class="border-b hover:bg-pink-100">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($data['nama_kategori']) ?></td>
                <td class="px-4 py-2 capitalize"><?= htmlspecialchars($data['jenis']) ?></td>
                <td class="px-4 py-2 space-x-2">
                  <a href="../forms/edit_kategori.php?id=<?= $data['id'] ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                  <a href="../forms/delete_kategori.php?id=<?= $data['id'] ?>" 
                     onclick="return confirm('Yakin ingin menghapus?')"
                     class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
</body>
</html>
