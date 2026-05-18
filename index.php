<?php
require_once 'data.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>RentStation - Sewa PlayStation</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="nav">
            <a href="index.php" class="logo">
                <img class='img-logo' src="assets/Logo.jpg" width="56" height="56" alt="RentStation">
            </a>
            <div class="menu">
                <a href="#kategori_ps">Kategori PS</a>
                <a href="history.php">Riwayat Pesanan</a>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="hero">
            <div class="left">
                <div class="people">
                    <div class="img-group">
                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                        <img src="https://images.unsplash.com/photo-1717672054642-e4012ba4d551?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                        <img src="https://images.unsplash.com/photo-1622614307810-1e069ab4e5af?q=80&w=686&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                    </div>
                    <p>Dipercaya oleh 1000+ pelanggan.</p>
                </div>
                <div class="text">
                    <h1>Capek Ngantri Lama <br> Cuma Buat Main PS?</h1>
                    <p>Booking PlayStation secara online. Cek ketersediaan slot secara <br> real-time dan tentuin jadwal main tanpa harus datang dan nunggu.</p>
                </div>
                <div class="buttons">
                    <a href="#kategori_ps" class="btn btn-primary">Booking Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right-icon lucide-arrow-up-right">
                            <path d="M7 7h10v10" />
                            <path d="M7 17 17 7" />
                        </svg>
                    </a>
                    <a href="" class="btn btn-secondary">Hubungi Kami</a>
                </div>
            </div>
            <div class="right">
                <img src="https://images.unsplash.com/photo-1592840496694-26d035b52b48?q=80&w=825&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="image-cover" alt="">
            </div>
        </section>

        <section class="list-ps" id="kategori_ps">
            <div class="text">
                <h1>Daftar PS Tersedia dan <br> Langsung Booking</h1>
                <p>Lihat daftar PlayStation beserta harga sewa/jam, <br> lalu pilih yang paling sesuai dengan kebutuhan kamu!</p>
            </div>
            <div class="ps-grid">
                <?php foreach ($ps_data as $ps): ?>
                    <div class="ps-card">
                        <img src="https://picsum.photos/seed/ps<?= $ps['id'] ?>/400/300" alt="<?= $ps['nama'] ?>">
                        <div class="ps-info">
                            <div class="text">
                                <h3><?= htmlspecialchars($ps['nama']) ?></h3>
                                <p class="ps-price">Rp <?= number_format($ps['harga'], 0, ',', '.') ?> / jam</p>
                            </div>
                            <a href="detail.php?id=<?= $ps['id'] ?>" class="btn btn-cta">Booking Sekarang
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right-icon lucide-arrow-up-right">
                                    <path d="M7 7h10v10" />
                                    <path d="M7 17 17 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <footer>
        <div class="header">
            <h1>Siap Main di RentStation <br> Tanpa Ngantri?</h1>
            <div class="buttons">
                <a href="#kategori_ps" class="btn btn-primary">Booking Sekarang
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
</body>

</html>