<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Only</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <div class="w-64 bg-white min-h-screen shadow-lg">
        <nav class="mt-4">
            <a href="../tables/riwayat.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'riwayat.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-history w-6"></i>
                <span>Riwayat</span>
            </a>
            <a href="../tables/kategori.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'kategori.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-tags w-6"></i>
                <span>Kategori</span>
            </a>
            <a href="../tables/pemasukan.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'pemasukan.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-arrow-down w-6"></i>
                <span>Pemasukan</span>
            </a>
            <a href="../tables/pengeluaran.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'pengeluaran.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-arrow-up w-6"></i>
                <span>Pengeluaran</span>
            </a>
            <a href="../tables/target_tabungan.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'target_tabungan.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-piggy-bank w-6"></i>
                <span>Target Tabungan</span>
            </a>
            <a href="../tables/anggaran.php" class="flex items-center px-4 py-3 text-gray-700 hover:bg-pink-50 hover:text-pink-600 <?= $current_page == 'anggaran.php' ? 'bg-pink-50 text-pink-600' : '' ?>">
                <i class="fas fa-chart-pie w-6"></i>
                <span>Anggaran Bulanan</span>
            </a>
        </nav>
    </div>

</body>
</html>
