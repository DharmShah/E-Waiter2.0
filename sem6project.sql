-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2025 at 06:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sem6project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admindetails`
--

CREATE TABLE `admindetails` (
  `id` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admindetails`
--

INSERT INTO `admindetails` (`id`, `username`, `password`, `phonenumber`) VALUES
(1, 'parshwa', 'parshwa', 9428292869),
(2, 'dharm', '1234', 6789012345),
(3, 'hiral', '12456', 9876543219),
(4, 'lala', 'lala', 9456325415);

-- --------------------------------------------------------

--
-- Table structure for table `admin_control`
--

CREATE TABLE `admin_control` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `table_count` int(11) NOT NULL,
  `opening_hours` varchar(20) DEFAULT NULL,
  `closing_hours` varchar(20) DEFAULT NULL,
  `cuisine_type` varchar(100) DEFAULT NULL,
  `gst_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_control`
--

INSERT INTO `admin_control` (`id`, `name`, `logo`, `address`, `email`, `phone`, `table_count`, `opening_hours`, `closing_hours`, `cuisine_type`, `gst_number`) VALUES
(3, 'DharmShah', 'uploads/1743008165_42c8f34f6783787b3cf5.png', 'lala', 'lala@gmail.com', '9409553510', 12, '10:11', '22:30', 'india', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `dailytransaction`
--

CREATE TABLE `dailytransaction` (
  `id` int(11) NOT NULL,
  `total` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `paymentmode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dishrate`
--

CREATE TABLE `dishrate` (
  `id` int(255) NOT NULL,
  `imgurl` varchar(255) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `itemprice` int(255) NOT NULL,
  `itemcategory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishrate`
--

INSERT INTO `dishrate` (`id`, `imgurl`, `itemname`, `itemprice`, `itemcategory`) VALUES
(1, '/soup/hot-sour-soup.png', 'Hot-Sour Soup', 150, 'Soups'),
(2, '/soup/manchaow-soup.jpeg', 'Manchaow  Soup', 130, 'Soups'),
(3, '/soup/tomato-soup.jpeg', 'Tomato Soup', 110, 'Soups'),
(4, '/soup/vegetable-soup.png', 'Vegetable Soup', 125, 'Soups'),
(5, '/starter/kabab.jpeg', 'kabab', 200, 'Starter'),
(6, '/starter/noodles.jpg', 'noodles', 180, 'Starter'),
(7, '/starter/panner-chapp.jpg', 'panner-chapp', 190, 'Starter'),
(8, '/starter/pizza.png', 'pizza', 220, 'Starter'),
(9, '/starter/veg-manchurian.jpg', 'veg-manchurian', 210, 'Starter'),
(10, '/salad/american-saladpng.png', 'American Salad', 150, 'Salads'),
(11, '/salad/cobb-saladpng.png', 'Cobb Salad', 160, 'Salads'),
(12, '/salad/greek-saladpng.png', 'Greek Salad', 170, 'Salads'),
(13, '/salad/itlian-salad.png', 'Itlian Salad', 180, 'Salads'),
(14, '/salad/mexican-saladpng.png', 'Mexican Salad', 190, 'Salads'),
(15, '/salad/grain-saladpng.png', 'Grain Salad', 200, 'Salads'),
(16, '/sabji/palak-paneer.jpg', 'palak-paneer', 250, 'Sabji'),
(17, '/sabji/paneer-butter-masala.png', 'Paneer Butter Masala', 270, 'Sabji'),
(18, '/sabji/paneerhandi.jpg', 'paneerhandi', 260, 'Sabji'),
(19, '/sabji/panner-masala.jpeg', 'panner-masala', 275, 'Sabji'),
(20, '/sabji/panner-shahi.jpeg', 'panner-shahi', 280, 'Sabji'),
(21, '/sabji/sahi-paneer.png', 'sahi-paneer', 290, 'Sabji'),
(22, '/roti/lachha-paratha.png', 'lachha-paratha', 50, 'Roti'),
(23, '/roti/kashmiri-paratha-2.png', 'kashmiri-paratha-2', 60, 'Roti'),
(24, '/roti/chur-chur-naan.jpg', 'chur-chur-naan', 70, 'Roti'),
(25, '/roti/butter_roti.jpg', 'butter_roti', 40, 'Roti'),
(26, '/roti/butter_naan.jpg', 'butter_naan', 55, 'Roti'),
(27, '/roti/aloo-paratha.jpg', 'aloo-paratha', 65, 'Roti'),
(28, '/Drinks/thumps-up.jpg', 'thumps-up', 45, 'Drinks'),
(29, '/Drinks/sprite.jpeg', 'sprite', 45, 'Drinks'),
(30, '/Drinks/pepsi.jpg', 'pepsi', 45, 'Drinks'),
(31, '/Drinks/lassi.jpeg', 'lassi', 60, 'Drinks'),
(32, '/Drinks/coldcoco.jpg', 'coldcoco', 70, 'Drinks'),
(33, '/Drinks/butter-milk.jpg', 'butter-milk', 50, 'Drinks'),
(34, '/rice/pulav.jpg', 'pulav', 180, 'Rice'),
(35, '/rice/jeera-rice.jpg', 'jeera-rice', 160, 'Rice'),
(36, '/rice/fried-rice.jpg', 'fried-rice', 170, 'Rice'),
(37, '/rice/dal-tadka.jpg', 'dal-tadka', 190, 'Rice'),
(38, '/rice/dal_fry.jpg', 'dal_fry', 185, 'Rice'),
(39, '/rice/biryani.jpeg', 'biryani', 250, 'Rice'),
(40, '/desert/browni.jpg', 'browni', 150, 'Desserts'),
(41, '/desert/ice-cream.jpeg', 'ice-cream', 100, 'Desserts'),
(42, '/desert/jalebi.png', 'jalebin', 120, 'Desserts'),
(43, '/desert/kulfi.jpg', 'kulfi', 130, 'Desserts'),
(44, '/desert/rabdi.jpg', 'rabdi', 140, 'Desserts'),
(45, '/desert/sunday_Icecream.jpg', 'sunday_Icecream', 160, 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `tableorder`
--

CREATE TABLE `tableorder` (
  `id` int(255) NOT NULL,
  `tableno` int(255) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `served` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tableorder`
--

INSERT INTO `tableorder` (`id`, `tableno`, `itemname`, `quantity`, `served`) VALUES
(2, 3, 'kabab', 9, 1),
(4, 3, 'Tomato Soup', 3, 1),
(5, 3, 'Vegetable Soup', 3, 0),
(6, 2, 'Paneer Butter Masala', 3, 1),
(8, 2, 'pepsi', 5, 0),
(9, 2, 'kulfi', 2, 0),
(10, 2, 'Vegetable Soup', 1, 0),
(11, 2, 'rabdi', 1, 0),
(12, 3, 'Vegetable Soup', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `waiterdetails`
--

CREATE TABLE `waiterdetails` (
  `id` int(255) NOT NULL,
  `waitername` varchar(255) NOT NULL,
  `tablealloted` int(255) NOT NULL,
  `phonenumber` bigint(10) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `waiterdetails`
--

INSERT INTO `waiterdetails` (`id`, `waitername`, `tablealloted`, `phonenumber`, `password`) VALUES
(1, 'dharm  ', 1, 9409553511, 'dharm '),
(6, 'lala', 4, 1234567890, 'lala'),
(7, 'par', 1, 9523652145, 'parshwa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admindetails`
--
ALTER TABLE `admindetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_control`
--
ALTER TABLE `admin_control`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `dailytransaction`
--
ALTER TABLE `dailytransaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishrate`
--
ALTER TABLE `dishrate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tableorder`
--
ALTER TABLE `tableorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `waiterdetails`
--
ALTER TABLE `waiterdetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admindetails`
--
ALTER TABLE `admindetails`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_control`
--
ALTER TABLE `admin_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dailytransaction`
--
ALTER TABLE `dailytransaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dishrate`
--
ALTER TABLE `dishrate`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tableorder`
--
ALTER TABLE `tableorder`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `waiterdetails`
--
ALTER TABLE `waiterdetails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
