-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for maroon_db
CREATE DATABASE IF NOT EXISTS `maroon_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `maroon_db`;

-- Dumping structure for table maroon_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `gambar` varchar(255) DEFAULT 'default.jpg',
  `deskripsi` text,
  `kategori` varchar(50) DEFAULT 'Marvel',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table maroon_db.products: ~11 rows (approximately)
INSERT INTO `products` (`id`, `nama_produk`, `harga`, `stok`, `gambar`, `deskripsi`, `kategori`) VALUES
	(1, 'Hot Toys Iron Man Mark 85', 6500000.00, 5, 'HOT TOYS.jpg', 'Figure skala 1/6 dengan detail diecast dan LED menyala pada bagian arc reactor.', 'Marvel'),
	(2, 'S.H.Figuarts The Batman', 1200000.00, 10, 'batman marvel.jpg', 'Artikulasi penuh dengan jubah kain premium dan aksesoris batarang.', 'Marvel'),
	(4, 'Bandai RG 1/144 RX-78-2', 550000.00, 8, '1777559424_upd.webp', 'Model kit gundam dengan inner frame detail dan stiker decal presisi tinggi.', 'Marvel'),
	(5, 'Naruto Uzumaki - Kurama Mode', 850000.00, 7, 'NARUTOI_KURAMA.jpg', 'Action figure Naruto Uzumaki dalam mode Kurama dengan detail api chakra yang menyala.', 'Anime'),
	(6, 'Monkey D. Luffy - Gear 5', 1200000.00, 3, 'LUPI G5.jpg', 'Luffy Gear 5 dalam pose ikonik tertawa. Sangat detail dan wajib bagi kolektor One Piece.', 'Anime'),
	(7, 'Zoro Roronoa - Three Sword Style', 950000.00, 4, 'ZORO.jpg', 'Zoro dengan teknik tiga pedang menggunakan efek transparan pada tebasan pedangnya.', 'Anime'),
	(8, 'Batman - The Dark Knight', 1500000.00, 3, 'BATMAN.jpg', 'Batman versi trilogi Christopher Nolan. Dilengkapi dengan jubah kain asli dan aksesoris batarang.', 'DC Comics'),
	(10, 'Superman - Man of Steel', 1300000.00, 10, 'SUPERMAN.jpg', 'Superman dengan kostum bertekstur modern dari film Man of Steel.', 'DC Comics'),
	(12, 'YU ZHONG', 1400000.00, 1, 'STORMTROOPER.jpg', 'EXCLUSIVE M7 PASS MLBB', 'DC Comics');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
