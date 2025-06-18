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
    <!-- Hanya Sidebar -->
    <aside id="sidebar" class="w-64 bg-white h-screen p-4 space-y-2">
        <nav class="flex flex-col space-y-2">
            <a href="riwayat.php" class="text-gray-800 hover:bg-yellow-200 p-2 rounded flex items-center space-x-3">
                <i class="fas fa-history text-gray-600"></i>
                <span>Riwayat</span>
            </a>
            <a href="kategori.php" class="text-gray-800 hover:bg-yellow-200 p-2 rounded flex items-center space-x-3">
                <i class="fas fa-tags text-gray-600"></i>
                <span>Kategori</span>
            </a>
            <a href="pemasukan.php" class="text-gray-800 hover:bg-yellow-200 p-2 rounded flex items-center space-x-3">
                <i class="fas fa-arrow-up text-green-600"></i>
                <span>Pemasukan</span>
            </a>
            <a href="pengeluaran.php" class="text-gray-800 hover:bg-yellow-200 p-2 rounded flex items-center space-x-3">
                <i class="fas fa-arrow-down text-red-600"></i>
                <span>Pengeluaran</span>
            </a>
        </nav>
    </aside>

</body>
</html>
