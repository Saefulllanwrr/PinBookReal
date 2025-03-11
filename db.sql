-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
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

-- Dumping data for table dbpinbook.admins: ~0 rows (approximately)

-- Dumping data for table dbpinbook.books: ~0 rows (approximately)

-- Dumping data for table dbpinbook.cache: ~0 rows (approximately)

-- Dumping data for table dbpinbook.cache_locks: ~0 rows (approximately)

-- Dumping data for table dbpinbook.donations: ~0 rows (approximately)

-- Dumping data for table dbpinbook.failed_jobs: ~0 rows (approximately)

-- Dumping data for table dbpinbook.favorites: ~0 rows (approximately)

-- Dumping data for table dbpinbook.jobs: ~0 rows (approximately)

-- Dumping data for table dbpinbook.job_batches: ~0 rows (approximately)

-- Dumping data for table dbpinbook.kategori: ~0 rows (approximately)

-- Dumping data for table dbpinbook.loans: ~0 rows (approximately)

-- Dumping data for table dbpinbook.migrations: ~21 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_01_22_051438_create_books_table', 1),
	(5, '2025_01_28_090253_create_kategori_table', 1),
	(6, '2025_01_28_090823_add_kategori_id_to_books_table', 1),
	(7, '2025_02_04_103833_add_role_to_users_table', 1),
	(8, '2025_02_05_011009_create_peminjamen_table', 1),
	(9, '2025_02_09_131251_create_donations_table', 1),
	(10, '2025_02_13_070410_add_stok_to_books_table', 1),
	(11, '2025_02_18_005843_add_no_telepon_to_users_table', 1),
	(12, '2025_02_18_070730_add_avatar_path_to_users_table', 1),
	(13, '2025_02_19_034544_add_borrow_count_to_books', 1),
	(14, '2025_02_19_035701_create_loans_table', 1),
	(15, '2025_02_19_041552_add_borrow_count_to_books', 1),
	(16, '2025_02_20_014455_add_isbn_to_books_table', 1),
	(17, '2025_02_20_033953_create_favorites_table', 1),
	(18, '2025_02_20_045341_create_admins_table', 1),
	(19, '2025_02_20_061624_add_role_to_admins_table', 1),
	(20, '2025_03_01_071157_add_remember_token_to_users_table', 1),
	(21, '2025_03_06_130146_add_is_blocked_to_users_table', 1);

-- Dumping data for table dbpinbook.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table dbpinbook.peminjaman: ~0 rows (approximately)

-- Dumping data for table dbpinbook.sessions: ~0 rows (approximately)

-- Dumping data for table dbpinbook.users: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
