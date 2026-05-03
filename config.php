<?php
session_start();
$host = 'localhost';
$dbname = 'maroon_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if (!isset($_SESSION['cart'])) { $_SESSION['cart'] = []; }
$total_cart_items = array_sum($_SESSION['cart']);

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>