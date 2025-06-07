<?php
include '../../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_kategori'];
    $jenis = $_POST['jenis'];
    mysqli_query($conn, "INSERT INTO kategori (nama_kategori, jenis) VALUES ('$nama', '$jenis')");
    echo "<script>alert('Kategori berhasil ditambahkan');window.location.href='../tables/kategori.php';</script>";
}
?>

<style>
    body { background: #fffaf0; font-family: sans-serif; }
    form { background: white; padding: 20px; border: 2px solid #ffc0cb; border-radius: 8px; max-width: 400px; margin: auto; }
    input, select, button {
        width: 100%; padding: 10px; margin: 10px 0;
        border-radius: 5px; border: 1px solid #ffd700;
    }
    button { background-color: #ff69b4; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Tambah Kategori</h2>
    <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>
    <select name="jenis" required>
        <option value="">-- Pilih Jenis --</option>
        <option value="pemasukan">Pemasukan</option>
        <option value="pengeluaran">Pengeluaran</option>
    </select>
    <button type="submit" name="submit">Simpan</button>
</form>
