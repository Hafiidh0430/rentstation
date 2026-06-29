<?php require_once 'data.php'; ?>
<?php
$booking_terbaru = $_SESSION['booking_history'][0] ?? null;
$booking_success = $_SESSION['booking_success'] ?? false;
unset($_SESSION['booking_success']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - RentaPS</title>
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
    <section class="history-content">
        <?php if (!empty($_SESSION['booking_history'])): ?>
            <div class="header">
                <h1>Riwayat Pesanan</h1>
                <a href="data.php?clear_history=1" class="btn btn-secondary" style="background-color: red; color: #fff; border: none;" onclick="return confirm('Hapus semua riwayat?')">Hapus Semua</a>
            </div>
        <?php endif; ?>
        <?php if (empty($_SESSION['booking_history'])): ?>
            <div class="history-detail">
                <div class="text">
                    <h1>Riwayat Pesanan Masih Kosong</h1>
                    <p>Belum ada pesanan tercatat. Cari konsol favoritmu sekarang dengan klik tombol di bawah!</p>
                </div>
                <a href="index.php#kategori_ps" class="btn btn-primary">Booking Sekarang</a>
            </div>
        <?php else: ?>
            <div class="history-list" c>
                <?php foreach ($_SESSION['booking_history'] as $h): ?>
                    <div class="history-card">
                        <div class="history-meja">
                            <div class="booking-info">
                                <div class="ps-name">
                                    <h2><?= htmlspecialchars($h['nama_ps']) ?></h2>
                                    <span><?= $h['booking_id'] ?></span>
                                </div>
                                <div class="history-price">
                                    <span class='price'>Rp <?= number_format($h['total_bayar'], 0, ',', '.') ?></span>
                                    <div class="status">
                                        <span class='metode-pembayaran'><?= $h['metode'] ?></span>
                                        <span class='status'>Selesai</span>
                                    </div>
                                </div>
                            </div>
                            <div class="meja-list">
                                <?php foreach ($h['detail_meja'] as $dm): ?>
                                    <span class="meja-item">
                                        Meja <?= $dm['nomor'] ?> (<?= $dm['durasi'] ?> jam)
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="history-date">
                            <span class='date'><?= $h['tanggal'] ?></span>
                            <span class='pelanggan'><?= htmlspecialchars($h['nama_pelanggan']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <div class="modal-konfirmasi-container <?= $booking_success ? 'active' : '' ?>">
        <div class="modal">
            <div class="header">
                <svg style="margin-bottom: 1rem; color: #22c55e;" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check">
                    <circle cx="12" cy="12" r="10" />
                    <path d="m9 12 2 2 4-4" />
                </svg>
                <h1>Booking Berhasil</h1>
                <p>Silahkan download recipt, sebagai bukti pemesanan</p>
            </div>
            <div class="buttons">
                <button id="btn-konfirmasi-kembali" class="btn btn-secondary">Kembali</button>
                <button id="btn-download-recipt" class="btn btn-primary">Download Recipt</button>
            </div>
        </div>
    </div>
    <script src="js/form_steps.js"></script>
</body>

</html>