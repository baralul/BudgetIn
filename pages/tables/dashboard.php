<?php
session_start();
include '../../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../forms/account_login.php");
  exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kategori"))['total'] ?? 0;
$jumlah_riwayat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM riwayat_transaksi WHERE user_id = $user_id"))['total'] ?? 0;
$total_pemasukan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pemasukan WHERE user_id = $user_id"))['total'] ?? 0;
$total_pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pengeluaran WHERE user_id = $user_id"))['total'] ?? 0;

$pemasukan_bulanan = [];
$pengeluaran_bulanan = [];
for ($i = 1; $i <= 12; $i++) {
  $pemasukan_q = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pemasukan WHERE user_id = $user_id AND MONTH(tanggal) = $i");
  $pemasukan_bulanan[] = (int)(mysqli_fetch_assoc($pemasukan_q)['total'] ?? 0);
  $pengeluaran_q = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pengeluaran WHERE user_id = $user_id AND MONTH(tanggal) = $i");
  $pengeluaran_bulanan[] = (int)(mysqli_fetch_assoc($pengeluaran_q)['total'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - BudgetIn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://kit.fontawesome.com/your_kit_code.js" crossorigin="anonymous"></script>
</head>
<body class="bg-yellow-50 text-gray-800 overflow-x-hidden">
  <div class="flex min-h-screen">
    <?php include '../../components/sidebar.php'; ?>
    <div class="flex-1 flex flex-col overflow-hidden">
      <?php include '../../components/header.php'; ?>

      <main class="p-6 space-y-6 overflow-auto">
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-gray-700">Welcome Back, <?= htmlspecialchars($username) ?> 👋</h1>
          <p class="text-sm font-bold text-gray-500 mt-1">Dashboard</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
          <div class="bg-white rounded-2xl shadow p-8 col-span-1 text-center">
            <h2 class="text-xl font-semibold text-yellow-600 mb-3">Kalender Bulan Ini</h2>
            <p id="calendar-title" class="text-base font-medium text-gray-600 mb-4"></p>
            <div id="calendar" class="grid grid-cols-7 gap-2 text-center text-sm font-semibold text-gray-700">
              <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
            </div>
            <div id="dates" class="grid grid-cols-7 gap-2 text-center mt-3 text-base"></div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 col-span-3">
            <div onclick="showModal('kategori')" class="cursor-pointer bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition text-center space-y-2">
              <div class="flex justify-center items-center text-indigo-600 text-3xl">
                <i class="fas fa-tags"></i>
              </div>
              <h2 class="text-xl font-semibold text-yellow-600">Kategori</h2>
              <p class="text-3xl font-bold"><?= $jumlah_kategori ?></p>
              <p class="text-sm text-gray-500">Total kategori yang tersedia</p>
            </div>

            <div onclick="showModal('riwayat')" class="cursor-pointer bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition text-center space-y-2">
              <div class="flex justify-center items-center text-blue-600 text-3xl">
                <i class="fas fa-history"></i>
              </div>
              <h2 class="text-xl font-semibold text-yellow-600">Riwayat</h2>
              <p class="text-3xl font-bold"><?= $jumlah_riwayat ?></p>
              <p class="text-sm text-gray-500">Total transaksi yang telah dicatat</p>
            </div>

            <div onclick="showModal('pemasukan')" class="cursor-pointer bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition text-center space-y-2">
              <div class="flex justify-center items-center text-green-500 text-3xl">
                <i class="fas fa-arrow-up"></i>
              </div>
              <h2 class="text-xl font-semibold text-green-600">Pemasukan</h2>
              <p class="text-2xl font-bold text-green-600">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></p>
              <p class="text-sm text-gray-500">Total pemasukan sejauh ini</p>
            </div>

            <div onclick="showModal('pengeluaran')" class="cursor-pointer bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition text-center space-y-2">
              <div class="flex justify-center items-center text-red-500 text-3xl">
                <i class="fas fa-arrow-down"></i>
              </div>
              <h2 class="text-xl font-semibold text-red-500">Pengeluaran</h2>
              <p class="text-2xl font-bold text-red-500">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></p>
              <p class="text-sm text-gray-500">Total pengeluaran sejauh ini</p>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-2xl">
      <h2 id="modal-title" class="text-2xl font-bold text-yellow-600 mb-4 text-center"></h2>
      <div id="modal-content" class="text-gray-700 text-base"></div>
      <div class="text-center mt-6">
        <button onclick="closeModal()" class="px-5 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
          Tutup
        </button>
      </div>
    </div>
  </div>

<script>
function showModal(type) {
  const modal = document.getElementById('modal');
  const title = document.getElementById('modal-title');
  const content = document.getElementById('modal-content');

  modal.classList.remove('hidden');

  if (type === 'pemasukan') {
    title.innerText = "Detail Pemasukan Bulanan";
    content.innerHTML = '<canvas id="modalChart" height="200"></canvas>';
    const ctx = document.getElementById('modalChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{ label: 'Pemasukan Bulanan', data: <?= json_encode($pemasukan_bulanan) ?>, backgroundColor: 'rgba(0,200,0,0.5)', borderRadius: 5 }]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
  } else if (type === 'pengeluaran') {
    title.innerText = "Detail Pengeluaran Bulanan";
    content.innerHTML = '<canvas id="modalChart" height="200"></canvas>';
    const ctx = document.getElementById('modalChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [{ label: 'Pengeluaran Bulanan', data: <?= json_encode($pengeluaran_bulanan) ?>, backgroundColor: 'rgba(255,0,0,0.5)', borderRadius: 5 }]
      },
      options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
  } else if (type === 'kategori') {
    title.innerText = "Kategori";
    content.innerHTML = `<p class="text-gray-700 leading-relaxed text-base">Halaman Kategori digunakan untuk mengelola jenis-jenis pengeluaran dan pemasukan. Pengguna dapat menambah, mengedit, dan menghapus kategori.</p>`;
  } else if (type === 'riwayat') {
    title.innerText = "Riwayat";
    content.innerHTML = `<p class="text-gray-700 leading-relaxed text-base">Halaman Riwayat digunakan untuk menampilkan ringkasan aktivitas keuangan pengguna, termasuk total pemasukan, pengeluaran, dan saldo akhir.<br><br>Selain itu, halaman ini menampilkan grafik pemasukan dan pengeluaran bulanan serta 5 transaksi terakhir untuk memudahkan pemantauan keuangan.</p>`;
  }
}

function closeModal() {
  document.getElementById('modal').classList.add('hidden');
}

const today = new Date();
const year = today.getFullYear();
const month = today.getMonth();
const firstDay = new Date(year, month, 1).getDay();
const daysInMonth = new Date(year, month + 1, 0).getDate();
const datesContainer = document.getElementById('dates');
const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
document.getElementById('calendar-title').innerText = monthNames[month] + ' ' + year;
for (let i = 0; i < firstDay; i++) datesContainer.innerHTML += `<div></div>`;
for (let d = 1; d <= daysInMonth; d++) {
  const isToday = d === today.getDate();
  datesContainer.innerHTML += `<div class="${isToday ? 'bg-yellow-500 text-white font-bold rounded-full' : 'text-gray-700'} py-1">${d}</div>`;
}
</script>
</body>
</html>
