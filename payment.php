<?php
require_once 'data.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['selected_meja'])) {
    header('Location: index.php');
    exit;
}

$ps_id = $_POST['ps_id'];
$ps = $ps_data[$ps_id];
$selected_meja_ids = $_POST['selected_meja'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran - RentaPS</title>
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
        <h2>Detail Pembayaran</h2>
        <form action="confirm.php" method="POST">
            <input type="hidden" name="ps_id" value="<?= $ps_id ?>">
            <input type="hidden" id="harga_per_jam" value="<?= $ps['harga'] ?>">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Form Data -->
                <div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Metode Pembayaran</label>
                        <label><input type="radio" name="metode" value="Tunai" checked> Tunai</label><br>
                        <label><input type="radio" name="metode" value="Transfer Bank"> Transfer Bank</label><br>
                        <label><input type="radio" name="metode" value="QRIS"> QRIS</label>
                    </div>
                </div>

                <!-- Pengaturan Durasi -->
                <div>
                    <h4>Meja yang dipilih (<?= $ps['nama'] ?>):</h4>
                    <?php foreach ($selected_meja_ids as $m_id):
                        $parts = explode('-', $m_id);
                        $no_meja = end($parts);
                    ?>
                        <div style="background: #1a1a2e; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid #3f37c9;">
                            <input type="hidden" name="meja_ids[]" value="<?= $m_id ?>">
                            <strong>Meja Nomor <?= $no_meja ?></strong>
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <div>
                                    <small>Jam Mulai</small>
                                    <input type="time" name="mulai[]" class="form-control time-start" required value="<?= date('H:i') ?>">
                                </div>
                                <div>
                                    <small>Durasi</small>
                                    <select name="durasi[]" class="form-control durasi-select">
                                        <?php for ($i = 1; $i <= 8; $i++) echo "<option value='$i'>$i Jam</option>"; ?>
                                    </select>
                                </div>
                            </div>
                            <div style="margin-top: 5px; font-size: 0.8rem; color: #4cc9f0;">
                                Selesai pada: <span class="time-end">--:--</span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div style="background: #3f37c9; padding: 20px; border-radius: 8px; margin-top: 20px;">
                        <h3 style="display: flex; justify-content: space-between;">
                            <span>Total Harga:</span>
                            <span id="display-total">Rp 0</span>
                        </h3>
                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 15px; background: #4cc9f0; color: #000;">Konfirmasi Pesanan</button>
                    </div>
                </div>
            </div>
        </form>
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