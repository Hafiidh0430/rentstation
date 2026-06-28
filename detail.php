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
            <h1>Pilih Meja yang Tersedia</h1>
            <form action="payment.php" method="POST" id="formMeja">
                <input type="hidden" name="ps_id" value="<?= $id ?>">
                <div class="denah-container">
                    <div class="kamar-mandi-kasir">
                        <span class="kamar-mandi">Kamar Mandi</span>
                        <span class="kasir">Kasir</span>
                        <span class="kamar-mandi">Kamar Mandi</span>
                    </div>
                    <div class="meja-container">
                        <div class="meja-grid">
                            <?php foreach ($meja_list as $meja): ?>
                                <?php if ($meja['nomor_meja'] <= 3): ?>
                                    <label class="meja-item">
                                        <input type="checkbox" name="selected_meja[]" value="<?= $meja['id_meja'] ?>"
                                            <?= ($meja['status'] == 'booked') ? 'disabled' : '' ?>
                                            class="meja-check">
                                        <div class="meja-box <?= $meja['status'] ?>">
                                            <span>Meja <?= $meja['nomor_meja'] ?></span>
                                            <span><?= ($meja['status'] == 'booked') ? 'Penuh' : 'Tersedia' ?></span>
                                        </div>
                                    </label>
                                <?php else: ?>
                                    <label class="meja-item">
                                        <input type="checkbox" name="selected_meja[]" value="<?= $meja['id_meja'] ?>"
                                            <?= ($meja['status'] == 'booked') ? 'disabled' : '' ?>
                                            class="meja-check">
                                        <div class="meja-box <?= $meja['status'] ?>">
                                            <span>Meja <?= $meja['nomor_meja'] ?></span>
                                            <span><?= ($meja['status'] == 'booked') ? 'Penuh' : 'Tersedia' ?></span>
                                        </div>
                                    </label>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="teras-pintu">
                        <span class="teras">Teras</span>
                        <span class="pintu"></span>
                        <span class="teras">Teras</span>
                    </div>
                </div>
                <div class="buttons">
                    <div class="info">
                        <div class="header">
                            <h1 class='ps-name'><?= $ps['nama'] ?></h1>
                            <h1 class='ps-price'>Rp. <?= number_format($ps['harga'], 0, '.') ?>/<small>Jam</small></h1>
                        </div>
                        <p class='description'><?= $ps['deskripsi'] ?></p>
                    </div>
                    <div class="booking">
                        <h1>Terpilih: <span id="jumlah-terpilih">0</span></h1>
                        <button type="submit" id="btnLanjut" class="btn btn-primary" disabled>Lanjut Booking</button>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script src="js/script.js"></script>
</body>

</html>