-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 09:14 AM
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
(4, 'lala', 'lala', 9456325415),
(7, 'hahaha', 'hahaha', 9409553510);

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
(3, 'DharmShah', 'uploads/1743008165_42c8f34f6783787b3cf5.png', 'lala', 'lala@gmail.com', '9409553510', 10, '10:11', '22:30', 'india', '123456789');

-- --------------------------------------------------------

--
-- Table structure for table `chefdetails`
--

CREATE TABLE `chefdetails` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chefdetails`
--

INSERT INTO `chefdetails` (`id`, `name`, `password`, `phonenumber`) VALUES
(1, 'lala', 'lala', '9409553510');

-- --------------------------------------------------------

--
-- Table structure for table `dailytransaction`
--

CREATE TABLE `dailytransaction` (
  `id` bigint(255) NOT NULL,
  `itemname` varchar(255) DEFAULT NULL,
  `itemquantitie` varchar(255) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `paymentmode` enum('Cash','Card','UPI') NOT NULL,
  `tablenumber` varchar(10) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dailytransaction`
--

INSERT INTO `dailytransaction` (`id`, `itemname`, `itemquantitie`, `total`, `paymentmode`, `tablenumber`, `datetime`) VALUES
(8, '[\"pizza\",\"cheese garlic bread\"]', '[\"1\",\"2\"]', 470.00, 'UPI', '2', '2025-04-01 06:35:00'),
(9, '[\"butter chicken\",\"naan\"]', '[\"1\",\"4\"]', 580.00, 'Card', '4', '2025-04-01 07:45:00'),
(10, '[\"veg biryani\",\"raita\"]', '[\"2\",\"1\"]', 410.00, 'Cash', '1', '2025-04-01 08:50:00'),
(11, '[\"pasta\",\"cold coffee\"]', '[\"1\",\"1\"]', 330.00, 'UPI', '5', '2025-04-01 10:40:00'),
(12, '[\"grilled sandwich\",\"french fries\"]', '[\"1\",\"1\"]', 270.00, 'Cash', '3', '2025-04-02 06:00:00'),
(13, '[\"paneer tikka\",\"naan\",\"lassi\"]', '[\"1\",\"2\",\"1\"]', 510.00, 'Card', '6', '2025-04-02 08:15:00'),
(14, '[\"manchurian\",\"fried rice\"]', '[\"1\",\"1\"]', 340.00, 'Cash', '2', '2025-04-02 13:50:00'),
(15, '[\"sizzler\"]', '[\"1\"]', 460.00, 'UPI', '1', '2025-04-03 09:25:00'),
(16, '[\"vada pav\",\"chai\"]', '[\"2\",\"2\"]', 120.00, 'Cash', '4', '2025-04-03 11:40:00'),
(17, '[\"dosa\",\"sambar\",\"filter coffee\"]', '[\"1\",\"1\",\"1\"]', 190.00, 'Card', '3', '2025-04-03 04:20:00'),
(18, '[\"burger\",\"mojito\"]', '[\"1\",\"1\"]', 310.00, 'UPI', '2', '2025-04-04 07:10:00'),
(19, '[\"dal makhani\",\"jeera rice\"]', '[\"1\",\"1\"]', 280.00, 'Cash', '5', '2025-04-04 09:00:00'),
(20, '[\"tandoori chicken\"]', '[\"2\"]', 540.00, 'Card', '1', '2025-04-04 13:30:00'),
(21, '[\"noodles\",\"lemon soda\"]', '[\"1\",\"1\"]', 250.00, 'Cash', '6', '2025-04-05 09:40:00'),
(22, '[\"chole bhature\"]', '[\"2\"]', 220.00, 'UPI', '4', '2025-04-05 07:55:00'),
(23, '[\"pizza\",\"pepsi\"]', '[\"1\",\"1\"]', 350.00, 'Card', '3', '2025-04-05 13:20:00'),
(24, '[\"sandwich\",\"cold coffee\"]', '[\"1\",\"2\"]', 310.00, 'Cash', '2', '2025-04-06 05:35:00'),
(25, '[\"veg thali\"]', '[\"1\"]', 320.00, 'UPI', '5', '2025-04-06 07:45:00'),
(26, '[\"aloo paratha\",\"chaas\"]', '[\"2\",\"2\"]', 200.00, 'Card', '1', '2025-04-06 04:10:00'),
(27, '[\"nachos\",\"sprite\"]', '[\"1\",\"1\"]', 240.00, 'Cash', '6', '2025-04-07 11:30:00'),
(28, '[\"rajma chawal\"]', '[\"1\"]', 180.00, 'UPI', '3', '2025-04-07 07:00:00'),
(29, '[\"idli\",\"sambar\",\"coffee\"]', '[\"2\",\"1\",\"1\"]', 190.00, 'Card', '4', '2025-04-07 03:00:00'),
(30, '[\"biryani\",\"sprite\"]', '[\"1\",\"1\"]', 310.00, 'Cash', '2', '2025-04-08 10:15:00'),
(31, '[\"cheese pasta\"]', '[\"1\"]', 260.00, 'Card', '5', '2025-04-08 12:50:00'),
(32, '[\"burger\",\"fries\",\"coke\"]', '[\"1\",\"1\",\"1\"]', 390.00, 'UPI', '1', '2025-04-08 14:30:00'),
(33, '[\"maggie\",\"chai\"]', '[\"2\",\"2\"]', 140.00, 'Cash', '6', '2025-04-09 04:40:00'),
(34, '[\"club sandwich\",\"coffee\"]', '[\"1\",\"1\"]', 280.00, 'Card', '3', '2025-04-09 07:20:00'),
(35, '[\"fruit salad\"]', '[\"1\"]', 120.00, 'UPI', '4', '2025-04-09 08:55:00'),
(36, '[\"chaat\",\"jaljeera\"]', '[\"1\",\"1\"]', 160.00, 'Cash', '2', '2025-04-09 10:30:00'),
(37, '[\"brownie\",\"ice cream\"]', '[\"1\",\"1\"]', 280.00, 'Card', '5', '2025-04-09 14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dishrate`
--

CREATE TABLE `dishrate` (
  `id` int(255) NOT NULL,
  `imgurl` varchar(255) NOT NULL,
  `itemname` varchar(255) NOT NULL,
  `itemprice` int(255) NOT NULL,
  `itemcategory` varchar(255) NOT NULL,
  `trending` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishrate`
--

INSERT INTO `dishrate` (`id`, `imgurl`, `itemname`, `itemprice`, `itemcategory`, `trending`) VALUES
(1, '/soup/hot-sour-soup.png', 'Hot-Sour Soup', 150, 'Soups', 0),
(2, '/soup/manchaow-soup.jpeg', 'Manchaow  Soup', 130, 'Soups', 1),
(3, '/soup/tomato-soup.jpeg', 'Tomato Soup', 110, 'Soups', 0),
(4, '/soup/vegetable-soup.png', 'Vegetable Soup', 125, 'Soups', 0),
(5, '/starter/kabab.jpeg', 'kabab', 200, 'Starter', 0),
(6, '/starter/noodles.jpg', 'noodles', 180, 'Starter', 1),
(7, '/starter/panner-chapp.jpg', 'panner-chapp', 190, 'Starter', 0),
(8, '/starter/pizza.png', 'pizza', 220, 'Starter', 0),
(9, '/starter/veg-manchurian.jpg', 'veg-manchurian', 210, 'Starter', 1),
(10, '/salad/american-saladpng.png', 'American Salad', 150, 'Salads', 0),
(11, '/salad/cobb-saladpng.png', 'Cobb Salad', 160, 'Salads', 0),
(12, '/salad/greek-saladpng.png', 'Greek Salad', 170, 'Salads', 0),
(13, '/salad/itlian-salad.png', 'Itlian Salad', 180, 'Salads', 0),
(14, '/salad/mexican-saladpng.png', 'Mexican Salad', 190, 'Salads', 1),
(15, '/salad/grain-saladpng.png', 'Grain Salad', 200, 'Salads', 0),
(16, '/sabji/palak-paneer.jpg', 'palak-paneer', 250, 'Sabji', 0),
(17, '/sabji/paneer-butter-masala.png', 'Paneer Butter Masala', 270, 'Sabji', 1),
(18, '/sabji/paneerhandi.jpg', 'paneerhandi', 260, 'Sabji', 0),
(19, '/sabji/panner-masala.jpeg', 'panner-masala', 275, 'Sabji', 0),
(20, '/sabji/panner-shahi.jpeg', 'panner-shahi', 280, 'Sabji', 0),
(21, '/sabji/sahi-paneer.png', 'sahi-paneer', 290, 'Sabji', 0),
(22, '/roti/lachha-paratha.png', 'lachha-paratha', 50, 'Roti', 0),
(23, '/roti/kashmiri-paratha-2.png', 'kashmiri-paratha-2', 60, 'Roti', 0),
(24, '/roti/chur-chur-naan.jpg', 'chur-chur-naan', 70, 'Roti', 1),
(25, '/roti/butter_roti.jpg', 'butter_roti', 40, 'Roti', 0),
(26, '/roti/butter_naan.jpg', 'butter_naan', 55, 'Roti', 0),
(27, '/roti/aloo-paratha.jpg', 'aloo-paratha', 65, 'Roti', 0),
(28, '/Drinks/thumps-up.jpg', 'thumps-up', 45, 'Drinks', 0),
(29, '/Drinks/sprite.jpeg', 'sprite', 45, 'Drinks', 0),
(30, '/Drinks/pepsi.jpg', 'pepsi', 45, 'Drinks', 1),
(31, '/Drinks/lassi.jpeg', 'lassi', 60, 'Drinks', 0),
(32, '/Drinks/coldcoco.jpg', 'coldcoco', 70, 'Drinks', 0),
(33, '/Drinks/butter-milk.jpg', 'butter-milk', 50, 'Drinks', 0),
(34, '/rice/pulav.jpg', 'pulav', 180, 'Rice', 0),
(35, '/rice/jeera-rice.jpg', 'jeera-rice', 160, 'Rice', 0),
(36, '/rice/fried-rice.jpg', 'fried-rice', 170, 'Rice', 0),
(37, '/rice/dal-tadka.jpg', 'dal-tadka', 190, 'Rice', 1),
(38, '/rice/dal_fry.jpg', 'dal_fry', 185, 'Rice', 0),
(39, '/rice/biryani.jpeg', 'biryani', 250, 'Rice', 0),
(40, '/desert/browni.jpg', 'browni', 150, 'Desserts', 0),
(41, '/desert/ice-cream.jpeg', 'ice-cream', 100, 'Desserts', 0),
(42, '/desert/jalebi.png', 'jalebin', 120, 'Desserts', 0),
(43, '/desert/kulfi.jpg', 'kulfi', 130, 'Desserts', 0),
(44, '/desert/rabdi.jpg', 'rabdi', 140, 'Desserts', 1),
(45, '/desert/sunday_Icecream.jpg', 'sunday_Icecream', 160, 'Desserts', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tableorder`
--

CREATE TABLE `tableorder` (
  `id` int(11) NOT NULL,
  `tableno` varchar(50) DEFAULT NULL,
  `itemname` text DEFAULT NULL,
  `quantity` text DEFAULT NULL,
  `served` tinyint(1) DEFAULT 0,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `chefdetails`
--
ALTER TABLE `chefdetails`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_control`
--
ALTER TABLE `admin_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chefdetails`
--
ALTER TABLE `chefdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dailytransaction`
--
ALTER TABLE `dailytransaction`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `dishrate`
--
ALTER TABLE `dishrate`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tableorder`
--
ALTER TABLE `tableorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `waiterdetails`
--
ALTER TABLE `waiterdetails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
