<?php
include '../../config/koneksi.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['delete'])) {
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id");
    session_destroy();
    echo "<script>alert('Akun berhasil dihapus');window.location.href='../../index.php';</script>";
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
