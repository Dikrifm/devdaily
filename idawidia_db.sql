/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.1.2-MariaDB, for Android (aarch64)
--
-- Host: localhost    Database: devdaily_db_dev
-- ------------------------------------------------------
-- Server version	12.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
set autocommit=0;
REPLACE INTO `products` VALUES
(1,'keset-eropa','Keset Eropa',19000,'uploads/1765126060_ebd3a5389c8e06a5fc81.jpg','[\"Pilihan Ibu\"]','Keset Diatomite, anti licin'),
(2,'karpet-eropa','Karpet Eropa',99000,'uploads/1765126275_0098ac76396ee17397c0.jpg','[\"Pilihan Ibu\"]','[100x150/150x200/200x300cm] Karpet Lantai Eropa Style Bahan Polyester Halus '),
(3,'spotec-uptown','Spotec Uptown',250000,'https://images.tokopedia.net/img/cache/700/VqbcmM/2025/4/6/eca03a4a-447c-4085-8546-c8b91f26fd2d.jpg','[\"Pilihan Ibu\"]','Sepatu Running Empuk Keren'),
(4,'bunga-hiasan-daisy','Bunga Hiasan Daisy',32000,'uploads/1765153909_1dc67193288f17abe359.jpg','[\"Pilihan Ibu\",\"Premium\"]','RANGKAIAN BUNGA DAYSI KUPU VAS ROTAN PLASTIK DINDING PITA DEKORASI RUMAH '),
(5,'bunga-hiasan-anggrek','Bunga Hiasan Anggrek',20000,'uploads/1765154672_a0bd181e2128e574bbcb.jpg','[\"Pilihan Ida\",\"Premium\"]','Bunga Anggrek Dinding/Bunga Rambat Tempel Plastik/Bunga Hias/Bunga Artificial '),
(6,'ideame-toples-set-isi-346-set','Ideame Toples Set Isi 3/4/6 Set',119000,'uploads/1765155145_b9ba8814c1d6027b483b.jpg','[\"Pilihan Ida\",\"Premium\",\"Ori\"]','Toples Set Isi 3/4/6 Set Toples Penyimpanan Makanan dengan Nampan / Snack Tray Akrilik / Toples Nampan Makanan Ringan / Wadah Makanan Ringan / Toples Lebaran / Toples Kue Kering '),
(7,'3pcs-toples-set-toples-jumbo','3pcs Toples Set Toples Jumbo',149000,'uploads/1765155463_82d9e6d2102333846775.jpg','[\"Pilihan Ida\",\"Premium\",\"Terbaru\"]','3pcs Toples Set Toples Jumbo Toples Kedap Udara Toples Lebaran Aesthetic Set Mewah Toples Kue Kering Toples Aesthetic Toples Kerupuk Aesthetic Toples Akrilik Toples Plastik Aesthetic Toples Kue Akrilik Toples Kue Lebaran Set Mewah.'),
(8,'toples-lebaran','Toples Lebaran',30000,'uploads/1765156011_09aed655207fc4885fde.jpg','[\"Pilihan Ida\",\"Premium\",\"Terbaru\"]','Toples Lebaran Aesthetic Terbaru 2025 GOLD \r\n');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Dumping data for table `links`
--

LOCK TABLES `links` WRITE;
/*!40000 ALTER TABLE `links` DISABLE KEYS */;
set autocommit=0;
REPLACE INTO `links` VALUES
(1,1,'Shopee','Toko Keset Nasional',18000,'https://s.shopee.co.id/8peVv6NzFc?share_channel_code=1',NULL,'Star Seller','4.8','1rb+'),
(2,2,'Shopee','Eropa Store',95000,'https://s.shopee.co.id/8peVv6NzFc?share_channel_code=1',NULL,'Star Seller','4.8','500+'),
(3,3,'Shopee','Medan Sport',210000,'shopee.com',NULL,'Star Seller','4.9','500+'),
(4,4,'Shopee','Toko Bandung',30000,'https://s.shopee.co.id/805PE0nPsG?share_channel_code=1',NULL,'Star Seller','4.8','500+'),
(5,5,'Shopee','Bunga Store',15000,'https://s.shopee.co.id/6fa1dUGEfQ?share_channel_code=1',NULL,'Star Seller','4.8','500+'),
(6,6,'Shopee','Nayla Premium Store',102000,'https://s.shopee.co.id/AUmkCJ3JJE?share_channel_code=1',NULL,'Star Seller','4.8','100+'),
(7,7,'Shopee','Nasional Premium',132000,'https://s.shopee.co.id/2B7cGozL63?share_channel_code=1',NULL,'Star Seller','4.8','500+'),
(8,8,'Shopee','Abadi D.I.Y',24000,'https://s.shopee.co.id/6KxBEMq5NS?share_channel_code=1',NULL,'Star Seller','4.8','100+');
/*!40000 ALTER TABLE `links` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-12-08 10:34:49
