<?php
include '../../config/koneksi.php';
session_start();
$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$pemasukan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pemasukan WHERE id=$id"));
$kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE jenis='pemasukan'");

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    mysqli_query($conn, "UPDATE pemasukan SET kategori_id='$kategori_id', jumlah='$jumlah', tanggal='$tanggal', keterangan='$keterangan' WHERE id=$id");
    echo "<script>alert('Data berhasil diubah');window.location.href='../tables/pemasukan.php';</script>";
}
?>

<style>
    body { background: #fffaf0; font-family: sans-serif; }
    form { background: #fff; padding: 20px; max-width: 400px; margin: auto; border: 2px solid #ffc0cb; border-radius: 8px; }
    input, textarea, select, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ffd700; }
    button { background-color: #ff69b4; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Edit Pemasukan</h2>
    <select name="kategori" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
            <option value="<?= $k['id'] ?>" <?= $pemasukan['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php } ?>
    </select>
    <input type="number" name="jumlah" value="<?= $pemasukan['jumlah'] ?>" required>
    <input type="date" name="tanggal" value="<?= $pemasukan['tanggal'] ?>" required>
    <textarea name="keterangan"><?= $pemasukan['keterangan'] ?></textarea>
    <button type="submit" name="submit">Simpan</button>
</form>
