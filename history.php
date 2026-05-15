<?php require_once 'data.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - RentaPS</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container nav">
            <a href="index.php" class="logo">RENTA<span>PS</span></a>
            <div class="menu">
                <a href="index.php" style="color: white; text-decoration: none; margin-right: 20px;">Home</a>
                <a href="history.php" style="color: #4cc9f0; text-decoration: none; font-weight: bold;">Riwayat Pesanan</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h1>Riwayat Pesanan</h1>
            <?php if (!empty($_SESSION['booking_history'])): ?>
                <a href="data.php?clear_history=1" class="btn" style="background: #ef4444; color: white; font-size: 0.8rem;" onclick="return confirm('Hapus semua riwayat?')">Hapus Semua</a>
            <?php endif; ?>
        </div>

        <?php if (empty($_SESSION['booking_history'])): ?>
            <div style="text-align: center; padding: 50px; background: #1a1a2e; border-radius: 12px;">
                <p style="color: #666; font-size: 1.2rem;">Belum ada riwayat pesanan.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Mulai Sewa Sekarang</a>
            </div>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php foreach ($_SESSION['booking_history'] as $h): ?>
                    <div style="background: #1a1a2e; border: 1px solid #2d2d44; border-radius: 10px; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                        <div>
                            <span style="color: #4cc9f0; font-family: monospace;"><?= $h['booking_id'] ?></span>
                            <h3 style="margin: 5px 0;"><?= htmlspecialchars($h['nama_ps']) ?></h3>
                            <small style="color: #888;"><?= $h['tanggal'] ?> • Atas Nama: <?= htmlspecialchars($h['nama_pelanggan']) ?></small>
                            <div style="margin-top: 8px;">
                                <?php foreach ($h['detail_meja'] as $dm): ?>
                                    <span style="display: inline-block; background: #3f37c9; font-size: 0.7rem; padding: 2px 8px; border-radius: 4px; margin-right: 5px;">
                                        Meja <?= $dm['nomor'] ?> (<?= $dm['durasi'] ?>j)
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 1.2rem; font-weight: bold; color: #22c55e;">Rp <?= number_format($h['total_bayar'], 0, ',', '.') ?></div>
                            <small style="display: block; color: #aaa; margin-bottom: 10px;"><?= $h['metode'] ?></small>
                            <span style="color: #22c55e; border: 1px solid #22c55e; padding: 2px 8px; border-radius: 5px; font-size: 0.8rem;">Selesai</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        &copy; <?= date('Y') ?> RentaPS Gaming Center.
    </footer>
</body>

</html>