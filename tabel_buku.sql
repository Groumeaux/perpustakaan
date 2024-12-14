-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: terraform-20241210123114792300000004.czecqgo6e8u6.us-east-1.rds.amazonaws.com    Database: data_perpus
-- ------------------------------------------------------
-- Server version	8.0.39

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
--
-- Table structure for table `tb_buku`
--

DROP TABLE IF EXISTS `tb_buku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_buku` (
  `id_buku` varchar(10) NOT NULL,
  `judul_buku` varchar(64) NOT NULL,
  `pengarang` varchar(64) NOT NULL,
  `penerbit` varchar(30) NOT NULL,
  `th_terbit` year NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `cover` varchar(200) NOT NULL,
  `jml_buku` int NOT NULL,
  PRIMARY KEY (`id_buku`),
  UNIQUE KEY `isbnunique` (`isbn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tb_buku`
--

LOCK TABLES `tb_buku` WRITE;
/*!40000 ALTER TABLE `tb_buku` DISABLE KEYS */;
INSERT INTO `tb_buku` VALUES ('B001','To Kill a Mockingbird','Harper Lee','J. B. Lippincott',1960,'9793269405','tkam.jpg',6),('B002','1984','George Orwell','Mizan Original',1949,'9786020661988','zkppnzqigyqalgqftuzbpz.jpg',7),('B003','The Great Gatsby','F. Scott Fitzgerald','Charles Scribners Sons',2010,'98761234562','61PxxqzdJPL._AC_UF1000,1000_QL80_.jpg',5),('B004','Sapiens: A Brief History of Humankind','Yuval Noah Harari','Harper Collins Publisher',2015,'9780062316097','sapiens.jpg',8),('B005','Educated','Tara Westover','Gramedia Pustaka Utama',2021,'9786020650357','edu.jpg',10),('B006','The Name of the Wind','Patrick Rothfuss','DAW Books',2007,'9780756404741','wind.jpg',6),('B007','Dune','Frank Herbert','Chilton Books',1965,'9786231340061','dune.jpg',3),('B008','The Lean Startup','Eric Ries','Crown Business',2011,'9786022918714','startup.jpg',6),('B009','Great One','Lusuvasl Fasiel','Warefrom Otso',2024,'9874125465478','DALL·E 2024-12-10 22.02.35 - A realistic depiction of a man with an average build wearing glasses, dressed in a neat and modern outfit. He is standing confidently with a calm deme.jpg',1),('B010','Rich Dad Poor Dad','Robert T. Kiyosaki','Warner Books',1997,'9781612680194','richdadpoordadcover.jpg',5),('B011','Think and Grow Rich','Napoleon Hill','The Ralston Society',1937,'9781585424337','ID_TGR2019MTH06TGR.jpg',4),('B012','Atomic Habits','James Clear','Avery',2018,'9780735211292','atomichabitscover.jpg',2),('B013','The 7 Habits of Highly Effective People','Stephen R. Covey','Free Press',1989,'9780743269513','7habitscover.png',3),('B014','Start With Why','Simon Sinek','Portfolio',2009,'9781591846444','startwithwhycover.jpg',5),('B015','Filsafat Ilmu','Jujun S. Suriasumantri','Pustaka Sinar Harapan',1990,'9789791681277','filsafatilmucover.jpg',6),('B016','Mikroekonomi Teori Pengantar','Sadono Sukirno','Rajawali Pers',2006,'9794214132','9789797695736_Mikro-Ekonomi (2).jpg',15),('B017','Sosiologi Suatu Pengantar','Soerjono Soekanto & Budi Sulistyowati','Rajagrafindo Persada',2017,'9789797695774','22496.jpg',8),('B018','Mengenal Hukum Suatu Pengantar','Sudikno Mertokusumo','Liberty Yogyakarta',1986,'9786239006518','31321.jpg',2),('B019','Bumi Manusia','Pramoedya Ananta Toer','Lentera Dipantara',1980,'9789799731241','bumimanusiacover.jpg',8),('B020','Laskar Pelangi',' Andrea Hirata','Bentang Pustaka',2005,'9789793062798','laskar pelangi.jpg',10),('B021','Sejarah Nasional Indonesia','Sartono Kartodirdjo','Balai Pustaka',2008,'9789794074419','b74bc3f9be0de1ee7241cd31205a117e.jpg',10),('B022','Negara Paripurna','Yudi Latif','PT Gramedia Pustaka Utama',2011,'9789792234273','1.jpg',8),('B023','Fisika Dasar','Halliday & Resnick','Erlangga',2010,'9789790330199','fisikadasarcover.jpg',10),('B024','Kimia Dasar','Ralph H. Petrucci','Erlangga',2012,'9789790156003','kimiadasarcover.jpg',10),('B025','Biologi Sel','Bruce Alberts','Garuda Print',2010,'9789791972398','biologiselcover.jpg',9),('B026','Matematika Diskrit','Rinaldi Munir','Informatika Bandung',2014,'9789793339105','matematikadiskritcover.jpg',8),('B027','Metode Penelitian Kuantitatif','Sugiyono','CV Alfabeta',2016,'9786027985295','metodepenelitiankuantitatif.jpg',10),('B028','The Art of Teaching Children','Philip Done','Avid Reader Press',2022,'9781982165666','61Fi-24ps6L.jpg',1),('B029','Jejak Langkah','Pramoedya Ananta Toer','Hasta Mitra',1985,'9789796902550','jejak.jpg',5),('B030',' Indonesia: The Rise of Capital','Richard Robinson','Allen & Unwin',2007,'9781741145060','capital.jpg',10),('B031','The Social World of Batavia: Europeans and Eurasians in Colonial','Jean Gelman Taylor','University of Wisconsin Press',1983,'9780299232146','sean.jpg',3),('B032','Cultural Politics in a Global Age','David Held & Henrietta L. L.','Wiley',2006,'9780745636549','cultur.jpg',3),('B033','Hujan','Tere Liye','Gramedia Pustaka Utama',2017,'9786020317872','hujan.jpg',2),('B034','Pulang','Tere Liye','Gramedia Pustaka Utama',2016,'9786020313059','pulang.jpg',1),('B035','Bumi','Tere Liye','Gramedia Pustaka Utama',2013,'9789792291215','bumii.jpg',4),('B036','Matahari','Tere Liye','Gramedia Pustaka Utama',2015,'9786020310058','Sampul Matahari.jpg',1),('B037','Sang Pemimpi','Andrea Hirata','Bentang Pustaka',2006,'9789797689698','mimpi.jpg',6),('B038','Indonesia: A Country Profile','J. S. A. S. De Jong','Oxford University Press',1996,'9780195920163','indo.jpg',5),('B039','Cloud Computing For Dummies','Judith S. Hurwitz','John Wiley & Sons',2009,'9780470484708','cloud_computing_for_dummies.jpg',2),('B040','The Geography of Thought','Richard E. Nisbett','Free Press',2003,'9780743233557','GEOGRAPHY-OF-THOUGHT.jpg',5),('B041','The Rise of Indonesian Communism','Ruth McVey','Verso Books',1965,'9780801490725','comunis.jpg',6),('B042','Indonesian Political Thinking 1945-1965','Herbert Feith dan Lance Castles','Cornell University Press',1970,'9780801490718','poli.jpg',10),('B043','Habis Gelap Terbitlah Terang','R. A. Kartini','Balai Pustaka',1922,'9789794289325','kartini.jpg',5),('B044','Kekerasan Budaya Pasca 1965','Wijaya Herlambang','Marjin Kiri',2013,'9789791262252','pasca.jpg',6),('B045','Gagasan Islam Liberal di Indonesia','Greg Barton','Paramadina',1999,'9789799426038','islam.jpg',10),('B046','Laut Bercerita','Leila S. Chudori','Kepustakaan Populer Gramedia (',2017,'9786024246940','9786024246945_Laut-Bercerita.jpg',5),('B047','Jalan Raya Pos, Jalan Daendels','Pramoedya Ananta Toer','Lentera Dipantara',2005,'9789799731247','dd.jpg',3),('B048','The Encyclopedia of Indonesia in the Pacific War','Peter Post','Brill Academic Publishers',2010,'9789004250949','pt.jpg',6),('B049','The Hobbit','J. R. R. Tolkien','Houghton Mifflin Harcourt',2012,'9780547928227','712cDO7d73L._SY425_.jpg',3),('B050','The Hunger Games','Suzanne Collins','Scholastic Press',2008,'9780439023481','the-hunger-games.jpg',2);
/*!40000 ALTER TABLE `tb_buku` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-12  3:59:56
