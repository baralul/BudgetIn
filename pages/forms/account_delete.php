<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['delete'])) {
    $conn->query("DELETE FROM pemasukan WHERE user_id = $user_id");
    $conn->query("DELETE FROM pengeluaran WHERE user_id = $user_id");
    $conn->query("DELETE FROM riwayat WHERE user_id = $user_id");
    if ($conn->query("DELETE FROM users WHERE id = $user_id")) {
        session_destroy();
        echo "<script>alert('Akun berhasil dihapus'); window.location.href='../../index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus akun: {$conn->error}');</script>";
    }
}
?>


<style>
    body { background: #fff0f5; font-family: sans-serif; }
    form { background: #fff; padding: 20px; max-width: 400px; margin: auto; border: 2px solid #ffc0cb; border-radius: 8px; }
    button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ffd700; background-color: #ff4500; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Hapus Akun</h2>
    <p>Apakah kamu yakin ingin menghapus akun ini?</p>
    <button type="submit" name="delete">Hapus Akun</button>
</form>
