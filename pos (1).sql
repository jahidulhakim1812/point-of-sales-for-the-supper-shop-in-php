-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 04:45 PM
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
-- Database: `pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `cart_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`cart_data`)),
  `total_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `customer_name`, `cart_data`, `total_price`, `quantity`, `grand_total`, `payment_method`, `created_at`) VALUES
(15, 'Shaharia', '[{\"id\":14,\"name\":\"Juice\",\"quantity\":22,\"totalPrice\":2199.56}]', 2199.56, 22, 2199.56, 'Cash ', '2025-01-02 09:57:45'),
(16, 'mehedi', '[{\"id\":3,\"name\":\"Pran Mango Juice-125 ml \",\"quantity\":1,\"totalPrice\":15}]', 15.00, 1, 15.00, 'Cash ', '2025-01-02 09:58:26'),
(18, 'jahid', '[{\"id\":5,\"name\":\"Potato (1Kg)\",\"quantity\":1,\"totalPrice\":50}]', 50.00, 1, 50.00, 'Cash ', '2025-01-07 14:13:22'),
(22, 'shakil', '[{\"id\":3,\"name\":\"Pran Mango Juice-125 ml \",\"quantity\":1,\"totalPrice\":15}]', 15.00, 1, 15.00, 'Cash ', '2025-01-07 14:56:54'),
(36, 'jahid', '[{\"id\":3,\"name\":\"Pran Mango Juice-125 ml \",\"quantity\":1,\"totalPrice\":15}]', 15.00, 1, 15.00, 'Cash ', '2025-01-07 15:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Pran Milk(200ml)', 'PRAN UHT milk is a pure & safe cow milk product for the people who want a daily balanced diet and a long healthy life by an elaborate system of HUB based raw milk collection process, initial chilling system, maintaining proper cold chain in transporta ', 80.00, '/milk.png', '2024-12-27 23:55:14'),
(2, 'Pran Fruto(250ml)', 'PRAN FRUIT DRINK is a beverage produced from best mango sources using hot filling and aseptic manufacturing process to provide a healthy drink option. It provides freshness of natural goodness &amp; keeps moment happy. ', 20.00, '/mango_juice_500ml.png', '2024-12-27 23:57:30'),
(3, 'Pran Mango Juice-125 ml ', 'PRAN FRUIT DRINK is a beverage produced from best mango sources using hot filling and aseptic manufacturing process to provide a healthy drink option. It provides freshness of natural goodness &amp; keeps moment happy. ', 15.00, '/6661452e245cbc9913793606_Pran-Mango-Fruit-Drink-1L_1.webp', '2024-12-27 23:59:20'),
(4, 'Pran lacchi(100ml)', 'A flavored drink that provides instant refreshment with the natural taste of sweet litchi', 15.00, '/pran_litchi.png', '2024-12-28 00:01:18'),
(5, 'Potato (1Kg)', 'New Potato per kilo.', 50.00, '/potatoes-scaled.jpg', '2024-12-28 00:02:18'),
(6, 'Onion (1kg)', 'New onion per kg.', 100.00, '/onion-20240422092135.jpg', '2024-12-28 00:03:19'),
(7, 'Sugar(1kg)', 'White Sugar.', 120.00, '/sugar-shutterstock_615908132.jpg', '2024-12-28 00:04:14'),
(8, 'Rice (1kg)', 'Miniket Rice', 100.00, '/Rice_AdobeStock_64819529_E.jpg', '2024-12-28 00:05:16'),
(9, 'Sunflower Oil (5li)', '5 litter big bottle.', 550.00, '/Great-Value-Canola-Oil-1-gal_db929502-7afb-4c4b-a28a-90cd7bae26b8.cea1866b578d97f3313636f17392668c.webp', '2024-12-28 00:08:15'),
(10, 'Oil (1 lit)', 'Pum Oil 1 litter.', 120.00, '/images.jpg', '2024-12-28 00:11:25'),
(11, 'Savlon men', 'savlon men 100 grm', 80.00, '/aci-savlon-men-soap-100-gm.jpg', '2024-12-28 00:22:04'),
(12, 'Mong dal (1Kg)', 'per kg mong dal', 130.00, '/1-premium-moong-mogar-dal-1kg-moong-dal-producer-original-imagfexxumhvqtjh.webp', '2024-12-28 00:23:19'),
(13, 'juice ', 'ddfd', 30.00, '/pran_litchi.png', '2025-01-02 09:14:03'),
(14, 'Juice', '500 ml', 99.98, '/mango_juice_500ml.png', '2025-01-02 09:57:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
