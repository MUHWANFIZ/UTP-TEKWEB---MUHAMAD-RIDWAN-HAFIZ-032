<?php
require 'config.php';
$checkout_sukses = false;

if (isset($_GET['hapus_item'])) {
    unset($_SESSION['cart'][$_GET['hapus_item']]);
    header("Location: keranjang.php"); exit;
}

if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    try {
        $pdo->beginTransaction();
        foreach ($_SESSION['cart'] as $id => $qty) {
            $stmt = $pdo->prepare("UPDATE products SET stok = stok - ? WHERE id = ? AND stok >= ?");
            $stmt->execute([$qty, $id, $qty]);
            if ($stmt->rowCount() == 0) throw new Exception("Maaf, stok produk mendadak habis.");
        }
        $pdo->commit();
        unset($_SESSION['cart']);
        $checkout_sukses = true;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('".$e->getMessage()."');</script>";
    }
}
$total_belanja = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Keranjang | MAROON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #020617; color: white; font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="p-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-4xl font-black italic">KERANJANG <span class="text-red-600">SAYA</span></h1>
            <a href="katalog.php" class="text-xs font-bold text-gray-500 hover:text-white uppercase">&larr; Lanjut Belanja</a>
        </div>

        <?php if ($checkout_sukses): ?>
            <div class="glass p-20 rounded-[3rem] text-center border border-red-600/30">
                <h2 class="text-4xl font-black uppercase italic mb-4">PESANAN BERHASIL!</h2>
                <p class="text-gray-400 mb-8">Koleksi pilihanmu sedang diproses untuk dikirim.</p>
                <a href="index.php" class="bg-red-600 px-10 py-4 rounded-full font-bold uppercase text-xs">KEMBALI KE HOME</a>
            </div>
        <?php elseif (empty($_SESSION['cart'])): ?>
            <div class="glass p-20 rounded-[3rem] text-center">
                <p class="text-gray-500 mb-6">Keranjang kamu masih kosong.</p>
                <a href="katalog.php" class="bg-white text-black px-10 py-4 rounded-full font-bold uppercase text-xs">LIHAT PRODUK</a>
            </div>
        <?php else: ?>
            <div class="glass rounded-[2rem] overflow-hidden shadow-2xl">
                <table class="w-full">
                    <tr class="bg-white/5 text-[10px] uppercase font-bold text-gray-500">
                        <th class="p-6 text-left">Produk</th>
                        <th class="p-6">Qty</th>
                        <th class="p-6 text-right">Subtotal</th>
                        <th class="p-6"></th>
                    </tr>
                    <?php foreach($_SESSION['cart'] as $id => $qty): 
                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                        $stmt->execute([$id]);
                        $p = $stmt->fetch();
                        if ($p): $sub = $p['harga'] * $qty; $total_belanja += $sub; ?>
                        <tr class="border-b border-white/5">
                            <td class="p-6 font-bold uppercase tracking-tight"><?= $p['nama_produk'] ?></td>
                            <td class="p-6 text-center"><?= $qty ?></td>
                            <td class="p-6 text-right font-black text-red-500"><?= formatRupiah($sub) ?></td>
                            <td class="p-6 text-center"><a href="?hapus_item=<?= $id ?>" class="text-gray-600 hover:text-white">&times;</a></td>
                        </tr>
                    <?php endif; endforeach; ?>
                </table>
                <div class="p-10 flex justify-between items-center bg-white/5">
                    <div class="text-3xl font-black italic"><?= formatRupiah($total_belanja) ?></div>
                    <form action="" method="POST">
                        <button type="submit" name="checkout" class="bg-white text-black px-12 py-4 rounded-xl font-black uppercase text-xs hover:bg-red-600 hover:text-white transition shadow-lg">KONFIRMASI BELI</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>