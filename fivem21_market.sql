-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2020 at 04:39 PM
-- Server version: 10.3.25-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fivem21_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `ayarlar`
--

CREATE TABLE `ayarlar` (
  `ayar_id` int(11) NOT NULL,
  `ayar_logo` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_title` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_description` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_keywords` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_author` varchar(50) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_mail` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_mesai` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_analystic` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_discord` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_youtube` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_smtphost` varchar(250) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_smtppassword` varchar(50) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_smtpport` varchar(50) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_smtpusername` varchar(50) COLLATE utf16_turkish_ci NOT NULL,
  `ayar_bakim` varchar(1) COLLATE utf16_turkish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_turkish_ci;

--
-- Dumping data for table `ayarlar`
--

INSERT INTO `ayarlar` (`ayar_id`, `ayar_logo`, `ayar_title`, `ayar_description`, `ayar_keywords`, `ayar_author`, `ayar_mail`, `ayar_mesai`, `ayar_analystic`, `ayar_discord`, `ayar_youtube`, `ayar_smtphost`, `ayar_smtppassword`, `ayar_smtpport`, `ayar_smtpusername`, `ayar_bakim`) VALUES
(1, '', 'Fivem-Code Market Alanı', 'Tüm paket satışı , Key Satışı , Tasarım hizmetlerinin toplanıp satışının  yapıldığı alan.', 'E-Ticaret , Fivem , Fivem Code  , Fivem Market , Fivem Market', 'Semih Silistre', 'bilgilendirme@fivemcode.com', 'Haftaiçi', 'eklenecek', 'https://discord.gg/tD5AXcA ', 'https://youtube.com', 'eklenecek', 'eklenecek', 'eklenecek', 'eklenecek', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bakiye_log`
--

CREATE TABLE `bakiye_log` (
  `bakiye_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `bakiye_miktar` float(9,2) NOT NULL,
  `bakiye_tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `bakiye_islem` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bildirim`
--

CREATE TABLE `bildirim` (
  `bildirim_id` int(11) NOT NULL,
  `bildirim_detay` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `bildirim_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `bildirim_kime` int(11) NOT NULL,
  `bildirim_okuma` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `destek`
--

CREATE TABLE `destek` (
  `destek_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `destek_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `destek_konu` varchar(250) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `destek_detay` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `destek_durum` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `destek_detay`
--

CREATE TABLE `destek_detay` (
  `destek_detayid` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `destek_id` int(11) NOT NULL,
  `destek_detay_soru` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `destek_detay_yanit` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_ad` varchar(100) CHARACTER SET latin1 NOT NULL,
  `kategori_ust` int(2) NOT NULL,
  `kategori_seourl` varchar(250) CHARACTER SET latin1 NOT NULL,
  `kategori_sira` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_ad`, `kategori_ust`, `kategori_seourl`, `kategori_sira`) VALUES
(1, 'Anti-Cheat', 0, '', 0),
(2, 'Paket-Satisi', 0, '', 1),
(3, 'Fivem-Key', 0, '', 2),
(4, 'Bagisci-Paketleri', 0, '', 3),
(5, 'Tasarim-Isleri', 0, '', 4),
(6, 'Diger', 0, '', 5);

-- --------------------------------------------------------

--
-- Table structure for table `mesaj`
--

CREATE TABLE `mesaj` (
  `mesaj_id` int(11) NOT NULL,
  `mesaj_zaman` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mesaj_detay` text COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_gel` int(11) NOT NULL,
  `kullanici_gon` int(11) NOT NULL,
  `mesaj_okuma` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paracek`
--

CREATE TABLE `paracek` (
  `paracek_id` int(11) NOT NULL,
  `paracek_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `paracek_miktar` float(9,2) NOT NULL,
  `paracek_uyeid` int(11) NOT NULL,
  `paracek_durum` int(1) NOT NULL DEFAULT 0,
  `paracek_onay` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `satici`
--

CREATE TABLE `satici` (
  `satici_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `satici_tipi` varchar(50) CHARACTER SET latin1 NOT NULL,
  `satici_hesapadsoyad` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  `satici_iban` varchar(150) CHARACTER SET latin1 NOT NULL,
  `satici_mail` varchar(100) CHARACTER SET latin1 NOT NULL,
  `satici_ceptel` varchar(50) CHARACTER SET latin1 NOT NULL,
  `satici_adres` text COLLATE utf8_turkish_ci NOT NULL,
  `satici_onay` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siparis`
--

CREATE TABLE `siparis` (
  `siparis_id` int(11) NOT NULL,
  `siparis_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `kullanici_id` int(11) NOT NULL,
  `kullanici_idsatici` int(11) NOT NULL,
  `siparis_odeme` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siparis_detay`
--

CREATE TABLE `siparis_detay` (
  `siparis_detayid` int(11) NOT NULL,
  `siparis_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `kullanici_idsatici` int(11) NOT NULL,
  `urun_fiyat` float(9,2) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_adet` int(4) NOT NULL,
  `siparisdetay_onay` int(2) NOT NULL,
  `siparisdetay_onayzaman` datetime NOT NULL,
  `siparisdetay_yorum` int(1) NOT NULL DEFAULT 0,
  `siparisdetay_not` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `urun`
--

CREATE TABLE `urun` (
  `urun_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `urun_ad` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `urun_aciklama` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `urun_seourl` varchar(20) CHARACTER SET latin1 NOT NULL,
  `urun_detay` text COLLATE utf8_turkish_ci NOT NULL,
  `urun_fiyat` float(9,2) NOT NULL,
  `urun_keyword` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `urun_stok` int(11) DEFAULT 0,
  `urun_durum` int(2) NOT NULL DEFAULT 0,
  `urum_onay` int(2) NOT NULL DEFAULT 0,
  `urun_fotograf` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `urun_populerlik` int(11) NOT NULL DEFAULT 0,
  `urun_onecikar` int(1) NOT NULL DEFAULT 0,
  `urun_bilgi` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uyeler`
--

CREATE TABLE `uyeler` (
  `uye_id` int(11) NOT NULL,
  `uye_zaman` date NOT NULL DEFAULT current_timestamp(),
  `uye_steamisim` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `uye_steamid` varchar(250) CHARACTER SET latin1 NOT NULL,
  `uye_tc` varchar(50) CHARACTER SET latin1 NOT NULL,
  `uye_adsoyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `uye_mail` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `uye_ceptel` varchar(200) CHARACTER SET latin1 NOT NULL,
  `uye_bakiye` float(9,2) NOT NULL DEFAULT 0.00,
  `uye_yetki` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `uye_durum` int(1) DEFAULT 1,
  `uye_onecikartmahak` int(2) NOT NULL DEFAULT 0,
  `uye_urunsayisi` int(1) NOT NULL DEFAULT 3,
  `uye_bildirim` int(11) NOT NULL DEFAULT 1,
  `uye_komisyon` int(11) NOT NULL DEFAULT 15,
  `uye_iban` varchar(50) CHARACTER SET latin1 NOT NULL,
  `uyelik_tip` int(1) NOT NULL DEFAULT 0,
  `uye_vipbitis` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `uye_webhook` varchar(350) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yorumlar`
--

CREATE TABLE `yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `yorum_detay` text COLLATE utf8_turkish_ci NOT NULL,
  `yorum_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `yorum_onay` int(1) NOT NULL DEFAULT 0,
  `yorum_puan` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `yorumlar`
--

INSERT INTO `yorumlar` (`yorum_id`, `kullanici_id`, `urun_id`, `yorum_detay`, `yorum_zaman`, `yorum_onay`, `yorum_puan`) VALUES
(6, 1, 10, 'Çok iyi paket eline sağlık.', '2020-07-08 17:54:06', 1, 5),
(7, 1, 20, 'Çok ilgili bir satıcı tavsiye ediyorum', '2020-07-20 14:03:58', 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Indexes for table `bakiye_log`
--
ALTER TABLE `bakiye_log`
  ADD PRIMARY KEY (`bakiye_id`);

--
-- Indexes for table `bildirim`
--
ALTER TABLE `bildirim`
  ADD PRIMARY KEY (`bildirim_id`);

--
-- Indexes for table `destek`
--
ALTER TABLE `destek`
  ADD PRIMARY KEY (`destek_id`);

--
-- Indexes for table `destek_detay`
--
ALTER TABLE `destek_detay`
  ADD PRIMARY KEY (`destek_detayid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `mesaj`
--
ALTER TABLE `mesaj`
  ADD PRIMARY KEY (`mesaj_id`);

--
-- Indexes for table `paracek`
--
ALTER TABLE `paracek`
  ADD PRIMARY KEY (`paracek_id`);

--
-- Indexes for table `satici`
--
ALTER TABLE `satici`
  ADD PRIMARY KEY (`satici_id`);

--
-- Indexes for table `siparis`
--
ALTER TABLE `siparis`
  ADD PRIMARY KEY (`siparis_id`);

--
-- Indexes for table `siparis_detay`
--
ALTER TABLE `siparis_detay`
  ADD PRIMARY KEY (`siparis_detayid`);

--
-- Indexes for table `urun`
--
ALTER TABLE `urun`
  ADD PRIMARY KEY (`urun_id`);

--
-- Indexes for table `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`uye_id`);

--
-- Indexes for table `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`yorum_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bakiye_log`
--
ALTER TABLE `bakiye_log`
  MODIFY `bakiye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `bildirim`
--
ALTER TABLE `bildirim`
  MODIFY `bildirim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `destek`
--
ALTER TABLE `destek`
  MODIFY `destek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `destek_detay`
--
ALTER TABLE `destek_detay`
  MODIFY `destek_detayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mesaj`
--
ALTER TABLE `mesaj`
  MODIFY `mesaj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `paracek`
--
ALTER TABLE `paracek`
  MODIFY `paracek_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `satici`
--
ALTER TABLE `satici`
  MODIFY `satici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `siparis`
--
ALTER TABLE `siparis`
  MODIFY `siparis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `siparis_detay`
--
ALTER TABLE `siparis_detay`
  MODIFY `siparis_detayid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `urun`
--
ALTER TABLE `urun`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
