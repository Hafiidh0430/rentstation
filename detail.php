<?php
require_once 'data.php';
$id = $_GET['id'] ?? 0;
if (!isset($ps_data[$id])) {
    header('Location: index.php');
    exit;
}
$ps = $ps_data[$id];
$meja_list = getMejaByPs($id);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail <?= $ps['nama'] ?> - RentaPS</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="nav">
            <a href="index.php" class="logo">
                <img class='img-logo' src="assets/Logo.jpg" width="56" height="56" alt="RentStation">
            </a>
            <div class="menu">
                <a href="index.php#kategori_ps">Kategori PS</a>
                <a href="history.php">Riwayat Pesanan</a>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="meja-content">
            <h1>Pilih Meja <?= $ps['nama'] ?></h1>
            <form action="payment.php" method="POST" id="formMeja">
                <input type="hidden" name="ps_id" value="<?= $id ?>">
                <div class="meja-grid">
                    <?php foreach ($meja_list as $meja): ?>
                        <label class="meja-item">
                            <input type="checkbox" name="selected_meja[]" value="<?= $meja['id_meja'] ?>"
                                <?= ($meja['status'] == 'booked') ? 'disabled' : '' ?>
                                class="meja-check">
                            <div class="meja-box <?= $meja['status'] ?>">
                                <span style="font-size: 1.5rem;">🎮</span>
                                <span>Meja <?= $meja['nomor_meja'] ?></span>
                                <span><?= ($meja['status'] == 'booked') ? 'Penuh' : 'Tersedia' ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <div class="buttons">
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                    <button type="submit" id="btnLanjut" class="btn btn-primary" disabled>Lanjut Isi Data</button>
                </div>
            </form>
        </section>

        <section class="ps-detail">
            <div class="ps-info-detail">
                <h1>Informasi Konsol</h1>
                <div class="content">
                    <p><?= $ps['deskripsi'] ?></p>
                    <p>Spesifikasi:</p>
                    <span><?= $ps['spek'] ?></span>
                    <p>Harga<span>: Rp <?= number_format($ps['harga'], 0, ',', '.') ?> / jam</span></p>
                </div>
            </div>
            <div class="ps-gallery">
                <h1>Galeri Foto</h1>
                <div class="gallery-photo">
                    <?php foreach ($ps['foto'] as $index => $foto): ?>
                        <img src="https://picsum.photos/seed/<?= $foto ?>/300/200" alt="Foto">
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <footer>
            <div class="header">
                <h1>Siap Main di RentStation <br> Tanpa Ngantri?</h1>
                <div class="buttons">
                    <a href="" class="btn btn-primary">Booking Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right-icon lucide-arrow-up-right">
                            <path d="M7 7h10v10" />
                            <path d="M7 17 17 7" />
                        </svg>
                    </a>
                    <a href="" class="btn btn-secondary">Hubungi Kami</a>
                </div>
            </div>
            <div class="content">
                <img class='img-logo' src="assets/RentStation.png" alt="RentStation">
                <div class="bottom">
                    <span class="copyright">© 2026 RentStation. All rights reserved.</span>
                    <div class="menu">
                        <a href="index.php">Kategori PS</a>
                        <a href="history.php">Riwayat Pesanan</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/script.js"></script>
</body>

</html>