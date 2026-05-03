<?php
require 'config.php';

// Logika Hapus (DELETE)
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: admin.php"); exit;
}

// Logika Tambah & Update (CREATE & UPDATE)
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_produk'];
    $kat = $_POST['kategori'];
    $hrg = $_POST['harga'];
    $stok = $_POST['stok'];
    $desk = $_POST['deskripsi'];
    $id = $_POST['id_produk'] ?? '';

    if (!empty($_FILES['gambar_produk']['name'])) {
        $file = $_FILES['gambar_produk']['name'];
        move_uploaded_file($_FILES['gambar_produk']['tmp_name'], "img/" . $file);
    } else {
        $file = $_POST['gambar_lama'] ?? '';
    }

    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET nama_produk=?, kategori=?, harga=?, stok=?, gambar=?, deskripsi=? WHERE id=?");
        $stmt->execute([$nama, $kat, $hrg, $stok, $file, $desk, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (nama_produk, kategori, harga, stok, gambar, deskripsi) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nama, $kat, $hrg, $stok, $file, $desk]);
    }
    header("Location: admin.php"); exit;
}

// Ambil Data untuk Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Panel | MAROON</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; color: white; }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body class="p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black italic uppercase">Admin <span class="text-red-600">Panel</span></h1>
            <a href="index.php" class="text-xs font-bold text-gray-500 hover:text-white uppercase tracking-widest">&larr; Ke Website Utama</a>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data" class="glass p-8 rounded-[2rem] mb-12 grid grid-cols-2 gap-6">
            <input type="hidden" name="id_produk" value="<?= $edit_data['id'] ?? '' ?>">
            <input type="hidden" name="gambar_lama" value="<?= $edit_data['gambar'] ?? '' ?>">
            
            <input type="text" name="nama_produk" placeholder="Nama Produk" value="<?= $edit_data['nama_produk'] ?? '' ?>" class="bg-white/5 border border-white/10 p-4 rounded-xl outline-none focus:border-red-600" required>
            <input type="text" name="kategori" placeholder="Kategori" value="<?= $edit_data['kategori'] ?? '' ?>" class="bg-white/5 border border-white/10 p-4 rounded-xl outline-none focus:border-red-600" required>
            <input type="number" name="harga" placeholder="Harga" value="<?= $edit_data['harga'] ?? '' ?>" class="bg-white/5 border border-white/10 p-4 rounded-xl outline-none focus:border-red-600" required>
            <input type="number" name="stok" placeholder="Stok" value="<?= $edit_data['stok'] ?? '' ?>" class="bg-white/5 border border-white/10 p-4 rounded-xl outline-none focus:border-red-600" required>
            <textarea name="deskripsi" placeholder="Deskripsi" class="col-span-2 bg-white/5 border border-white/10 p-4 rounded-xl outline-none focus:border-red-600"><?= $edit_data['deskripsi'] ?? '' ?></textarea>
            <div class="col-span-2"><p class="text-[10px] text-gray-500 mb-2 uppercase font-bold">Upload Gambar Baru (Kosongkan jika tidak ganti)</p><input type="file" name="gambar_produk"></div>
            <button type="submit" name="simpan" class="col-span-2 bg-red-600 py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-red-700 transition"><?= isset($edit_data) ? 'Simpan Perubahan' : 'Tambah Produk Baru' ?></button>
            <?php if(isset($edit_data)): ?><a href="admin.php" class="col-span-2 text-center text-xs font-bold text-gray-500 uppercase hover:text-white">Batal Edit</a><?php endif; ?>
        </form>

        <div class="glass rounded-[2rem] overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-[10px] uppercase font-bold text-gray-500 tracking-widest">
                    <tr><th class="p-6">Produk</th><th class="p-6 text-center">Stok</th><th class="p-6 text-right">Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach($products as $r): ?>
                    <tr class="border-t border-white/5 hover:bg-white/5 transition">
                        <td class="p-6 font-bold uppercase tracking-tight"><?= $r['nama_produk'] ?></td>
                        <td class="p-6 text-center <?= $r['stok'] <= 0 ? 'text-red-500 font-black' : '' ?>"><?= $r['stok'] ?></td>
                        <td class="p-6 text-right space-x-4">
                            <a href="?edit=<?= $r['id'] ?>" class="text-blue-500 font-bold uppercase text-[10px] tracking-widest">Edit</a>
                            <a href="?hapus=<?= $r['id'] ?>" class="text-red-600 font-bold uppercase text-[10px] tracking-widest" onclick="return confirm('Hapus Permanen?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>