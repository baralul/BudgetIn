<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT id FROM target_tabungan WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Target tidak ditemukan atau Anda tidak memiliki akses'); window.location.href='../tables/target_tabungan.php';</script>";
    exit;
}

$delete_stmt = $conn->prepare("DELETE FROM target_tabungan WHERE id = ? AND user_id = ?");
$delete_stmt->bind_param("ii", $id, $user_id);

if ($delete_stmt->execute()) {
    echo "<script>alert('Target berhasil dihapus'); window.location.href='../tables/target_tabungan.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus target'); window.location.href='../tables/target_tabungan.php';</script>";
}

$stmt->close();
$delete_stmt->close();
?> 