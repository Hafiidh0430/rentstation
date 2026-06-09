<?php
require_once 'data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$booking_id = "RPS-" . date('Ymd') . "-" . strtoupper(substr(uniqid(), -4));
$nama = $_POST['nama'];
$ps = $ps_data[$_POST['ps_id']];
$meja_ids = $_POST['meja_ids'];
$mulai_arr = $_POST['mulai'];
$durasi_arr = $_POST['durasi'];
$metode = $_POST['metode'];

$total_all = 0;
$detail_booking = [];

foreach ($meja_ids as $index => $m_id) {
    $durasi = (int)$durasi_arr[$index];
    $subtotal = $durasi * $ps['harga'];
    $total_all += $subtotal;

    $jam_mulai = $mulai_arr[$index];
    $jam_selesai = date('H:i', strtotime($jam_mulai . " + $durasi hours"));

    $parts = explode('-', $m_id);
    $detail_booking[] = [
        'nomor' => end($parts),
        'mulai' => $jam_mulai,
        'selesai' => $jam_selesai,
        'durasi' => $durasi,
        'subtotal' => $subtotal
    ];

    foreach ($_SESSION['meja_status'] as &$m) {
        if ($m['id_meja'] === $m_id) {
            $m['status'] = 'booked';
        }
    }
}

$history_entry = [
    'booking_id' => $booking_id,
    'tanggal' => date('d/m/Y H:i'),
    'nama_pelanggan' => $nama,
    'nama_ps' => $ps['nama'],
    'total_bayar' => $total_all,
    'metode' => $metode,
    'detail_meja' => $detail_booking
];

array_unshift($_SESSION['booking_history'], $history_entry);

 header('Location: history.php');
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan - RentaPS</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container" style="text-align: center;">
        <div class="no-print">
            <h1 style="color: #22c55e;">Pembayaran Berhasil ✓</h1>
            <p>Terima kasih sudah memesan di RentaPS.</p>
            <div style="margin: 20px 0;">
                <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
                <a href="index.php" class="btn" style="background: #444; color: white;">Kembali ke Home</a>
            </div>
        </div>

        <div class="receipt">
            <div class="receipt-header">
                <h3>RENTAPS GAMING</h3>
                <p>Jl. Gamer Sejati No. 99, Indonesia</p>
                <p><?= date('d/m/Y H:i') ?></p>
            </div>

            <div style="margin: 15px 0; text-align: left;">
                <div class="receipt-line"><span>No. Booking:</span> <span><?= $booking_id ?></span></div>
                <div class="receipt-line"><span>Pelanggan:</span> <span><?= htmlspecialchars($nama) ?></span></div>
                <div class="receipt-line"><span>Konsol:</span> <span><?= $ps['nama'] ?></span></div>
            </div>

            <div style="border-top: 1px dashed #000; padding-top: 10px;">
                <?php foreach ($detail_booking as $db): ?>
                    <div style="text-align: left; margin-bottom: 10px;">
                        <div>Meja <?= $db['nomor'] ?> (<?= $db['durasi'] ?> Jam)</div>
                        <div class="receipt-line">
                            <small><?= $db['mulai'] ?> - <?= $db['selesai'] ?></small>
                            <span>Rp <?= number_format($db['subtotal'], 0, ',', '.') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="border-top: 2px solid #000; padding-top: 10px; font-weight: bold;">
                <div class="receipt-line">
                    <span>TOTAL</span>
                    <span>Rp <?= number_format($total_all, 0, ',', '.') ?></span>
                </div>
            </div>

            <div style="margin-top: 15px; font-size: 0.8rem;">
                <p>Metode Bayar: <?= $metode ?></p>
                <p style="margin-top: 10px;">*** TERIMA KASIH ***</p>
            </div>
        </div>
    </div>
</body>

</html>s