<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$query = mysqli_query($conn, "
    SELECT a.*, k.nama_kategori, k.jenis,
           COALESCE(SUM(CASE 
               WHEN k.jenis = 'pengeluaran' THEN p.jumlah 
               ELSE 0 
           END), 0) as total_pengeluaran
    FROM anggaran_bulanan a
    JOIN kategori k ON a.kategori_id = k.id
    LEFT JOIN pengeluaran p ON p.kategori_id = k.id 
        AND p.user_id = a.user_id 
        AND MONTH(p.tanggal) = a.bulan 
        AND YEAR(p.tanggal) = a.tahun
    WHERE a.user_id = $user_id 
    AND a.bulan = $bulan 
    AND a.tahun = $tahun
    GROUP BY a.id, k.nama_kategori, k.jenis
    ORDER BY k.jenis, k.nama_kategori
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Anggaran Bulanan - BudgetIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
    <div class="flex">
        <?php include '../../components/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <?php include '../../components/header.php'; ?>

            <main class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-pink-700">Anggaran Bulanan</h1>
                    <a href="../forms/tambah_anggaran.php" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                        + Tambah Anggaran
                    </a>
                </div>

                <div class="mb-4">
                    <form method="GET" class="flex gap-2">
                        <select name="bulan" class="border rounded px-3 py-2">
                            <?php
                            $bulan_list = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            foreach ($bulan_list as $num => $name) {
                                $selected = $num == $bulan ? 'selected' : '';
                                echo "<option value='$num' $selected>$name</option>";
                            }
                            ?>
                        </select>
                        <select name="tahun" class="border rounded px-3 py-2">
                            <?php
                            $tahun_sekarang = date('Y');
                            for ($i = $tahun_sekarang - 1; $i <= $tahun_sekarang + 1; $i++) {
                                $selected = $i == $tahun ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Filter
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full">
                        <thead class="bg-pink-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Kategori</th>
                                <th class="px-4 py-2 text-left">Jenis</th>
                                <th class="px-4 py-2 text-right">Anggaran</th>
                                <th class="px-4 py-2 text-right">Terpakai</th>
                                <th class="px-4 py-2 text-right">Sisa</th>
                                <th class="px-4 py-2 text-center">Progress</th>
                                <th class="px-4 py-2 text-center">Status</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($query)) { 
                                $sisa = $row['jumlah_anggaran'] - $row['total_pengeluaran'];
                                $progress = ($row['total_pengeluaran'] / $row['jumlah_anggaran']) * 100;
                                $progress = min($progress, 100);
                                $progress_color = $progress > 90 ? 'bg-red-500' : 
                                                ($progress > 70 ? 'bg-yellow-500' : 'bg-green-500');
                            ?>
                            <tr class="border-b hover:bg-pink-50">
                                <td class="px-4 py-2"><?= htmlspecialchars($row['nama_kategori']) ?></td>
                                <td class="px-4 py-2 capitalize"><?= $row['jenis'] ?></td>
                                <td class="px-4 py-2 text-right">Rp<?= number_format($row['jumlah_anggaran'], 0, ',', '.') ?></td>
                                <td class="px-4 py-2 text-right">Rp<?= number_format($row['total_pengeluaran'], 0, ',', '.') ?></td>
                                <td class="px-4 py-2 text-right">Rp<?= number_format($sisa, 0, ',', '.') ?></td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="<?= $progress_color ?> h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                                        </div>
                                        <span class="text-sm"><?= number_format($progress, 1) ?>%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">
                                    <?php if ($sisa < 0) { ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Melebihi Anggaran
                                        </span>
                                    <?php } else { ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Dalam Anggaran
                                        </span>
                                    <?php } ?>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="../forms/edit_anggaran.php?id=<?= $row['id'] ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                                    <a href="../forms/delete_anggaran.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
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