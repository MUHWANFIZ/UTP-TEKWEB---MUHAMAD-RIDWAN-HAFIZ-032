<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MAROON COMPANY | Premium Action Figures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #020617; color: white; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body>
    <nav class="sticky top-0 z-50 bg-black/40 backdrop-blur-xl border-b border-white/5 px-6 py-5">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php" class="text-2xl font-black italic tracking-tighter flex items-center gap-2">
                <span class="bg-red-600 text-white px-3 py-1 rounded-lg not-italic">M</span> MAROON
            </a>
            <div class="hidden md:flex space-x-8 text-[11px] font-bold tracking-widest text-gray-400">
                <a href="index.php" class="text-white">HOME</a>
                <a href="katalog.php" class="hover:text-white transition">KATALOG</a>
                <a href="admin.php" class="hover:text-white transition">ADMIN</a>
            </div>
            <a href="keranjang.php" class="p-2 glass rounded-full relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2"/></svg>
                <span class="absolute -top-1 -right-1 bg-red-600 text-[10px] w-5 h-5 flex items-center justify-center rounded-full font-bold"><?= $total_cart_items ?></span>
            </a>
        </div>
    </nav>

    <header class="container mx-auto px-6 py-20 text-center">
        <h1 class="text-6xl md:text-8xl font-black italic uppercase tracking-tighter mb-6">Unleash the <span class="text-red-600">Beast</span></h1>
        <p class="text-gray-400 max-w-2xl mx-auto text-lg mb-10">Koleksi Action Figure premium dengan detail material terbaik.</p>
        <a href="katalog.php" class="bg-white text-black px-12 py-5 rounded-full font-black text-xs uppercase tracking-widest hover:bg-red-600 transition">Jelajahi Koleksi</a>
    </header>

    <section class="container mx-auto px-6 py-20">
        <h2 class="text-2xl font-black uppercase italic mb-12 border-l-4 border-red-600 pl-4">NEW FIGURES</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
            while ($row = $stmt->fetch()):
                $img = filter_var($row['gambar'], FILTER_VALIDATE_URL) ? $row['gambar'] : 'img/' . $row['gambar'];
                $is_habis = $row['stok'] <= 0;
            ?>
            <div class="glass p-6 rounded-[2.5rem] hover:border-red-600/50 transition duration-500 group relative">
                <?php if($is_habis): ?>
                    <span class="absolute top-8 right-8 bg-red-600 text-[10px] font-bold px-3 py-1 rounded-full z-10">HABIS</span>
                <?php endif; ?>
                <div class="aspect-square rounded-[2rem] overflow-hidden mb-6 bg-white/5">
                    <img src="<?= $img ?>" class="w-full h-full object-contain p-4 group-hover:scale-110 transition duration-700 <?= $is_habis ? 'opacity-30 grayscale' : '' ?>">
                </div>
                <h3 class="font-bold text-lg mb-1 truncate"><?= $row['nama_produk'] ?></h3>
                <p class="text-xl font-black text-white mb-6"><?= formatRupiah($row['harga']) ?></p>
                <a href="detail.php?id=<?= $row['id'] ?>" class="block text-center bg-white/5 py-4 rounded-2xl font-bold text-xs uppercase hover:bg-white hover:text-black transition">Detail Produk</a>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
</body>
</html>