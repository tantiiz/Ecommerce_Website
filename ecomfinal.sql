-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2024 at 04:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecomfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `admin_username` varchar(25) NOT NULL,
  `admin_password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'Jarren', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` int(100) DEFAULT NULL,
  `prod_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `prod_id`, `quantity`, `total`, `prod_name`) VALUES
(106, 56, 2, 1, 1556, 'Trafalgar Law - DXF Figure - The Grandline Series - Extra - Change Ver. (Bandai Spirits)');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `checkout_id` int(11) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `prod_id` int(10) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `total_price` int(100) DEFAULT NULL,
  `checkout_date` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`checkout_id`, `user_id`, `prod_id`, `quantity`, `total_price`, `checkout_date`, `payment_method`, `address`, `status`) VALUES
(61, 61, 1, 1, 2709, '2024-05-19 13:04:40', 'GCash', 'Bacarra', 'Delivered'),
(62, 61, 1, 1, 2709, '2024-05-20 19:52:56', 'Cash on Delivery', 'Bacarra', 'Delivered'),
(63, 61, 93, 1, 100, '2024-05-24 18:21:47', 'Cash on Delivery', 'Bacarra', 'Delivered'),
(64, 61, 1, 1, 2709, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Delivered'),
(65, 61, 6, 1, 5832, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Delivered'),
(66, 61, 7, 1, 1500, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Pending'),
(67, 61, 8, 1, 2598, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Pending'),
(68, 61, 9, 1, 1700, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Pending'),
(69, 61, 11, 1, 2500, '2024-05-25 19:15:46', 'GCash', 'Bacarra', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(10) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_price` int(25) NOT NULL,
  `prod_category` varchar(100) NOT NULL,
  `prod_details` text NOT NULL,
  `prod_img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `prod_name`, `prod_price`, `prod_category`, `prod_details`, `prod_img`) VALUES
(1, 'Monkey D. Luffy - King of Artist - Gear 5 (Bandai Spirits)', 2709, 'One Piece', 'One Piece - Monkey D. Luffy - King of Artist - Gear 5 (Bandai Spirits) :\r\n\r\nLuffy, as seen in the space survival arc of One Piece, joins the S.H.Figuarts series! Now you can hold the power of Son Goku Ultra Instinct in the palm of your hand! The One Piece - Monkey D. Luffy - King of Artist - Gear 5 (Bandai Spirits) S.H.Figuarts Action Figure includes 3x optional expressions, 3x pairs of optional hands, a ball effect, and 7x light beam effects. Measures about 5 1/2-inches tall.\r\n\r\nSpecifications\r\nTheme:One Piece\r\nProduct Type:Action Figures\r\nCharacter:Luffy\r\nCollection:S.H.Figuarts\r\nAge:15 +\r\nCountry of Origin:China\r\nPackaging Height:7 inches (17.78 cm)\r\nPackaging Width:1.50 inches (3.81 cm)\r\nPackaging Length:6 inches (15.24 cm)\r\nWeight:0.350 lb', 'Pics/luffy.jpg'),
(2, 'Trafalgar Law - DXF Figure - The Grandline Series - Extra - Change Ver. (Bandai Spirits)', 1556, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/lawwomen.jpg'),
(6, 'Son Goku Xeno - Super Full Power Saiyan 4 Limit Breaker - Ichiban Kuji Dr', 5832, 'Dragon Ball', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/goku.jpg'),
(7, 'Sung Jin-woo', 1500, 'Solo Leveling', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/jinwo.jpg'),
(8, 'Dai 2 Ki - Chousou', 2598, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/chousou.jpg'),
(9, 'XXRAY Plus Sanji (Anime Edition)', 1700, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/sanji.jpg'),
(10, 'Anime Heroes Naruto_Gaara', 910, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/gaara.jpg'),
(11, 'Dragon Ball Figure goku Figure Super Saiyan Figure Action Figure Collection Design anime Figures', 2500, 'Dragon Ball', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/goku1.jpg'),
(12, 'One Piece Figure Gear 5 Luffy Action Figure Collection One Piece Luffy Action Figures', 10100, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/luffy1.jpg'),
(13, '72l Only I Level Up Solo Leveling Sung Jin Woo Anime Figure Manga Statue Collection Toy 8r4', 3030, 'Solo Leveling', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/jinwo1.jpg'),
(14, 'Gojou Satoru - Nendoroid #2440 - Suit Ver. (Good Smile Company)', 1690, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/gojou.jpg'),
(15, 'Fushiguro Touji - Jurei (Bukiko) - Luminasta - Rinsen (SEGA)', 2506, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/touji.jpg'),
(16, 'Namikaze Minato - Vibration Stars - II (Bandai Spirits)', 3538, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/minato.jpg'),
(17, 'Uzumaki Naruto - Memorable Saga (Bandai Spirits)', 3027, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/naruto.jpg'),
(18, 'Uchiha Obito - Vibration Stars - II (Bandai Spirits)', 2750, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/obito.jpg'),
(19, 'Son Gohan SSJ - S.H.Figuarts - The Fighter Who Surpassed Goku (Bandai Spirits)', 9559, 'Dragon Ball', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/gohan.jpg'),
(20, 'Vegeta SSJ (Majin) - Match Makers (Bandai Spirits)', 3917, 'Dragon Ball', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/vegeta.jpg'),
(21, 'Kugisaki Nobara - Figuarts ZERO (Bandai Spirits)', 11800, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/nobara.jpg'),
(22, 'Figuarts ZERO Nami - WT100 Commemoration Eichiro Oda New Illustration 100 Famous Views and Pirates- ', 6620, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/nami.jpg'),
(23, 'Kamado Nezuko - Figuarts ZERO - Kekkijutsu (Bandai Spirits)', 9100, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/nezuko.jpg'),
(24, 'Kamado Tanjirou - Figuarts ZERO - Total Concentration (Bandai Spirits)', 10700, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/tanjiro.jpg'),
(25, 'Figuarts ZERO Giyu Tomioka Demon Slayer: Kimetsu no Yaiba - November 2021 Re-release (Bandai)', 11800, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/giyu.jpg'),
(26, 'Hatake Kakashi - G.E.M. - Ninkai Taisen ver. (MegaHouse)', 5200, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/kakashi.jpg'),
(27, 'Naruto Shippuuden - Uchiha Sasuke - Chimi Mega Buddy! 003 - Ninkaitaisen Set (MegaHouse)', 6020, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/narutosasuke.jpg'),
(28, 'Nico Robin - DXF Figure - The Grandline Lady Item No. 24', 4070, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/robin1.jpg'),
(29, 'Kaido - Portrait Of Pirates \"WA-MAXIMUM\" (MegaHouse)', 10100, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/kaido.jpg'),
(30, 'Trafalgar Law - Portrait of Pirates \"Playback Memories\" (MegaHouse)', 8020, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/law.jpg'),
(31, 'Kanroji Mitsuri - ARTFX J - 1/8 (Kotobukiya)', 7200, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/mitsuri.jpg'),
(32, 'Mugen Ressha-hen - Rengoku Kyoujurou - Ichiban Kuji Kimetsu no Yaiba ~Reimeini Yaiba wo Mote~ B Priz', 10300, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/rengoku.jpg'),
(33, 'Agatsuma Zenitsu - Figuarts ZERO - Thunderclap and Flash (Bandai Spirits)', 11000, 'Demon Slayer', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/zenitsu.jpg'),
(34, 'Donquixote Doflamingo - Portrait Of Pirates \"SA-MAXIMUM\" - Heavenly Demon (MegaHouse)', 14020, 'One Piece', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/doflamingo.jpg'),
(35, 'Uchiha Itachi - Precious G.E.M. - Susanoo Ver., With LED base stand (MegaHouse)', 16220, 'Naruto', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/itachi.jpg'),
(36, 'Itadori Yuuji - DX Figure - Vs ver. (MegaHouse)', 1099, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/itadori.jpg'),
(37, 'Getou Suguru - Shibuya Scramble Figure - 1/7 (eStream, Mappa)', 8500, 'Jujutsu Kaisen', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles.\n\nStanding tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/getou.jpg'),
(72, 'Genshin Impact - Xiao - Guardian Yaksha Ver. - 1/7 (Apex)', 3500, 'Others', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/xiao.jpg'),
(73, 'Bleach Sennen Kessen-hen - Kuchiki Byakuya - Precious G.E.M. (MegaHouse)', 3200, 'Others', 'Introducing the ultimate warrior destined to dominate your collection—the Anime Action Figure! Crafted with meticulous attention to detail, this figure captures the essence of strength, agility, and power. With its dynamic pose and finely sculpted physique, this figure embodies the epitome of action-packed anime battles. Standing tall at 5 inches, our Anime Action Figure features intricate design elements, from the battle-worn armor to the flowing, dynamic hair. Every muscle is defined, every crease in the clothing meticulously crafted to evoke a sense of movement frozen in time.', 'Pics/kuchiki.jpg'),
(93, 'Diwata', 100, 'Others', 'Pares Overload', 'Pics/66506a103b043.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(11) NOT NULL,
  `prod_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `checkout_id` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `comments` varchar(200) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `phone_number` varchar(11) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_email`, `phone_number`, `password`, `user_address`) VALUES
(61, 'Jarren', 'jarrenaceret2003@gmail.com', '1', 'bfe033a61aa510a7bc5a8fa78d836f30', 'Bacarra'),
(62, 'qwqwqw', 'qwerty@xample.com', '123456789', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'Kyoto, Japan'),
(64, 'Guest', '123@gmail.com', '0902029521', 'ccc0bab12a10f244a4995ba404cc8e46', 'San Nicolas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`checkout_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `checkout_id` (`checkout_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `checkout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `rating_ibfk_3` FOREIGN KEY (`checkout_id`) REFERENCES `checkout` (`checkout_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
