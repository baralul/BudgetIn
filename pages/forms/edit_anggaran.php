<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("
    SELECT a.*, k.nama_kategori 
    FROM anggaran_bulanan a
    JOIN kategori k ON a.kategori_id = k.id
    WHERE a.id = ? AND a.user_id = ?
");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Anggaran tidak ditemukan'); window.location.href='../tables/anggaran.php';</script>";
    exit;
}

$anggaran = $result->fetch_assoc();

$kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE jenis='pengeluaran' ORDER BY nama_kategori");

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori_id'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $jumlah_anggaran = $_POST['jumlah_anggaran'];

    $check_stmt = $conn->prepare("
        SELECT id FROM anggaran_bulanan 
        WHERE user_id = ? AND kategori_id = ? AND bulan = ? AND tahun = ? AND id != ?
    ");
    $check_stmt->bind_param("iiiii", $user_id, $kategori_id, $bulan, $tahun, $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Anggaran untuk kategori ini pada periode tersebut sudah ada');</script>";
    } else {
        $update_stmt = $conn->prepare("
            UPDATE anggaran_bulanan 
            SET kategori_id = ?, bulan = ?, tahun = ?, jumlah_anggaran = ?
            WHERE id = ? AND user_id = ?
        ");
        $update_stmt->bind_param("iiidii", $kategori_id, $bulan, $tahun, $jumlah_anggaran, $id, $user_id);

        if ($update_stmt->execute()) {
            echo "<script>alert('Anggaran berhasil diperbarui'); window.location.href='../tables/anggaran.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui anggaran');</script>";
        }
        $update_stmt->close();
    }
    $check_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggaran - BudgetIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-pink-50 min-h-screen">
    <div class="flex">
        <?php include '../../components/sidebar.php'; ?>

        <div class="flex-1 flex flex-col">
            <?php include '../../components/header.php'; ?>

            <main class="p-6">
                <div class="max-w-2xl mx-auto">
                    <h1 class="text-2xl font-bold text-pink-700 mb-6">Edit Anggaran Bulanan</h1>

                    <form method="POST" class="bg-white rounded-lg shadow-md p-6">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="kategori_id">
                                Kategori
                            </label>
                            <select name="kategori_id" id="kategori_id" required
                                class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
                                <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
                                    <option value="<?= $row['id'] ?>" <?= $anggaran['kategori_id'] == $row['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['nama_kategori']) ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="bulan">
                                    Bulan
                                </label>
                                <select name="bulan" id="bulan" required
                                    class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
                                    <?php
                                    $bulan_list = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    foreach ($bulan_list as $num => $name) {
                                        $selected = $num == $anggaran['bulan'] ? 'selected' : '';
                                        echo "<option value='$num' $selected>$name</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="tahun">
                                    Tahun
                                </label>
                                <select name="tahun" id="tahun" required
                                    class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400">
                                    <?php
                                    $tahun_sekarang = date('Y');
                                    for ($i = $tahun_sekarang - 1; $i <= $tahun_sekarang + 1; $i++) {
                                        $selected = $i == $anggaran['tahun'] ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="jumlah_anggaran">
                                Jumlah Anggaran (Rp)
                            </label>
                            <input type="number" name="jumlah_anggaran" id="jumlah_anggaran" required min="0"
                                class="w-full px-3 py-2 border border-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400"
                                value="<?= $anggaran['jumlah_anggaran'] ?>">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="../tables/anggaran.php"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Batal
                            </a>
                            <button type="submit" name="submit"
                                class="px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
</html> 