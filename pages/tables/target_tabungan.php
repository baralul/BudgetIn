<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "
    SELECT * FROM target_tabungan 
    WHERE user_id = $user_id 
    ORDER BY tanggal_target ASC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Target Tabungan - BudgetIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
    <div class="flex">
        <?php include '../../components/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <?php include '../../components/header.php'; ?>

            <main class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-pink-700">Target Tabungan</h1>
                    <a href="../forms/tambah_target.php" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                        + Tambah Target
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php while ($row = mysqli_fetch_assoc($query)) { 
                        $progress = ($row['jumlah_terkumpul'] / $row['target_jumlah']) * 100;
                        $progress = min($progress, 100);
                        $status_color = $row['status'] == 'selesai' ? 'bg-green-500' : 
                                      ($row['status'] == 'batal' ? 'bg-red-500' : 'bg-blue-500');
                    ?>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-lg"><?= htmlspecialchars($row['nama_target']) ?></h3>
                            <span class="px-2 py-1 rounded text-white text-sm <?= $status_color ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </div>
                        
                        <div class="mb-2">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progress</span>
                                <span><?= number_format($progress, 1) ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-pink-500 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                            </div>
                        </div>

                        <div class="text-sm text-gray-600 mb-2">
                            <p>Target: Rp<?= number_format($row['target_jumlah'], 0, ',', '.') ?></p>
                            <p>Terkumpul: Rp<?= number_format($row['jumlah_terkumpul'], 0, ',', '.') ?></p>
                            <p>Target: <?= date('d M Y', strtotime($row['tanggal_target'])) ?></p>
                        </div>

                        <?php if ($row['keterangan']) { ?>
                            <p class="text-sm text-gray-500 mb-2"><?= htmlspecialchars($row['keterangan']) ?></p>
                        <?php } ?>

                        <div class="flex space-x-2 mt-3">
                            <a href="../forms/edit_target.php?id=<?= $row['id'] ?>" 
                               class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Edit
                            </a>
                            <a href="../forms/delete_target.php?id=<?= $row['id'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus target ini?')"
                               class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                Hapus
                            </a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 