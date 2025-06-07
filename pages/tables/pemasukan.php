<?php
include '../../config/koneksi.php';
session_start();

$user_id = $_SESSION['user_id']; // pastikan user sudah login
$query = mysqli_query($conn, "
    SELECT p.*, k.nama_kategori 
    FROM pemasukan p
    JOIN kategori k ON p.kategori_id = k.id
    WHERE p.user_id = $user_id
    ORDER BY p.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Pemasukan - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
  <div class="flex">

    <?php include '../../components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col">
      <?php include '../../components/header.php'; ?>

      <main class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h1 class="text-2xl font-bold text-pink-700">Pemasukan</h1>
          <a href="../forms/tambah_pemasukan.php" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
            + Tambah Pemasukan
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-pink-200 text-pink-800">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Tanggal</th>
                <th class="px-4 py-2 text-left">Kategori</th>
                <th class="px-4 py-2 text-left">Jumlah</th>
                <th class="px-4 py-2 text-left">Keterangan</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
              <tr class="border-b hover:bg-pink-100">
                <td class="px-4 py-2"><?= $no++ ?></td>
                <td class="px-4 py-2"><?= $row['tanggal'] ?></td>
                <td class="px-4 py-2"><?= $row['nama_kategori'] ?></td>
                <td class="px-4 py-2 text-green-600 font-semibold">Rp<?= number_format($row['jumlah'], 2, ',', '.') ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($row['keterangan']) ?></td>
                <td class="px-4 py-2 space-x-2">
                  <a href="../forms/edit_pemasukan.php?id=<?= $row['id'] ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                  <a href="../forms/delete_pemasukan.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
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
