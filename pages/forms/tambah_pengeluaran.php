<!-- pages/forms/tambah_pengeluaran.php -->
<?php
session_start();
include '../config/koneksi.php';
include '../components/header.php';
?>
<div class="d-flex">
  <?php include '../components/sidebar.php'; ?>
  
  <div class="p-4" style="width: 100%;">
    <h2>Tambah Pengeluaran</h2>
    <form action="../actions/proses_tambah_pengeluaran.php" method="POST">
      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select name="kategori" class="form-control" required>
          <option value="Makanan">Makanan</option>
          <option value="Transportasi">Transportasi</option>
          <!-- Tambahkan kategori lain -->
        </select>
      </div>
      <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah (Rp)</label>
        <input type="number" name="jumlah" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-success">Simpan</button>
    </form>
  </div>
</div>
