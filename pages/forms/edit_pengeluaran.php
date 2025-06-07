<?php
include '../../config/koneksi.php';
session_start();
$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pengeluaran WHERE id=$id"));
$kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE jenis='pengeluaran'");

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    
    mysqli_query($conn, "UPDATE pengeluaran SET kategori_id='$kategori_id', jumlah='$jumlah', tanggal='$tanggal', keterangan='$keterangan' WHERE id=$id");
    echo "<script>alert('Data berhasil diperbarui');window.location.href='../tables/pengeluaran.php';</script>";
}
?>

<style>
    body { background: #fff0f5; font-family: Arial, sans-serif; }
    form { background: white; padding: 20px; border: 2px solid #ffb6c1; border-radius: 10px; max-width: 450px; margin: auto; }
    input, select, textarea, button {
        width: 100%; padding: 10px; margin: 8px 0;
        border-radius: 5px; border: 1px solid #ffd700;
    }
    button {
        background-color: #ff69b4;
        color: white; font-weight: bold; cursor: pointer;
    }
</style>

<form method="POST">
    <h2>Edit Pengeluaran</h2>
    <select name="kategori" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
            <option value="<?= $k['id'] ?>" <?= $data['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php } ?>
    </select>
    <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required>
    <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>" required>
    <textarea name="keterangan"><?= $data['keterangan'] ?></textarea>
    <button type="submit" name="submit">Simpan Perubahan</button>
</form>
