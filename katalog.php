<?php 
require 'config.php'; 

if (isset($_POST['add_to_cart'])) {
    $id = $_POST['id_produk'];
    $qty = (int)$_POST['qty'];
    
    $check = $pdo->prepare("SELECT stok FROM products WHERE id = ?");
    $check->execute([$id]);
    $stok_sekarang = $check->fetchColumn();

    if ($stok_sekarang >= $qty) {
        $_SESSION['cart'][$id] = isset($_SESSION['cart'][$id]) ? $_SESSION['cart'][$id] + $qty : $qty;
        header("Location: keranjang.php"); exit;
    } else {
        echo "<script>alert('Maaf, stok tidak mencukupi!'); window.location='katalog.php';</script>"; exit;
    }
}

$stmt_kat = $pdo->query("SELECT DISTINCT kategori FROM products WHERE kategori != ''");
$list_kategori = $stmt_kat->fetchAll(PDO::FETCH_COLUMN);

$kat_aktif = $_GET['kategori'] ?? '';
$cari = $_GET['cari'] ?? '';
$query = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($kat_aktif) { $query .= " AND kategori = ?"; $params[] = $kat_aktif; }
if ($cari) { $query .= " AND nama_produk LIKE ?"; $params[] = "%$cari%"; }

$stmt = $pdo->prepare($query . " ORDER BY id DESC");
$stmt->execute($params);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Katalog | MAROON COMPANY</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #020617; color: white; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="pb-20">
    <nav class="sticky top-0 z-50 glass border-b border-white/5 px-6 py-5 mb-10">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-xl font-extrabold uppercase italic">MAROON <span class="text-red-600">COMPANY</span></a>
            <div class="flex gap-6 items-center">
                <a href="index.php" class="text-[10px] font-bold hover:text-red-500">HOME</a>
                <a href="keranjang.php" class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2"/></svg>
                    <span class="absolute -top-2 -right-2 bg-red-600 text-[10px] w-5 h-5 flex items-center justify-center rounded-full"><?= $total_cart_items ?></span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6">
        <div class="flex flex-wrap gap-3 mb-10">
            <a href="katalog.php" class="px-6 py-2 rounded-full text-xs font-bold <?= !$kat_aktif ? 'bg-red-600' : 'glass' ?>">ALL</a>
            <?php foreach($list_kategori as $k): ?>
                <a href="?kategori=<?= urlencode($k) ?>" class="px-6 py-2 rounded-full text-xs font-bold <?= $kat_aktif == $k ? 'bg-red-600' : 'glass' ?> uppercase"><?= $k ?></a>
            <?php endforeach; ?>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php while ($row = $stmt->fetch()): 
                $is_habis = $row['stok'] <= 0;
            ?>
            <div class="glass p-5 rounded-[2rem] group relative">
                <div class="aspect-square rounded-[1.5rem] overflow-hidden mb-5 bg-black/20">
                    <img src="img/<?= $row['gambar'] ?>" class="w-full h-full object-contain p-4 group-hover:scale-110 transition <?= $is_habis ? 'opacity-20 grayscale' : '' ?>">
                </div>
                <h3 class="font-bold text-lg truncate mb-1"><?= $row['nama_produk'] ?></h3>
                <p class="text-xl font-black mb-6"><?= formatRupiah($row['harga']) ?></p>
                
                <div class="flex gap-2">
                    <a href="detail.php?id=<?= $row['id'] ?>" class="p-3 glass rounded-xl hover:bg-white/10 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                    </a>
                    <form action="" method="POST" class="flex-grow">
                        <input type="hidden" name="id_produk" value="<?= $row['id'] ?>">
                        <input type="hidden" name="qty" value="1">
                        <?php if($is_habis): ?>
                            <button type="button" disabled class="w-full bg-gray-800 text-gray-500 py-3 rounded-xl font-bold text-[10px] uppercase">HABIS</button>
                        <?php else: ?>
                            <button type="submit" name="add_to_cart" class="w-full bg-red-600 py-3 rounded-xl font-bold text-[10px] uppercase hover:bg-red-700 transition">BUY</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>