<?php
session_start();

// Inisialisasi History di Session
if (!isset($_SESSION['booking_history'])) {
    $_SESSION['booking_history'] = [];
}

// Tambahkan fungsi untuk menghapus history (opsional)
if (isset($_GET['clear_history'])) {
    $_SESSION['booking_history'] = [];
    header("Location: history.php");
    exit;
}

$ps_data = [
    1 => [
        'id' => 1,
        'nama' => 'PlayStation 3',
        'deskripsi' => 'Era HD dimulai di sini. Grafis memukau dengan dukungan Blu-ray.',
        'harga' => 5000,
        'spek' => 'Cell Broadband Engine, 256MB XDR, HDMI Out',
        'foto' => ['ps3_1', 'ps3_2', 'ps3_3'],
        'jumlah_meja' => 12
    ],
    2 => [
        'id' => 2,
        'nama' => 'PlayStation 4 Pro',
        'deskripsi' => 'Performa 4K yang tangguh untuk game AAA modern.',
        'harga' => 7000,
        'spek' => '8-core AMD Jaguar, 8GB GDDR5, 4.2 TFLOPS',
        'foto' => ['ps4_1', 'ps4_2', 'ps4_3'],
        'jumlah_meja' => 10
    ],
    3 => [
        'id' => 3,
        'nama' => 'PlayStation 5',
        'deskripsi' => 'Generasi terbaru dengan SSD super cepat dan DualSense Haptic Feedback.',
        'harga' => 10000,
        'spek' => 'Custom Zen 2, Ray Tracing, 4K 120Hz, Ultra-High Speed SSD',
        'foto' => ['ps5_1', 'ps5_2', 'ps5_3'],
        'jumlah_meja' => 8
    ],
];

if (!isset($_SESSION['meja_status'])) {
    $meja_init = [];
    foreach ($ps_data as $id_ps => $ps) {
        for ($i = 1; $i <= $ps['jumlah_meja']; $i++) {
            $status = 'available';
            $meja_init[] = [
                'id_meja' => "M-" . $id_ps . "-" . $i,
                'id_ps' => $id_ps,
                'nomor_meja' => $i,
                'status' => $status
            ];
        }
    }
    $_SESSION['meja_status'] = $meja_init;
}

function getMejaByPs($id_ps)
{
    return array_filter($_SESSION['meja_status'], function ($meja) use ($id_ps) {
        return $meja['id_ps'] == $id_ps;
    });
}
