<?php
include '../../config/koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM kategori WHERE id=$id"));

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_kategori'];
    $jenis = $_POST['jenis'];
    mysqli_query($conn, "UPDATE kategori SET nama_kategori='$nama', jenis='$jenis' WHERE id=$id");
    echo "<script>alert('Kategori berhasil diubah');window.location.href='../tables/kategori.php';</script>";
}
?>

<style>
    body { background: #fffaf0; font-family: sans-serif; }
    form { background: #fff; padding: 20px; max-width: 400px; margin: auto; border: 2px solid #ffb6c1; border-radius: 8px; }
    input, select, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ffd700; }
    button { background-color: #ffa07a; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Edit Kategori</h2>
    <input type="text" name="nama_kategori" value="<?= $data['nama_kategori'] ?>" required>
    <select name="jenis" required>
        <option value="pemasukan" <?= $data['jenis'] == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
        <option value="pengeluaran" <?= $data['jenis'] == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
    </select>
    <button type="submit" name="submit">Simpan Perubahan</button>
</form>
