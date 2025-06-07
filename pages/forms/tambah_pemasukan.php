<?php
include '../../config/koneksi.php';
session_start();
$user_id = $_SESSION['user_id'];
$kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE jenis='pemasukan'");

if (isset($_POST['submit'])) {
    $kategori_id = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn, "INSERT INTO pemasukan (user_id, kategori_id, jumlah, tanggal, keterangan) 
                         VALUES ('$user_id', '$kategori_id', '$jumlah', '$tanggal', '$keterangan')");
    echo "<script>alert('Pemasukan berhasil ditambahkan');window.location.href='../tables/pemasukan.php';</script>";
}
?>

<style>
    body { background: #fff0f5; font-family: sans-serif; }
    form { background: white; padding: 20px; border: 2px solid #ffc0cb; border-radius: 8px; max-width: 450px; margin: auto; }
    input, select, textarea, button {
        width: 100%; padding: 10px; margin: 10px 0;
        border-radius: 5px; border: 1px solid #ffd700;
    }
    button { background-color: #ff69b4; color: white; font-weight: bold; }
</style>

<form method="POST">
    <h2>Tambah Pemasukan</h2>
    <select name="kategori" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while ($row = mysqli_fetch_assoc($kategori)) { ?>
            <option value="<?= $row['id'] ?>"><?= $row['nama_kategori'] ?></option>
        <?php } ?>
    </select>
    <input type="number" name="jumlah" placeholder="Jumlah" required>
    <input type="date" name="tanggal" required>
    <textarea name="keterangan" placeholder="Keterangan (opsional)"></textarea>
    <button type="submit" name="submit">Simpan</button>
</form>
