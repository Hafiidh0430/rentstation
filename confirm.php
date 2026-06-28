<?php
require_once 'data.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$booking_id    = "RPS-" . date('Ymd') . "-" . strtoupper(substr(uniqid(), -4));
$nama          = $_POST['nama'];
$playstation   = $ps_data[$_POST['ps_id']];
$list_meja     = $_POST['meja_ids'];
$list_jam      = $_POST['mulai'];
$list_durasi   = $_POST['durasi'];
$metode        = $_POST['metode'];

if (!isset($_SESSION['booking_slots'])) {
    $_SESSION['booking_slots'] = [];
}

$total_harga    = 0;
$detail_booking = [];

foreach ($list_meja as $index => $meja_id) {
    $jam_mulai = (int) $list_jam[$index];
    $durasi = (int) $list_durasi[$index];
    $jam_selesai = $jam_mulai + $durasi;

    $subtotal    = $durasi * $playstation['harga'];
    $total_harga += $subtotal;

    $parts = explode('-', $meja_id);
    $detail_booking[] = [
        'nomor' => end($parts),
        'mulai' => str_pad($jam_mulai, 2, '0', STR_PAD_LEFT) . ':00',   
        'selesai' => str_pad($jam_selesai, 2, '0', STR_PAD_LEFT) . ':00', 
        'durasi' => $durasi,
        'subtotal' => $subtotal,
    ];

    $jam_yang_diblock = range($jam_mulai, $jam_selesai - 1);

    $_SESSION['booking_slots'][$meja_id] = array_unique(
        array_merge($_SESSION['booking_slots'][$meja_id] ?? [], $jam_yang_diblock)
    );

    $semua_jam = range(10, 21); 
    $jam_terpakai = $_SESSION['booking_slots'][$meja_id];

    $semua_terisi   = count(array_intersect($semua_jam, $jam_terpakai)) === count($semua_jam);

    foreach ($_SESSION['meja_status'] as &$meja) {
        if ($meja['id_meja'] === $meja_id) {
            $meja['status'] = $semua_terisi ? 'booked' : 'available';
        }
    }
    unset($meja); 
}

$history_entry = [
    'booking_id'     => $booking_id,
    'tanggal'        => date('d/m/Y H:i'),
    'nama_pelanggan' => $nama,
    'nama_ps'        => $playstation['nama'],
    'total_bayar'    => $total_harga,
    'metode'         => $metode,
    'detail_meja'    => $detail_booking,
];


array_unshift($_SESSION['booking_history'], $history_entry);

header('Location: history.php');
