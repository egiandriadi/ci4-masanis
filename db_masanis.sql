-- MySQL dump 10.13  Distrib 9.3.0, for macos15.4 (arm64)
--
-- Host: 103.150.196.53    Database: db_masanis
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.22-MariaDB-ubu2004

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_years`
--

DROP TABLE IF EXISTS `academic_years`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_years` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `semester` enum('1','2') NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_years`
--

LOCK TABLES `academic_years` WRITE;
/*!40000 ALTER TABLE `academic_years` DISABLE KEYS */;
INSERT INTO `academic_years` VALUES (1,'2026/2027','1',1,'2026-10-20 14:42:04','2026-10-20 14:42:04');
/*!40000 ALTER TABLE `academic_years` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_teachers`
--

DROP TABLE IF EXISTS `class_teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `class_teachers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` int(11) unsigned NOT NULL,
  `teacher_id` int(11) unsigned NOT NULL,
  `is_homeroom` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `class_teachers_class_id_foreign` (`class_id`),
  KEY `class_teachers_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `class_teachers_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `class_teachers_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_teachers`
--

LOCK TABLES `class_teachers` WRITE;
/*!40000 ALTER TABLE `class_teachers` DISABLE KEYS */;
INSERT INTO `class_teachers` VALUES (1,1,1,1);
/*!40000 ALTER TABLE `class_teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` int(11) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `level` enum('KB','TK-A','TK-B') NOT NULL DEFAULT 'TK-A',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `classes_academic_year_id_foreign` (`academic_year_id`),
  CONSTRAINT `classes_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,1,'TK-A Khadijah','TK-A','2026-10-20 14:42:04','2026-10-20 14:42:04'),(2,1,'TK-B Aisyah','TK-B','2026-10-20 14:42:04','2026-10-20 14:42:04');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_assessment_items`
--

DROP TABLE IF EXISTS `daily_assessment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_assessment_items` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `daily_assessment_id` int(11) unsigned NOT NULL,
  `indicator_id` int(11) unsigned NOT NULL,
  `score` tinyint(1) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_assessment_items_daily_assessment_id_foreign` (`daily_assessment_id`),
  KEY `daily_assessment_items_indicator_id_foreign` (`indicator_id`),
  CONSTRAINT `daily_assessment_items_daily_assessment_id_foreign` FOREIGN KEY (`daily_assessment_id`) REFERENCES `daily_assessments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `daily_assessment_items_indicator_id_foreign` FOREIGN KEY (`indicator_id`) REFERENCES `evaluation_indicators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_assessment_items`
--

LOCK TABLES `daily_assessment_items` WRITE;
/*!40000 ALTER TABLE `daily_assessment_items` DISABLE KEYS */;
INSERT INTO `daily_assessment_items` VALUES (37,1,1,2,NULL),(38,1,2,0,NULL),(39,1,3,2,NULL),(40,1,4,1,NULL),(41,1,5,2,NULL),(42,1,6,1,NULL),(43,1,7,1,NULL),(44,1,8,2,NULL),(45,1,9,1,NULL),(46,1,10,2,NULL),(47,1,11,1,NULL),(48,1,12,0,NULL),(49,1,13,1,NULL),(50,1,14,1,NULL),(51,1,15,2,NULL),(52,1,16,2,NULL),(53,1,17,1,NULL),(54,1,18,2,NULL);
/*!40000 ALTER TABLE `daily_assessment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_assessments`
--

DROP TABLE IF EXISTS `daily_assessments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_assessments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `assessment_date` date NOT NULL,
  `total_score` int(11) NOT NULL DEFAULT 0,
  `average_score` decimal(4,2) NOT NULL DEFAULT 0.00,
  `category_grade` enum('BSB','BSH','MB','BB') DEFAULT NULL,
  `filled_by` enum('parent','teacher') NOT NULL DEFAULT 'parent',
  `teacher_note` text DEFAULT NULL,
  `verified_by_teacher_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id_assessment_date` (`student_id`,`assessment_date`),
  KEY `daily_assessments_verified_by_teacher_id_foreign` (`verified_by_teacher_id`),
  CONSTRAINT `daily_assessments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `daily_assessments_verified_by_teacher_id_foreign` FOREIGN KEY (`verified_by_teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_assessments`
--

LOCK TABLES `daily_assessments` WRITE;
/*!40000 ALTER TABLE `daily_assessments` DISABLE KEYS */;
INSERT INTO `daily_assessments` VALUES (1,1,'2026-10-20',24,1.33,'BSH','parent',NULL,NULL,'2026-10-20 15:21:19','2026-10-20 18:15:46');
/*!40000 ALTER TABLE `daily_assessments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_indicators`
--

DROP TABLE IF EXISTS `evaluation_indicators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_indicators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pillar_id` int(11) unsigned NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `name` text NOT NULL,
  `guide_score_2` text NOT NULL,
  `guide_score_1` text NOT NULL,
  `guide_score_0` text NOT NULL,
  `order_num` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `evaluation_indicators_pillar_id_foreign` (`pillar_id`),
  CONSTRAINT `evaluation_indicators_pillar_id_foreign` FOREIGN KEY (`pillar_id`) REFERENCES `evaluation_pillars` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_indicators`
--

LOCK TABLES `evaluation_indicators` WRITE;
/*!40000 ALTER TABLE `evaluation_indicators` DISABLE KEYS */;
INSERT INTO `evaluation_indicators` VALUES (1,1,'IND-01','Shalat Subuh tepat waktu / belajar ikut tanpa drama','2: Tepat waktu/Ceria','1: Kesiangan/Drama','0: Belum mau',1,1),(2,1,'IND-02','Shalat Dzuhur tepat waktu / mau diajak shalat berjamaah','2: Mau diajak/Ceria','1: Diingatkan berkali-kali','0: Belum mau',2,1),(3,1,'IND-03','Shalat Ashar tepat waktu / mau diajak shalat berjamaah','2: Mau diajak/Ceria','1: Diingatkan berkali-kali','0: Belum mau',3,1),(4,1,'IND-04','Shalat Maghrib tepat waktu / mau diajak shalat berjamaah','2: Mau diajak/Ceria','1: Diingatkan berkali-kali','0: Belum mau',4,1),(5,1,'IND-05','Shalat Isya tepat waktu / mau diajak shalat berjamaah','2: Mau diajak/Ceria','1: Diingatkan berkali-kali','0: Belum mau',5,1),(6,2,'IND-06','Olahraga Pagi (senam/jalan/sepeda/fisik aktif)','2: Bergerak aktif/Ceria','1: Hanya sebentar/Kurang semangat','0: Malas bergerak',6,1),(7,2,'IND-07','Bermain Fisik Aktif Sore (bukan main gadget/HP)','2: Main luar rumah/Fisik','1: Main di dalam rumah saja','0: Full main HP/Gadget',7,1),(8,3,'IND-08','Bangun Tidur Pagi tanpa rewel','2: Bangun ceria & segar','1: Merengek sebentar','0: Mengamuk/Tantrum lama',8,1),(9,3,'IND-09','Perawatan Diri Pagi (mandi, sikat gigi, pakai baju sendiri)','2: Mandi & bersiap sendiri','1: Dibantu setengahnya','0: Dibantu total/Drama',9,1),(10,3,'IND-10','Sarapan Pagi dengan tertib & mandiri','2: Habis & makan sendiri sambil duduk','1: Disuapi sebagian','0: Disuapi total/Sambil HP',10,1),(11,3,'IND-11','Merapikan kembali mainan atau buku yang selesai digunakan','2: Inisiatif sendiri merapikan','1: Harus disuruh berkali-kali','0: Menolak/Ditinggal berantakan',11,1),(12,3,'IND-12','Adab Pulang Rumah (ucap salam, taruh sepatu & tas sendiri)','2: Salam & taruh barang dengan rapi','1: Harus diingatkan','0: Barang dilempar acak-acakan',12,1),(13,3,'IND-13','Persiapan Tidur Malam (sikat gigi & baca doa tidur)','2: Sikat gigi & doa mandiri','1: Harus dipaksa/Dikejar dulu','0: Langsung tidur tanpa sikat',13,1),(14,4,'IND-14','Penggunaan 3 Kata Sakti (Maaf, Tolong, Terima Kasih)','2: Spontan mengucapkan','1: Ucap jika diingatkan','0: Tidak mau mengucapkan',14,1),(15,4,'IND-15','Mau Berbagi di rumah (berbagi makanan/mainan ke saudara)','2: Mau berbagi dengan ceria','1: Berbagi setelah dibujuk','0: Pelit/Merebut mainan',15,1),(16,4,'IND-16','Nada Bicara & Sopan Santun','2: Sopan & suara lembut','1: Berteriak karena gemas/kesal','0: Membentak/Kasar',16,1),(17,5,'IND-17','Pengendalian Rasa Kecewa (keinginan ditolak/tidak dituruti)','2: Menangis wajar/Bisa ditenangkan','1: Merengek lama','0: Mengamuk/Pukul/Tantrum hebat',17,1),(18,5,'IND-18','Kejujuran & Tanggung Jawab','2: Jujur berani mengakui kesalahan','1: Ragu-ragu/Takut jujur','0: Berbohong',18,1);
/*!40000 ALTER TABLE `evaluation_indicators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_pillars`
--

DROP TABLE IF EXISTS `evaluation_pillars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_pillars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `order_num` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_pillars`
--

LOCK TABLES `evaluation_pillars` WRITE;
/*!40000 ALTER TABLE `evaluation_pillars` DISABLE KEYS */;
INSERT INTO `evaluation_pillars` VALUES (1,'Spiritual',1),(2,'Fisik & Motorik',2),(3,'Kemandirian',3),(4,'Adab & Sosial',4),(5,'Emosi',5);
/*!40000 ALTER TABLE `evaluation_pillars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-10-20-143638','App\\Database\\Migrations\\CreateInitialSchema','default','App',1792507203,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_reports`
--

DROP TABLE IF EXISTS `monthly_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `monthly_reports` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) unsigned NOT NULL,
  `year` int(4) NOT NULL,
  `month` tinyint(2) NOT NULL,
  `average_score` decimal(4,2) NOT NULL DEFAULT 0.00,
  `category_grade` enum('BSB','BSH','MB','BB') NOT NULL,
  `recommendation_treatment` text NOT NULL,
  `teacher_feedback` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_id_year_month` (`student_id`,`year`,`month`),
  CONSTRAINT `monthly_reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_reports`
--

LOCK TABLES `monthly_reports` WRITE;
/*!40000 ALTER TABLE `monthly_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_profiles`
--

DROP TABLE IF EXISTS `school_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `school_profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(150) NOT NULL,
  `npsn` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `principal_name` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_profiles`
--

LOCK TABLES `school_profiles` WRITE;
/*!40000 ALTER TABLE `school_profiles` DISABLE KEYS */;
INSERT INTO `school_profiles` VALUES (1,'TK Islam Terpadu Mas Anis','69912345','Jl. Pendidikan Karakter No. 10','081234567890','tk.masanis@example.sch.id','Hj. Siti Aminah, S.Pd.I',NULL,'2026-10-20 14:42:04','2026-10-20 14:42:04');
/*!40000 ALTER TABLE `school_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `class_id` int(11) unsigned NOT NULL,
  `nis` varchar(30) NOT NULL,
  `nisn` varchar(30) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `gender` enum('L','P') NOT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `parent_name` varchar(150) DEFAULT NULL,
  `parent_phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis` (`nis`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `students_class_id_foreign` (`class_id`),
  CONSTRAINT `students_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,3,1,'2026001','0192837465','Ahmad Zaki Al-Farizi','Zaki','L','Jakarta','2021-05-14','M. Ridwan','081211112222','Jl. Melati Indah No. 5','2026-10-20 14:42:04','2026-10-20 14:42:04');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `full_name` varchar(150) NOT NULL,
  `gender` enum('L','P') NOT NULL DEFAULT 'P',
  `phone` varchar(30) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `teachers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,2,'199008152018012001','Ustadzah Fatimah, S.Pd','P','081298765432','Jl. Anggrek No. 12','2026-10-20 14:42:04','2026-10-20 14:42:04');
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','teacher','parent') NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$S88v11L31lt1WRGQRvB48ON4x0INB6Acs7EZKjd9ma8HEcxYYL7eO','admin','Administrator Sistem','081234567890','admin@masanis.sch.id',1,'2026-10-20 14:42:04','2026-10-20 14:42:04'),(2,'guru1','$2y$12$sEtkoZEDa9m88U.4n/rzJu3IRWivWDELTjBd66gO7bDfbIfYBUQF.','teacher','Ustadzah Fatimah, S.Pd','081298765432','fatimah@masanis.sch.id',1,'2026-10-20 14:42:04','2026-10-20 14:42:04'),(3,'2026001','$2y$12$p1JNN62GrhYaCf4S7B/MYOZnRDwTkRh6TVUAdUCEiyMqHxdP9e3nO','parent','Ahmad Zaki (Ortu: Bpk. Ridwan)','081211112222','ridwan@example.com',1,'2026-10-20 14:42:04','2026-10-20 14:42:04'),(4,'ssss','$2y$12$Fz1VTbyuQpYF8VNDxJ55h.Yix/uUQZAGuUyqUPYCz5oRn/WAEfJDO','teacher','Bandi','','',1,'2026-10-20 18:12:22','2026-10-20 18:12:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-21  9:35:02
