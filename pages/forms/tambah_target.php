<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $nama_target = $_POST['nama_target'];
    $target_jumlah = $_POST['target_jumlah'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_target = $_POST['tanggal_target'];
    $keterangan = $_POST['keterangan'];

    $stmt = $conn->prepare("INSERT INTO target_tabungan (user_id, nama_target, target_jumlah, tanggal_mulai, tanggal_target, keterangan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdsss", $user_id, $nama_target, $target_jumlah, $tanggal_mulai, $tanggal_target, $keterangan);

    if ($stmt->execute()) {
        echo "<script>alert('Target tabungan berhasil ditambahkan'); window.location.href='../tables/target_tabungan.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan target tabungan');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Target Tabungan - BudgetIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
    <div class="flex">
        <?php include '../../components/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <?php include '../../components/header.php'; ?>

            <main class="p-6">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-2xl font-bold text-pink-700 mb-6">Tambah Target Tabungan</h1>

                    <form method="POST" class="bg-white rounded-lg shadow-md p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_target">
                                Nama Target
                            </label>
                            <input type="text" name="nama_target" id="nama_target" required
                                class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                placeholder="Contoh: Tabungan Liburan">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="target_jumlah">
                                Target Jumlah (Rp)
                            </label>
                            <input type="number" name="target_jumlah" id="target_jumlah" required min="0"
                                class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                placeholder="Contoh: 5000000">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal_mulai">
                                    Tanggal Mulai
                                </label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                                    class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                    value="<?= date('Y-m-d') ?>">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal_target">
                                    Tanggal Target
                                </label>
                                <input type="date" name="tanggal_target" id="tanggal_target" required
                                    class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                    min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="keterangan">
                                Keterangan (Opsional)
                            </label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                placeholder="Tambahkan catatan tentang target tabungan ini"></textarea>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="../tables/target_tabungan.php"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit" name="submit"
                                class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                                Simpan Target
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 