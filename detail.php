<?php 
require 'config.php'; 
$p = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$p->execute([$_GET['id'] ?? 0]);
$produk = $p->fetch();
if (!$produk) { header("Location: katalog.php"); exit; }
$is_habis = $produk['stok'] <= 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $produk['nama_produk'] ?> | MAROON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #020617; color: white; font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.08); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <div class="max-w-5xl w-full glass p-10 rounded-[3rem] relative shadow-2xl">
        <!-- Tombol Kembali -->
        <button onclick="history.back()" class="absolute top-8 left-8 text-xs font-bold text-gray-500 hover:text-white uppercase tracking-widest flex items-center gap-2">
            &larr; Kembali ke Katalog
        </button>

        <div class="grid md:grid-cols-2 gap-12 mt-8">
            <div class="bg-white/5 rounded-[2rem] p-8">
                <img src="img/<?= $produk['gambar'] ?>" class="w-full h-auto drop-shadow-2xl <?= $is_habis ? 'grayscale opacity-30' : '' ?>">
            </div>
            <div class="space-y-6">
                <h1 class="text-5xl font-black uppercase italic tracking-tighter"><?= $produk['nama_produk'] ?></h1>
                <p class="text-gray-400 leading-relaxed"><?= $produk['deskripsi'] ?></p>
                <div class="text-3xl font-black text-red-500"><?= formatRupiah($produk['harga']) ?></div>
                <p class="text-xs font-bold uppercase text-gray-500">Stok Tersedia: <?= $produk['stok'] ?></p>
                
                <form action="katalog.php" method="POST" class="flex gap-4">
                    <input type="hidden" name="id_produk" value="<?= $produk['id'] ?>">
                    <input type="number" name="qty" value="1" min="1" max="<?= $produk['stok'] ?>" <?= $is_habis ? 'disabled' : '' ?> class="bg-white/10 w-20 rounded-xl text-center font-bold outline-none">
                    <?php if($is_habis): ?>
                        <button type="button" disabled class="flex-grow bg-gray-800 text-gray-500 py-4 rounded-xl font-black uppercase text-xs">MAAF STOK HABIS</button>
                    <?php else: ?>
                        <button type="submit" name="add_to_cart" class="flex-grow bg-white text-black py-4 rounded-xl font-black uppercase text-xs hover:bg-red-600 hover:text-white transition">TAMBAH KE KERANJANG</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</body>
</html>