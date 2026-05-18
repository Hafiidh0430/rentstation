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
        <div class="content-payment">
            <img src="https://images.unsplash.com/photo-1609354786576-5140d7e578c2?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="payment-image" alt="">
            <form action="confirm.php" method="POST">
                <div class="form-content">
                    <!-- Pengaturan Durasi -->
                    <div class="form-jam-main">
                        <div class="text">
                            <h1>Atur Waktu <?= $ps['nama'] ?></h1>
                            <p>Pilih waktu mulai dan durasi untuk setiap meja yang Anda pilih.</p>
                        </div>
                        <?php foreach ($selected_meja_ids as $m_id):
                            $parts = explode('-', $m_id);
                            $no_meja = end($parts);
                        ?>
                            <div class="meja-durasi">
                                <input type="hidden" name="meja_ids[]" value="<?= $m_id ?>">
                                <div class="detail-meja">
                                    <span class="no-meja">Meja. <?= $no_meja ?></span>
                                    <div class="forms">
                                        <div class="form-group">
                                            <label>Jam Mulai</label>
                                            <input type="time" name="mulai[]" class="time-start" required value="<?= date('H:i') ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Durasi</label>
                                            <select name="durasi[]" class="durasi-select">
                                                <?php for ($i = 1; $i <= 8; $i++) echo "<option value='$i'>$i Jam</option>"; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="waktu-selesai">
                                        Selesai pada: <span class="time-end">--:--</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Form Data Diri -->
                    <div class="form-data-diri">
                        <div class="text">
                            <h1>Isi Data Diri</h1>
                            <p>Lengkapi informasi diri Anda untuk melanjutkan pemesanan.</p>
                        </div>
                        <div class="forms">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input placeholder="Masukkan Nama Lengkap" type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input placeholder="Masukkan Email" type="email" name="email" class="form-control" required>
                                <span style="font-size: 1rem; color: #ea2222">Pastikan format email mengandung '@'</span>
                            </div>
                            <div class="form-group">
                                <label>Nomor WA</label>
                                <input placeholder="Masukkan Nomor WA" type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pembayaran -->
                    <div class="form-pembayaran">
                        <div class="text">
                            <h1>Selesaikan Pembayaran</h1>
                            <p>Pilih metode pembayaran yang Anda inginkan.</p>
                        </div>
                        <div class="price-display">
                            <div class="total-display">
                                <span>Total Harga:</span>
                                <span id="display-total">Rp 0</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote-icon lucide-banknote">
                                <rect width="20" height="12" x="2" y="6" rx="2" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M6 12h.01M18 12h.01" />
                            </svg>
                        </div>
                        <div class="forms">
                            <label>
                                <input type="radio" name="metode" value="QRIS" checked>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code-icon lucide-qr-code">
                                    <rect width="5" height="5" x="3" y="3" rx="1" />
                                    <rect width="5" height="5" x="16" y="3" rx="1" />
                                    <rect width="5" height="5" x="3" y="16" rx="1" />
                                    <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                                    <path d="M21 21v.01" />
                                    <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                                    <path d="M3 12h.01" />
                                    <path d="M12 3h.01" />
                                    <path d="M12 16v.01" />
                                    <path d="M16 12h1" />
                                    <path d="M21 12v.01" />
                                    <path d="M12 21v-1" />
                                </svg>
                                QRIS
                            </label>
                            <label>
                                <input type="radio" name="metode" value="CASH">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house">
                                    <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                                    <path d="M3 10a2 2 0 0 1 .709-1.528l7-6a2 2 0 0 1 2.582 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                </svg>
                                Bayar Ditempat
                            </label>
                        </div>
                    </div>

                </div>
                <div class="buttons">
                    <button type="button" class="btn btn-secondary previous">Sebelumnya</button>
                    <button type="submit" class="btn btn-primary next">Selanjutnya</button>
                </div>
                <input type="hidden" name="ps_id" value="<?= $ps_id ?>">
                <input type="hidden" id="harga_per_jam" value="<?= $ps['harga'] ?>">
            </form>
        </div>
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