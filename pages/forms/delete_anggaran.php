<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM anggaran_bulanan WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);

if ($stmt->execute()) {
    echo "<script>alert('Anggaran berhasil dihapus'); window.location.href='../tables/anggaran.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus anggaran'); window.location.href='../tables/anggaran.php';</script>";
}
$stmt->close();
?> 