-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2021 at 11:06 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'general'),
(2, 'sport '),
(3, 'engine'),
(8, 'aaa'),
(9, 'bbb');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Username` varchar(40) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `Gender` tinyint(1) DEFAULT NULL,
  `dob` date NOT NULL,
  `AccountStatus` tinyint(1) NOT NULL DEFAULT 1,
  `RegistrationDateTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Username`, `Password`, `FirstName`, `LastName`, `email`, `Gender`, `dob`, `AccountStatus`, `RegistrationDateTime`) VALUES
('777', 'f63f4fbc9f8c85d409f2f59f2b9e12d5', '77', '77', '777@gmail.com', 1, '1999-06-09', 1, '2021-11-30 09:23:05'),
('888', '21218cca77804d2ba1922c33e0151105', '88', '88', '88@gmail.com', 1, '1999-10-20', 1, '2021-11-30 11:10:01'),
('999', '283f42764da6dba2522412916b031080', '99', '99', '99@gmail.com', 1, '1999-06-23', 1, '2021-11-30 11:24:09'),
('eee', 'cd87cd5ef753a06ee79fc75dc7cfe66c', 'ee', 'ee', 'eee@gmail.com', 1, '1999-06-16', 1, '2021-12-20 08:54:06'),
('light', 'fcea920f7412b5da7be0cf42b8c93759', 'li', 'ht', 'light@gmail.com', 1, '2000-06-29', 1, '2021-12-20 08:55:40'),
('lk', 'e10adc3949ba59abbe56e057f20f883e', 'lk', 'lk', 'lk@gmail.com', 1, '2000-02-16', 1, '2021-11-29 05:45:27'),
('wen kang', 'fcea920f7412b5da7be0cf42b8c93759', 'wen', 'kang', 'look@gmail.com', 1, '2000-06-14', 1, '2021-11-30 09:09:07'),
('zackyap', '96e79218965eb72c92a549dd5a330112', 'zack', 'yap', 'zack107@gmail.com', 1, '2000-10-07', 1, '2021-12-01 00:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_date`, `order_id`, `product_id`, `quantity`, `name`) VALUES
('2021-12-08 16:00:00', 1, 1, 0, '777'),
('2021-12-08 16:00:00', 2, 2, 0, '888'),
('2021-12-08 16:00:00', 1, 1, 0, 'wen kang'),
('2021-12-08 16:00:00', 2, 2, 0, 'zackyap'),
('0000-00-00 00:00:00', 22, 6, 2, 'light'),
('0000-00-00 00:00:00', 24, 6, 2, 'zackyap'),
('0000-00-00 00:00:00', 25, 11, 1, '888'),
('0000-00-00 00:00:00', 25, 22, 2, '888'),
('0000-00-00 00:00:00', 25, 5, 3, '888'),
('0000-00-00 00:00:00', 26, 5, 2, 'eee'),
('0000-00-00 00:00:00', 26, 1, 3, 'eee'),
('2021-12-21 09:49:18', 27, 1, 1, 'zackyap'),
('2021-12-21 09:49:18', 27, 2, 2, 'zackyap'),
('2021-12-21 09:49:18', 27, 3, 2, 'zackyap'),
('2021-12-21 09:49:18', 27, 5, 3, 'zackyap'),
('2021-12-22 02:04:32', 28, 6, 1, '777'),
('2021-12-22 02:22:13', 29, 1, 3, '777'),
('2021-12-22 02:22:13', 29, 6, 2, '777'),
('2021-12-22 02:22:13', 29, 2, 1, '777'),
('2021-12-22 04:04:16', 30, 8, 2, 'eee'),
('2021-12-22 04:04:16', 30, 7, 2, 'eee'),
('2021-12-22 04:15:24', 31, 2, 3, 'lk'),
('2021-12-22 04:38:08', 33, 3, 3, '777'),
('2021-12-22 04:38:08', 33, 11, 3, '777'),
('2021-12-22 04:43:35', 34, 3, 3, '777'),
('2021-12-22 04:43:35', 34, 8, 2, '777');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer` varchar(128) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(9,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer`, `product_id`, `quantity`, `total_amount`, `order_date`) VALUES
(1, '777', 1, 1, '0.00', '2021-12-09 01:09:21'),
(2, '777', 2, 2, '0.00', '2021-12-09 01:10:30'),
(22, 'light', 6, 2, '22.70', '2021-12-22 04:53:50'),
(24, 'zackyap', 6, 2, '22.70', '2021-12-22 04:53:37'),
(25, '888', 5, 3, '2891.85', '2021-12-22 04:53:26'),
(26, 'eee', 1, 3, '127.87', '2021-12-22 04:53:14'),
(27, 'zackyap', 5, 3, '67.82', '2021-12-22 04:52:47'),
(28, '777', 6, 1, '11.35', '2021-12-22 04:52:20'),
(29, '777', 2, 1, '148.67', '2021-12-22 04:52:07'),
(30, 'eee', 7, 2, '31.98', '2021-12-22 04:51:48'),
(31, 'lk', 2, 3, '18.00', '2021-12-22 04:51:22'),
(33, '777', 11, 3, '7746.00', '2021-12-22 04:38:08'),
(34, '777', 8, 2, '23.95', '2021-12-22 04:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `category` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `promotion_price` double NOT NULL,
  `manufacture_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `promotion_price`, `manufacture_date`, `expired_date`, `created`, `modified`) VALUES
(1, 'Basketball', 1, 'A ball used in the NBA.', 39.99, 0, '2021-12-01', '2024-11-15', '2015-08-02 12:04:03', '2021-12-11 04:42:31'),
(2, 'Eye Glasses', 2, 'It will make you read better.', 6, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:15:04', '2021-12-01 03:05:59'),
(3, 'Gatorade', 3, 'This is a very good drink for athletes.', 1.99, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:14:29', '2021-12-01 03:06:07'),
(5, 'Trash Can', 2, 'It will help you maintain cleanliness.', 3.95, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:16:08', '2021-12-01 03:06:16'),
(6, 'Mouse', 1, 'Very useful if you love your computer.', 11.35, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:17:58', '2021-12-01 03:06:22'),
(7, 'Earphone', 2, 'You need this one if you love music.', 7, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:18:21', '2021-12-01 03:06:24'),
(8, 'Pillow', 1, 'Sleeping well is important.', 8.99, 0, '0000-00-00', '0000-00-00', '2015-08-02 12:18:56', '2021-12-01 03:06:25'),
(11, 'ad cd', 1, 'HDX2180', 2580, 2000, '2021-11-21', '2021-11-27', '2021-11-02 15:15:08', '2021-12-01 03:06:29'),
(22, 'aa', 8, 'aa', 150, 100, '2021-12-01', '2021-12-23', '2021-12-14 10:26:03', '2021-12-14 09:26:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD KEY `orderdetailFKusername` (`name`),
  ADD KEY `orderdetailIFKorderid` (`order_id`),
  ADD KEY `orderdetailFKproductid` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orderFKp_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryFOREIGNKey` (`category`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetailFKproductid` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orderdetailFKusername` FOREIGN KEY (`name`) REFERENCES `customers` (`Username`),
  ADD CONSTRAINT `orderdetailIFKorderid` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orderFKp_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categoryFOREIGNKey` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
