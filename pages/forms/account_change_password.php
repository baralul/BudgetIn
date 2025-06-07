<?php
include '../../config/koneksi.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET password='$password' WHERE id=$user_id");
    echo "<script>alert('Password berhasil diubah');window.location.href='../tables/profile.php';</script>";
}
?>

<style>
    body { background: #fff0f5; font-family: sans-serif; }
    form { background: #fff; padding: 20px; max-width: 400px; margin: auto; border: 2px solid #ffc0cb; border-radius: 8px; }
    input, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ffd700; }
    button { background-color: #ff69b4; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Ganti Password</h2>
    <input type="password" name="password" placeholder="Password baru" required>
    <button type="submit" name="submit">Ubah Password</button>
</form>
