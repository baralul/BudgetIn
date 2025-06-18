<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['delete'])) {
    $queries = [
        "DELETE FROM pemasukan WHERE user_id = ?",
        "DELETE FROM pengeluaran WHERE user_id = ?",
        "DELETE FROM users WHERE id = ?"
    ];

    $success = true;
    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $success = false;
            break;
        }
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) {
            $success = false;
            break;
        }
        $stmt->close();
    }

    if ($success) {
        session_unset();
        session_destroy();
        echo "<script>alert('Akun berhasil dihapus'); window.location.href='../../index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus akun'); window.location.href='../tables/profile.php';</script>";
    }
    exit;
}
?>

<style>
    body { background: #fff0f5; font-family: sans-serif; }
    form { background: #fff; padding: 20px; max-width: 400px; margin: auto; border: 2px solid #ffc0cb; border-radius: 8px; }
    button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ffd700; background-color: #ff4500; color: white; font-weight: bold; }
    .warning { color: #ff4500; font-weight: bold; margin: 10px 0; }
</style>

<form method="POST">
    <h2>Hapus Akun</h2>
    <p>Apakah kamu yakin ingin menghapus akun ini?</p>
    <p class="warning">Perhatian: Tindakan ini tidak dapat dibatalkan!</p>
    <p class="warning">Semua data pemasukan, pengeluaran, dan riwayat akan dihapus.</p>
    <button type="submit" name="delete">Hapus Akun</button>
</form>
