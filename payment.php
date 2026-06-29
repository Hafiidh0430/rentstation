<?php
require_once 'data.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['selected_meja'])) {
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['booking_slots'])) {
    $_SESSION['booking_slots'] = [];
}

$ps_id = $_POST['ps_id'];
$ps = $ps_data[$ps_id];
$selected_meja_ids = $_POST['selected_meja'];
$jam_operasional = range(10, 21);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pembayaran - RentaPS</title>
    <link rel="stylesheet" href="css/style.css">
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
                            <h1>Atur Waktu <span class="ps-type"><?= $ps['nama'] ?></span></h1>
                            <p>Pilih waktu mulai dan durasi untuk setiap meja yang Anda pilih.</p>
                        </div>
                        <?php foreach ($selected_meja_ids as $meja_id):
                            $parts = explode('-', $meja_id);
                            $no_meja = end($parts);
                            $jam_blokir = $_SESSION['booking_slots'][$meja_id] ?? [];
                            $jam_blokir_str = implode(',', $jam_blokir);
                        ?>
                            <div class="meja-durasi" data-jam_blokir="<?= $jam_blokir_str ?>">
                                <input type="hidden" name="meja_ids[]" value="<?= $meja_id ?>">
                                <div class="detail-meja">
                                    <span class="no-meja">Meja. <?= $no_meja ?></span>
                                    <div class="forms">
                                        <div class="form-group">
                                            <label>Durasi</label>
                                            <select name="durasi[]" class="durasi-select">
                                                <?php for ($i = 1; $i <= 8; $i++) echo "<option value='$i'>$i Jam</option>"; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Jam Mulai</label>
                                            <select name="mulai[]" class="jam-select" required>
                                                <?php foreach ($jam_operasional as $jam): ?>
                                                    <option value="<?= $jam ?>"><?= str_pad($jam, 2, '0', STR_PAD_LEFT) ?>:00</option>
                                                <?php endforeach; ?>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote">
                                <rect width="20" height="12" x="2" y="6" rx="2" />
                                <circle cx="12" cy="12" r="2" />
                                <path d="M6 12h.01M18 12h.01" />
                            </svg>
                        </div>
                        <div class="forms">
                            <label>
                                <input type="radio" name="metode" value="QRIS" checked>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-qr-code">
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house">
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
    </div>
    <div class="modal-container">
        <div class="modal">
            <div class="header">
                <h1>Konfirmasi Pesanan</h1>
                <p>Cek kembali pesananmu, jika sudah sesuai, lanjutkan konfirmasi.</p>
            </div>
            <div class="data">
                <div class="data-diri">
                    <b>Data Diri:</b>
                    <div class="nama-telp">
                        <b class="nama">Zaki</b>
                        <span class="no-telp">089271837736</span>
                    </div>
                </div>
                <div class="tipe-ps">
                    <b>Tipe PS:</b>
                    <span class="nama-ps">PlayStation 5</span>
                </div>
                <div class="meja-durasi-modal">
                    <b>No Meja & Durasi:</b>
                    <div class="meja-durasi-list">
                        <div class="meja-durasi-detail">
                            <span class="meja"><b>Meja. 05</b></span>
                            <span class="durasi">2 Jam - 12:00 s/d 14:00</span>
                        </div>
                    </div>
                </div>
            </div>
            <span class="line"></span>
            <div class="data">
                <div class="metode-pembayaran">
                    <b>Metode Pembayaran:</b>
                    <span class="metode">CASH (Bayar Ditempat)</span>
                </div>
                <div class="total-bayar">
                    <b>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert-icon lucide-circle-alert">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" x2="12" y1="8" y2="12" />
                            <line x1="12" x2="12.01" y1="16" y2="16" />
                        </svg>
                        Total:</b>
                    <b class="total">Rp. <?= number_format(10000, 0, '.') ?></b>
                </div>
            </div>
            <div class="img-qris-code" style="display: none;">
                <img src="assets/fake-qris.png" width="250" height="250" alt="" class="qris">
                <p>Selesaikan pembayaran dalam waktu <b class="waktu">00:00</b></p>
            </div>
            <div class="buttons">
                <button id="btn-batal" class="btn btn-secondary">Batal</button>
                <button id="btn-konfirmasi" class="btn btn-primary">Konfirmasi</button>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/form_steps.js"></script>
</body>

</html>