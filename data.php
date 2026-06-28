<?php
session_start();

if (!isset($_SESSION['booking_history'])) {
    $_SESSION['booking_history'] = [];
}

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
        'jumlah_meja' => 6
    ],
    2 => [
        'id' => 2,
        'nama' => 'PlayStation 4',
        'deskripsi' => 'Performa 4K yang tangguh untuk game AAA modern.',
        'harga' => 7000,
        'jumlah_meja' => 6
    ],
    3 => [
        'id' => 3,
        'nama' => 'PlayStation 5',
        'deskripsi' => 'Generasi terbaru dengan SSD super cepat dan DualSense Haptic Feedback.',
        'harga' => 10000,
        'jumlah_meja' => 6
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
