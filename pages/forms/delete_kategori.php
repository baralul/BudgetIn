<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("
    SELECT 
        (SELECT COUNT(*) FROM pemasukan WHERE kategori_id = ?) as pemasukan_count,
        (SELECT COUNT(*) FROM pengeluaran WHERE kategori_id = ?) as pengeluaran_count
");
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$result = $stmt->get_result();
$counts = $result->fetch_assoc();

if ($counts['pemasukan_count'] > 0 || $counts['pengeluaran_count'] > 0) {
    echo "<script>alert('Kategori tidak dapat dihapus karena masih digunakan dalam transaksi'); window.location.href='../tables/kategori.php';</script>";
    exit;
}

$delete_stmt = $conn->prepare("DELETE FROM kategori WHERE id = ?");
$delete_stmt->bind_param("i", $id);

if ($delete_stmt->execute()) {
    echo "<script>alert('Kategori berhasil dihapus'); window.location.href='../tables/kategori.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus kategori'); window.location.href='../tables/kategori.php';</script>";
}

$stmt->close();
$delete_stmt->close();
?> 