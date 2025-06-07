<?php
session_start();
include '../../config/koneksi.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../forms/account_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil total pemasukan
$pemasukan_q = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pemasukan WHERE user_id = $user_id");
$total_pemasukan = mysqli_fetch_assoc($pemasukan_q)['total'] ?? 0;

// Ambil total pengeluaran
$pengeluaran_q = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pengeluaran WHERE user_id = $user_id");
$total_pengeluaran = mysqli_fetch_assoc($pengeluaran_q)['total'] ?? 0;

// Hitung saldo
$saldo = $total_pemasukan - $total_pengeluaran;

// Ambil 5 transaksi terakhir
$riwayat_q = mysqli_query($conn, "
    SELECT r.*, k.nama_kategori 
    FROM riwayat_transaksi r
    JOIN kategori k ON r.kategori_id = k.id
    WHERE r.user_id = $user_id
    ORDER BY r.tanggal DESC, r.id DESC
    LIMIT 5
");

// Ambil data bulanan untuk grafik
$pengeluaran_bulanan = [];
$pemasukan_bulanan = [];

for ($i = 1; $i <= 12; $i++) {
    $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);

    $q1 = mysqli_query($conn, "
        SELECT SUM(jumlah) AS total 
        FROM pengeluaran 
        WHERE user_id = $user_id AND MONTH(tanggal) = $i
    ");
    $pengeluaran_bulanan[] = (int)(mysqli_fetch_assoc($q1)['total'] ?? 0);

    $q2 = mysqli_query($conn, "
        SELECT SUM(jumlah) AS total 
        FROM pemasukan 
        WHERE user_id = $user_id AND MONTH(tanggal) = $i
    ");
    $pemasukan_bulanan[] = (int)(mysqli_fetch_assoc($q2)['total'] ?? 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Riwayat - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-white text-gray-800 overflow-x-hidden">
  <div class="flex min-h-screen">

    <?php include '../../components/sidebar.php'; ?>

    <div class="flex-1 flex flex-col overflow-hidden">
      <?php include '../../components/header.php'; ?>

      <main class="p-6 bg-yellow-50 flex-1 space-y-6 overflow-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-yellow-600 mb-2">Total Pemasukan</h2>
            <p class="text-2xl font-bold text-green-600">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
          </div>
          <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-yellow-600 mb-2">Total Pengeluaran</h2>
            <p class="text-2xl font-bold text-red-500">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
          </div>
          <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-yellow-600 mb-2">Saldo Akhir</h2>
            <p class="text-2xl font-bold text-gray-800">Rp <?= number_format($saldo, 0, ',', '.') ?></p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white rounded-xl shadow p-6 h-[300px]">
            <h2 class="text-lg font-semibold text-yellow-600 mb-4">Grafik Pengeluaran Bulanan</h2>
            <canvas id="expenseChart"></canvas>
          </div>
          <div class="bg-white rounded-xl shadow p-6 h-[300px]">
            <h2 class="text-lg font-semibold text-yellow-600 mb-4">Grafik Pemasukan Bulanan</h2>
            <canvas id="incomeChart"></canvas>
          </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold text-yellow-600 mb-4">Transaksi Terbaru</h2>
          <table class="w-full text-left">
            <thead>
              <tr class="text-gray-700 border-b">
                <th class="py-2">Tanggal</th>
                <th class="py-2">Kategori</th>
                <th class="py-2">Keterangan</th>
                <th class="py-2">Jumlah</th>
                <th class="py-2">Tipe</th>
              </tr>
            </thead>
            <tbody class="text-gray-600">
              <?php while ($row = mysqli_fetch_assoc($riwayat_q)): ?>
              <tr class="border-b">
                <td class="py-2"><?= htmlspecialchars($row['tanggal']) ?></td>
                <td class="py-2"><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td class="py-2"><?= htmlspecialchars($row['keterangan']) ?: '-' ?></td>
                <td class="py-2">
                  Rp <?= number_format($row['jumlah'], 0, ',', '.') ?>
                </td>
                <td class="py-2 capitalize text-<?= $row['tipe'] == 'pemasukan' ? 'green' : 'red' ?>-600">
                  <?= $row['tipe'] ?>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

  <script>
    const pengeluaranData = <?= json_encode($pengeluaran_bulanan) ?>;
    const pemasukanData = <?= json_encode($pemasukan_bulanan) ?>;
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const chartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      scales: { y: { beginAtZero: true } }
    };

    new Chart(document.getElementById('expenseChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels,
        datasets: [{
          label: 'Pengeluaran',
          data: pengeluaranData,
          backgroundColor: 'rgba(255, 99, 132, 0.6)',
          borderRadius: 6
        }]
      },
      options: chartOptions
    });

    new Chart(document.getElementById('incomeChart').getContext('2d'), {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Pemasukan',
          data: pemasukanData,
          borderColor: 'rgba(255, 205, 86, 1)',
          backgroundColor: 'rgba(255, 205, 86, 0.2)',
          tension: 0.4,
          fill: true
        }]
      },
      options: chartOptions
    });
  </script>
</body>
</html>
