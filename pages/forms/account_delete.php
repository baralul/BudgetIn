<?php
include '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['delete'])) {
    // Prepared statement untuk keamanan
    $stmt1 = $conn->prepare("DELETE FROM pemasukan WHERE user_id = ?");
    $stmt2 = $conn->prepare("DELETE FROM pengeluaran WHERE user_id = ?");
    $stmt3 = $conn->prepare("DELETE FROM riwayat WHERE user_id = ?");
    $stmt4 = $conn->prepare("DELETE FROM users WHERE id = ?");

    if ($stmt1 && $stmt2 && $stmt3 && $stmt4) {
        $stmt1->bind_param('i', $user_id);
        $stmt2->bind_param('i', $user_id);
        $stmt3->bind_param('i', $user_id);
        $stmt4->bind_param('i', $user_id);

        $success = $stmt1->execute() && $stmt2->execute() && $stmt3->execute() && $stmt4->execute();

        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();

        if ($success) {
            session_unset();
            session_destroy();
            echo "<script>alert('Akun berhasil dihapus'); window.location.href='../../index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menghapus akun.');</script>";
        }
    } else {
        echo "<script>alert('Gagal menyiapkan query.');</script>";
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
