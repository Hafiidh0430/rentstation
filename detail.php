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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="nav">
            <a href="index.php" class="logo">
                <img class='img-logo' src="assets/Logo.jpg" width="56" height="56" alt="RentStation">
            </a>
            <div class="menu">
                <a href="index.php">Kategori PS</a>
                <a href="history.php">Riwayat Pesanan</a>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- SECTION A: PILIH MEJA -->
        <section style="margin-bottom: 50px;">
            <h2>Pilih Meja <?= $ps['nama'] ?></h2>
            <form action="payment.php" method="POST" id="formMeja">
                <input type="hidden" name="ps_id" value="<?= $id ?>">
                <div class="meja-grid">
                    <?php foreach ($meja_list as $meja): ?>
                        <label class="meja-item">
                            <input type="checkbox" name="selected_meja[]" value="<?= $meja['id_meja'] ?>"
                                <?= ($meja['status'] == 'booked') ? 'disabled' : '' ?>
                                class="meja-check">
                            <div class="meja-box <?= $meja['status'] ?>">
                                <div style="font-size: 1.5rem;">🎮</div>
                                <div>Meja <?= $meja['nomor_meja'] ?></div>
                                <small><?= ($meja['status'] == 'booked') ? 'Penuh' : 'Tersedia' ?></small>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
                <button type="submit" id="btnLanjut" class="btn btn-primary" disabled>Lanjut ke Pembayaran</button>
            </form>
        </section>

        <hr style="border: 0; border-top: 1px solid #2d2d44; margin: 40px 0;">

        <!-- SECTION B: INFO PS -->
        <section style="margin-bottom: 50px;">
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 300px;">
                    <h2>Informasi Konsol</h2>
                    <p style="margin: 15px 0;"><?= $ps['deskripsi'] ?></p>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr style="border-bottom: 1px solid #2d2d44;">
                            <td style="padding: 8px 0;">Spesifikasi</td>
                            <td>: <?= $ps['spek'] ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;">Harga</td>
                            <td class="ps-price">: Rp <?= number_format($ps['harga'], 0, ',', '.') ?> / jam</td>
                        </tr>
                    </table>
                </div>
                <div style="flex: 1; min-width: 300px;">
                    <!-- SECTION C: GALERI -->
                    <h2>Galeri Foto</h2>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 15px;">
                        <?php foreach ($ps['foto'] as $index => $foto): ?>
                            <img src="https://picsum.photos/seed/<?= $foto ?>/300/200" style="width: 100%; border-radius: 8px;" alt="Foto">
                        <?php endforeach; ?>
                    </div>
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

    <script src="script.js"></script>
</body>

</html>