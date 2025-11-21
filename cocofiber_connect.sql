-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 07:44 AM
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
-- Database: `cocofiber_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role_as` varchar(10) DEFAULT 'admin',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `phone`, `role_as`, `password`) VALUES
(1, 'khushali', 'khushalihadvni22@gmail.com', '9898844958', 'admin', '$2y$10$Va3QA6XdcITmJI.rMAvu2OIx00FnEJWqKGYZn884QQY11aYAZC1f2');

-- --------------------------------------------------------

--
-- Table structure for table `business_hours`
--

CREATE TABLE `business_hours` (
  `id` int(11) NOT NULL,
  `day` varchar(50) DEFAULT NULL,
  `hours` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_hours`
--

INSERT INTO `business_hours` (`id`, `day`, `hours`) VALUES
(1, 'Monday - Friday', '8:00 AM - 6:00 PM'),
(2, 'Saturday', '9:00 AM - 2:00 PM'),
(3, 'Sunday', 'Closed');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `created_at`) VALUES
(1, 'Coir Disk', '2025-08-01 03:40:29'),
(2, 'Coir Blocks', '2025-08-01 03:40:29'),
(3, 'Coir Pots', '2025-08-01 03:40:29'),
(4, 'Coir Mats', '2025-08-01 03:40:29'),
(5, 'Coir Rope', '2025-08-01 03:40:29'),
(6, 'Coir Geo Textiles', '2025-08-01 03:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `company_story`
--

CREATE TABLE `company_story` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_story`
--

INSERT INTO `company_story` (`id`, `title`, `image`, `description`) VALUES
(1, ' From Humble Beginnings to Global Impact', 'main2.jpg', 'Founded in 2022,The journey of CocoFiber Connect began with a deep respect for nature and a desire to make a positive impact on both people and the planet. It all started when our founders visited coconut-growing communities and realized that tons of coconut husks were being discarded as waste every year.\r\n\r\nWhat seemed like waste to many, we saw as a hidden opportunity — an opportunity to create something sustainable, valuable, and environmentally friendly. That’s when the idea of CocoFiber Connect was born — a digital bridge connecting local coconut fiber producers with global markets.\r\n\r\n     CocoFiber Connect stands as a trusted marketplace where sellers and buyers come together to promote eco-friendly trade. From small village workshops to international buyers.');

-- --------------------------------------------------------

--
-- Table structure for table `contact_footer`
--

CREATE TABLE `contact_footer` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_footer`
--

INSERT INTO `contact_footer` (`id`, `email`, `phone`, `address`) VALUES
(1, 'hello@cocofiber.com', '+91 9898610202', 'Global Headquarters: 123 Fiber Ave, Tech City');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `headquarters` text DEFAULT NULL,
  `phone_main` varchar(50) DEFAULT NULL,
  `phone_support` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email_general` varchar(100) DEFAULT NULL,
  `email_support` varchar(100) DEFAULT NULL,
  `email_sales` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `headquarters`, `phone_main`, `phone_support`, `fax`, `email_general`, `email_support`, `email_sales`) VALUES
(1, '123 Fiber Street,\r\nEco Park District,\r\nManila, Philippines 1000', '+63 2 123 4567', '+63 917 123 4567', '+63 2 123 4568', 'info@cocofiberconnect.com', 'support@cocofiberconnect.com', 'sales@cocofiberconnect.com');

-- --------------------------------------------------------

--
-- Table structure for table `contact_review`
--

CREATE TABLE `contact_review` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(150) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_review`
--

INSERT INTO `contact_review` (`id`, `name`, `title`, `rating`, `review`, `submitted_at`) VALUES
(1, 'khushi', 'fiber', 5, 'fedfcds', '2025-09-30 09:33:54'),
(12, 'radha', 'fiber', 5, 'good', '2025-11-16 14:50:52');

-- --------------------------------------------------------

--
-- Table structure for table `core_values`
--

CREATE TABLE `core_values` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `core_values`
--

INSERT INTO `core_values` (`id`, `title`, `description`) VALUES
(1, 'Sustainability', 'We are committed to environmental stewardship, transforming waste (coconut husks) into valuable, eco-friendly resources and prioritizing long-term ecological balance.'),
(2, 'Community', 'We foster empowerment and growth for the people we serve. We act as a trusted digital bridge, directly connecting local producers with global markets to ensure fair trade and socio-economic benefit.'),
(3, 'Integrity', 'We operate with honesty, transparency, and ethical conduct in every transaction. Our foundation is built on earning and maintaining the trust of our farmers, customers, and partners worldwide.'),
(4, 'Excellence', 'We strive for the highest quality in our products and operations, turning every obstacle into a milestone. We are committed to delivering outstanding results and global impact, from the lab to our half-million customers.');

-- --------------------------------------------------------

--
-- Table structure for table `fiber`
--

CREATE TABLE `fiber` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `fiber_type` varchar(100) NOT NULL,
  `quantity_kg` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fiber`
--

INSERT INTO `fiber` (`id`, `username`, `email`, `phone_no`, `fiber_type`, `quantity_kg`, `description`, `image`, `price_per_kg`, `location`, `created_at`) VALUES
(1, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'brown', 10, 'fiber', 'uploads/1755084851_images1.jpg', 15.00, 'rajkot', '2025-08-13 11:34:11'),
(9, 'radha', 'radha@gmail.com', '9898844958', 'brown', 10, 'good', 'uploads/1757167958_main.png', 20.00, 'rajkot', '2025-09-06 14:12:38'),
(10, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'white', 20, 'good fiber', 'uploads/1758882487_main.png', 20.00, 'rajkot', '2025-09-26 10:28:07'),
(11, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'white', 20, 'good fiber', 'uploads/1758882677_main.png', 20.00, 'rajkot', '2025-09-26 10:31:17'),
(12, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'white', 20, 'good fiber', 'uploads/1758970504_main.png', 20.00, 'rajkot', '2025-09-27 10:55:04'),
(13, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'white', 20, 'fiber', 'uploads/1763304273_main.png', 20.00, 'rajkot', '2025-11-16 14:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `hero_section`
--

CREATE TABLE `hero_section` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hero_section`
--

INSERT INTO `hero_section` (`id`, `title`, `subtitle`, `image`) VALUES
(1, 'Connecting Coconut Fiber Suppliers & Buyers Worldwide', 'A sustainable marketplace for high-quality coconut fiber products direct from producers.', 'first.png');

-- --------------------------------------------------------

--
-- Table structure for table `how_it_works`
--

CREATE TABLE `how_it_works` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `how_it_works`
--

INSERT INTO `how_it_works` (`id`, `image`, `title`, `description`) VALUES
(1, '1756921075_register.png', 'Register as Supplier or Buyer', 'Create your profile to start connecting with trusted partners in the coconut fiber industry.'),
(2, '1756921107_list.png', 'List Your Products', 'Showcase your coconut fiber products with detailed descriptions and certifications.'),
(3, '1756921138_secure.png', 'Secure Transactions', 'Communicate and close deals directly with verified buyers and suppliers through our platform.');

-- --------------------------------------------------------

--
-- Table structure for table `mission_vision`
--

CREATE TABLE `mission_vision` (
  `id` int(11) NOT NULL,
  `type` enum('mission','vision') NOT NULL,
  `icon` varchar(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mission_vision`
--

INSERT INTO `mission_vision` (`id`, `type`, `icon`, `title`, `description`) VALUES
(1, 'mission', '🔌', 'Our Mission', 'To empower coconut-growing communities by providing a trusted digital marketplace that connects local producers with global markets, utilizing coconut fiber as a sustainable, high-quality material for fiber optic insulation, thereby championing environmental stewardship and driving a new era of eco-conscious trade.'),
(2, 'vision', '🌐', 'Our Vision', 'To be the global leader in sustainable connectivity and material sourcing, transforming every discarded coconut husk into a valuable, eco-friendly resource and fully bridging the digital divide for coastal communities worldwide.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_image` varchar(255) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(150) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_address` text NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `payment_method` enum('Cash on Delivery','UPI') NOT NULL,
  `googlepay_id` varchar(100) DEFAULT NULL,
  `payment_status` enum('otp_pending','cod_pending','paid','failed') DEFAULT 'cod_pending',
  `otp_sent_at` datetime DEFAULT NULL,
  `otp_last_error` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `item_name`, `item_image`, `item_price`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `quantity`, `payment_method`, `googlepay_id`, `payment_status`, `otp_sent_at`, `otp_last_error`, `created_at`) VALUES
(34, 'Coir Blocks', 'img12.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 14:05:27', NULL, '2025-09-29 08:27:31'),
(35, 'Coir Pots', 'img22.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 14:44:04', NULL, '2025-09-29 08:35:26'),
(36, 'Coir Blocks', 'img12.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 14:44:05', NULL, '2025-09-29 08:35:26'),
(37, 'Coir Blocks', 'img11.jpg', 180.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 3, '', 'upi123@UPI', 'otp_pending', '2025-09-29 14:44:06', 'The requested resource /v2/Services/VAf58c1c7934bc4b8059777abde24cb69c/VerificationCheck was not found', '2025-09-29 09:14:02'),
(38, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', '2025-09-29 15:02:33', 'The requested resource /v2/Services/VAf58c1c7934bc4b8059777abde24cb69c/VerificationCheck was not found', '2025-09-29 09:28:59'),
(39, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', '2025-09-29 15:02:33', 'The requested resource /v2/Services/VAf58c1c7934bc4b8059777abde24cb69c/VerificationCheck was not found', '2025-09-29 09:32:16'),
(40, 'Coir Pots', 'img21.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 15:07:41', NULL, '2025-09-29 09:36:58'),
(41, 'Coir Pots', 'img21.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 09:38:19'),
(42, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 09:41:09'),
(43, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 15:23:36', NULL, '2025-09-29 09:53:34'),
(44, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 09:54:10'),
(45, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 09:56:14'),
(46, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 09:59:48'),
(47, 'Coir Disk', 'img1.jpg', 120.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 3, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 10:03:41'),
(48, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 10:05:08'),
(49, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-09-29 10:12:36'),
(50, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:18:03'),
(51, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:19:50'),
(52, 'Coir Disk', 'img2.jpg', 50.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:20:24'),
(53, 'Coir Pots', 'img21.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, 'Cash on Delivery', '', 'cod_pending', '2025-09-29 12:24:06', NULL, '2025-09-29 10:24:06'),
(54, 'Coir Pots', 'img21.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:27:17'),
(55, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:29:52'),
(56, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:34:10'),
(57, 'Coir Pots', 'img21.jpg', 90.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:34:10'),
(58, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:38:08'),
(59, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvni22@gmail.com', '8320125951', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 10:52:44'),
(60, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvn@gmail.com', '8320125951', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 11:03:35'),
(61, 'Coir Blocks', 'img11.jpg', 60.00, 'khushi', 'khushalihadvn@gmail.com', '8320125951', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 11:04:36'),
(62, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvn@gmail.com', '8320125951', 'rajkot', 1, '', 'upi123@UPI', 'otp_pending', NULL, NULL, '2025-09-29 11:05:33'),
(63, 'Coir Disk', 'img1.jpg', 40.00, 'khushi', 'khushalihadvni22@gmail.com', '8320125951', 'rajkot', 1, '', 'upi123@UPI', 'paid', '2025-09-29 16:36:29', NULL, '2025-09-29 11:06:26'),
(64, 'Coir Blocks', 'img11.jpg', 120.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 2, 'Cash on Delivery', '', 'cod_pending', NULL, NULL, '2025-11-16 14:42:16'),
(65, 'Coir Blocks', 'img11.jpg', 300.00, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', 'rajkot', 5, 'Cash on Delivery', '', 'cod_pending', '2025-11-16 15:43:00', NULL, '2025-11-16 14:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'In_stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_name`, `pname`, `description`, `price`, `image`, `status`) VALUES
(1, 'Coir Disk', 'Coir Disk', 'Coir Disks are natural, biodegradable growing mediums made from compressed coconut coir fibers ', 40.00, 'img1.jpg', 'In_stock'),
(2, 'Coir Blocks', 'Coir Blocks', 'Our Coir Blocks are made from 100% natural, compressed coconut husk fibers — an eco-friendly alternative to peat moss', 60.00, 'img11.jpg', 'In_stock'),
(3, 'Coir Pots', 'Coir Pots', 'Grow greener with our Coir Pots, made from 100% natural coconut fibers', 90.00, 'img21.jpg', 'In_stock'),
(4, 'Coir Mats', 'Coir Mats', 'Our Coir Mats are crafted from 100% natural coconut husk fibers, offering a perfect blend of durability, functionality, and sustainability', 110.00, 'img31.jpg', 'In_stock'),
(5, 'Coir Rope', 'Coir Rope', 'Made from high-quality coconut husk fibers, our Coir Rope is a durable, eco-friendly solution for a wide range of applications', 80.00, 'img41.jpg', 'In_stock'),
(6, 'Coir Geo Textiles', 'Coir Geo Textiles', 'Coir Geotextile is a woven, biodegradable fabric made from 100% natural coconut coir fiber', 120.00, 'img51.jpg', 'In_stock'),
(7, 'Coir Disk', 'Coir Disk', 'These disks expand upon watering and create a soft, nutrient-rich base ideal for seed germination and plant growth', 50.00, 'img2.jpg', 'In_stock'),
(8, 'Coir Blocks', 'Coir Blocks', 'Coir Blocks are compressed bricks made from coconut husk fibers, designed to expand into fluffy, moisture-retentive coco peat when water is added', 90.00, 'img12.jpg', 'In_stock'),
(9, 'Coir Pots', 'Coir Pots', 'Coir Pots are eco-friendly plant containers made from molded coconut fiber and natural latex.', 90.00, 'img22.jpg', 'In_stock'),
(10, 'Coir Mats', 'Coir Mats', 'Coir Mats are flat, woven or needle-felted mats made from natural coconut fiber.', 150.00, 'img32.jpg', 'In_stock'),
(11, 'Coir Rope', 'Coir Rope', 'Coir Rope is made by twisting coconut husk fibers into a strong, biodegradable rope.', 100.00, 'img42.jpg', 'In_stock'),
(12, 'Coir Geo Textiles', 'Coir Geo Textiles', 'Coir Geotextiles are woven fabrics made from coconut coir yarn, soil stabilization, re-vegetation in civil engineering and landscaping projects', 140.00, 'img52.jpg', 'In_stock'),
(13, 'Coir Disk', 'Coir Disk', 'They retain moisture efficiently and promote excellent root aeration, making them an eco-friendly and mess-free alternative to soil.', 30.00, 'img3.jpg', 'In_stock'),
(14, 'Coir Blocks', 'Coir Blocks', '100% organic and peat-free.Expands up to 10x in volume', 70.00, 'img13.jpg', 'In_stock'),
(15, 'Coir Pots', 'Coir Pots', 'No repotting required—plant the entire pot', 170.00, 'img23.jpg', 'In_stock'),
(16, 'Coir Mats', 'Coir Mats', 'These breathable mats support healthy soil and plant conditions while being fully biodegradable.', 170.00, 'img33.jpg', 'In_stock'),
(17, 'Coir Rope', 'Coir Rope', 'It is used widely in gardening, agriculture, handicrafts, marine applications, and construction.', 100.00, 'img43.jpg', 'In_stock'),
(18, 'Coir Geo Textiles', 'Coir Geo Textiles', 'Allows water infiltration and vegetation growth', 100.00, 'img53.jpg', 'In_stock'),
(19, 'Coir Disk', 'Coir Disk', 'Whether you are a home gardener or a professional grower, our coir disks are a clean, mess-free, and eco-friendly solution for healthy root development.', 50.00, 'img4.jpg', 'In_stock'),
(20, 'Coir Blocks', 'Coir Blocks', 'Ideal for gardening, horticulture, hydroponics, and landscaping, these blocks are a sustainable solution for all your planting needs.', 100.00, 'img14.jpg', 'In_stock'),
(21, 'Coir Pots', 'Coir Pots', 'Ideal for seedlings, herbs, flowers, and small plants, coir pots promote strong root growth and decompose naturally, enriching the soil as they break down.', 90.00, 'img24.jpg', 'In_stock'),
(22, 'Coir Mats', 'Coir Mats', 'Strong & Durable – Withstands daily wear, UV rays, and weather exposure', 190.00, 'img34.jpg', 'In_stock'),
(23, 'Coir Rope', 'Coir Rope', 'Tough & Long-Lasting – Strong tensile strength for heavy-duty use', 70.00, 'img44.jpg', 'In_stock'),
(24, 'Coir Geo Textiles', 'Coir Geo Textiles', 'Superior Soil Stabilization – Ideal for slopes, riverbanks, embankments & mines', 170.00, 'img54.jpg', 'In_stock'),
(25, 'Coir Disk', 'Coir Disk', 'pH balanced and eco-friendly. Promotes strong root growth', 60.00, 'img5.jpg', 'In_stock'),
(26, 'Coir Blocks', 'Coir Blocks', 'Multipurpose Use – Perfect for seed starting, potting mix, composting, and more', 80.00, 'img15.jpg', 'In_stock'),
(27, 'Coir Pots', 'Coir Pots', 'Good Water Retention & Drainage – Prevents overwatering and supports healthy roots', 180.00, 'img25.jpg', 'In_stock'),
(28, 'Coir Mats', 'Coir Mats', 'Multipurpose Use – Ideal for garden beds, basket liners, pet bedding, erosion control, and decorative applications', 150.00, 'img35.jpg', 'In_stock'),
(29, 'Coir Geo Textiles', 'Coir Geo Textiles', 'These eco-safe textiles allow plant growth and decompose naturally into the soil.', 110.00, 'img55.jpg', 'In_stock'),
(30, 'Coir Disk', 'Coir Disk', 'Perfect for seed starting and plant propagation, these disks expand when watered, providing excellent moisture retention and aeration for healthy root development.', 60.00, 'img6.jpg', 'In_stock'),
(31, 'Coir Blocks', 'Coir Blocks', 'Ideal for gardening, horticulture, hydroponics, and landscaping, these blocks are a sustainable solution for all your planting needs.', 100.00, 'img16.jpg', 'In_stock'),
(32, 'Coir Pots', 'Coir Pots', 'Ideal for seedlings, herbs, flowers, and small plants, coir pots promote strong root growth and decompose naturally, enriching the soil as they break down.', 90.00, 'img26.jpg', 'In_stock'),
(33, 'Coir Mats', 'Coir Mats', 'Strong & Durable – Withstands daily wear, UV rays, and weather exposure', 190.00, 'img36.jpg', 'In_stock'),
(34, 'Coir Rope', 'Coir Rope', 'Tough & Long-Lasting – Strong tensile strength for heavy-duty use', 70.00, 'img46.jpg', 'In_stock'),
(35, 'Coir Geo Textiles', 'Coir Geo Textiles', 'Superior Soil Stabilization – Ideal for slopes, riverbanks, embankments & mines', 170.00, 'img56.jpg', 'In_stock'),
(36, 'Coir Rope', 'Coir Rope', 'Tough & Long-Lasting – Strong tensile strength for heavy-duty use', 70.00, 'img55.jpg', 'In_stock');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `username`, `email`, `phone`, `password`) VALUES
(1, 'khushi', 'khushalihadvni22@gmail.com', '9898844958', '$2y$10$UUb1ATS2PidqlcdKthJ3weDuEr7ePhLHH8qdYWsqCX91PcV7T.gFK'),
(3, 'radha', 'radha@gmail.com', '9898844958', '$2y$10$BIc7OYJcOgXbdCPNUDZf0usEG49pvUhPJrkvRotkBm13zUsatO576'),
(4, 'kashish', 'kashishgohel@29gmail.com', '9898844958', '$2y$10$JIxIcLsu4ikkokMzyjGoE.lpA.k5BClutqYY6rX/Wnw9XRbm2T3eC'),
(5, 'khushali', 'khushalihadvni222@gmail.com', '9898844958', '$2y$10$sFgu9rRBOFQaeBHjOgJWausjFlyNx67Hr6N5uDISB9QkEuc/NYvMK');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `name`, `designation`, `message`, `image`, `rating`, `created_at`) VALUES
(1, 'Maria Santos', 'Director, EcoFabrics Inc.', '\"CocoFiber Connect has transformed our manufacturing process. Their coco fiber products are the highest quality we\'ve found, and their customer service is exceptional.\"', '1756892684_img1.png', 5, '2025-09-03 09:44:44'),
(3, 'James Wilson', 'Founder, GreenDesign Studios', '\"As a sustainable furniture designer, I rely on CocoFiber Connect for consistent, eco-friendly materials. Their technical expertise has helped me innovate new product lines.\"', '1756892797_img2.png', 5, '2025-09-03 09:46:37'),
(4, 'Aiza Hernandez', 'CEO, EarthTextiles Philippines', '\"The durability and versatility of CocoFiber products exceeded our expectations. Their team is knowledgeable and always available to provide solutions.\"', '1756892826_img3.png', 5, '2025-09-03 09:47:06');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `platform`, `url`, `icon`) VALUES
(1, 'Facebook', 'https://www.facebook.com/CocoFiberConnect', 'css/facebook.png'),
(2, 'Twitter', 'https://twitter.com/CocoFiberConnect', 'css/twitter.png'),
(3, 'Instagram', 'https://www.instagram.com/CocoFiberConnect', 'css/instagram.jpg'),
(4, 'LinkedIn', 'https://www.linkedin.com/company/cocofiberconnect', 'css/linkedin.png');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_benefits`
--

CREATE TABLE `sourcing_benefits` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sourcing_benefits`
--

INSERT INTO `sourcing_benefits` (`id`, `title`, `description`, `icon`, `created_at`) VALUES
(2, 'Sustainable Sourcing', 'Direct partnerships with coconut farmers ensuring ethical harvesting and fair compensation.', '🌱', '2025-09-06 12:43:49'),
(3, 'Industrial Quality', '\r\nGraded fibers suitable for manufacturing, textiles, and construction applications.', '🏭', '2025-09-06 13:01:23'),
(4, 'Global Logistics', '\r\nEfficient processing and shipping infrastructure to meet worldwide demand.', '🌎', '2025-09-06 13:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_hero`
--

CREATE TABLE `sourcing_hero` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sourcing_hero`
--

INSERT INTO `sourcing_hero` (`id`, `title`, `subtitle`, `image`, `created_at`) VALUES
(1, 'Sustainable Cocofiber Sourcing', 'Connecting eco-conscious manufacturers with premium quality coconut fiber from ethical sources across the tropics.', 'hero_1757162354.png', '2025-09-06 12:39:14');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_inquiries`
--

CREATE TABLE `sourcing_inquiries` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `estimated_monthly_volume` varchar(100) NOT NULL,
  `additional_requirement` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sourcing_inquiries`
--

INSERT INTO `sourcing_inquiries` (`id`, `company_name`, `contact_person`, `email_address`, `phone_number`, `estimated_monthly_volume`, `additional_requirement`, `submitted_at`) VALUES
(1, 'coco', 'radha', 'radha@gmail.com', '01234567891', '2000-5000', 'fiber', '2025-08-13 12:02:25'),
(2, 'coco', 'khushi', 'radha@gmail.com', '01234567891', '500-2000', 'fiber', '2025-09-30 09:43:02'),
(3, 'coco', 'radha', 'radha@gmail.com', '01234567891', '500-2000', 'good', '2025-11-16 14:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_process`
--

CREATE TABLE `sourcing_process` (
  `id` int(11) NOT NULL,
  `step_number` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sourcing_process`
--

INSERT INTO `sourcing_process` (`id`, `step_number`, `title`, `description`, `created_at`) VALUES
(1, 1, ' Farm Partnership', 'Identifying and vetting coconut farms', '2025-09-06 12:46:32'),
(2, 2, 'Harvesting', ' Sustainable collection methods', '2025-09-06 12:46:51'),
(3, 3, 'Processing ', 'Cleaning and quality grading', '2025-09-06 12:47:09'),
(4, 4, 'Shipping ', 'Eco-friendly packaging & transport', '2025-09-06 12:47:26'),
(5, 5, 'Delivery ', 'To your manufacturing facility', '2025-09-06 12:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `sourcing_quality`
--

CREATE TABLE `sourcing_quality` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sourcing_quality`
--

INSERT INTO `sourcing_quality` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'Fiber Length Grading', ' Precision sorting into 3 categories (long, medium, short) for different applications.', '2025-09-06 12:50:37'),
(2, 'Moisture Content', ' Strict <10% moisture levels maintained through climate-controlled storage.', '2025-09-06 12:50:57'),
(3, 'Impurity Levels', ' Mechanical and manual cleaning processes ensure <2% foreign matter.', '2025-09-06 12:51:16'),
(4, 'Strength Testing', ' Batch testing for tensile strength and durability metrics.', '2025-09-06 12:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(150) NOT NULL,
  `image` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `image`, `message`) VALUES
(1, 'James Wilson', 'Small Business Owner', 'img4.png', '\"A powerful driver of social change: CocoFiber Connect\'s sustainable model uses a locally-rooted product to bridge the digital divide, proving that business is key to community empowerment.\"'),
(2, 'Fatima Ali', 'Director, Education NGO', 'img5.png', '\"CocoFiber Connect is a powerful driver of social change. Their mission to bridge the digital divide has a life-changing impact, ensuring connectivity reaches youth in remote villages. By using a product rooted in the local economy, their model proves that sustainable business is key to community empowerment.\"'),
(3, 'Mark Johnson', 'Sustainability Consultant', 'img6.png', '\"CocoFiber Connect is a blueprint for excellence in industrial innovation. They solve a major sustainability challenge by transforming agricultural waste into a high-performing, commercially viable product. Their model demonstrates true integrity, reducing waste and displacing high-carbon synthetic materials.\"');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `pname`, `price`, `image`, `added_on`) VALUES
(5, 3, 1, 'Coir Disk', 40.00, 'img1.jpg', '2025-08-19 10:35:03'),
(7, 1, 2, 'Coir Blocks', 60.00, 'img11.jpg', '2025-08-23 11:46:41'),
(8, 3, 2, 'Coir Blocks', 60.00, 'img11.jpg', '2025-09-06 14:13:32'),
(14, 1, 1, 'Coir Disk', 40.00, 'img1.jpg', '2025-09-26 10:15:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_user` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `company_story`
--
ALTER TABLE `company_story`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_footer`
--
ALTER TABLE `contact_footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_review`
--
ALTER TABLE `contact_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `core_values`
--
ALTER TABLE `core_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fiber`
--
ALTER TABLE `fiber`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_fiber_email` (`email`);

--
-- Indexes for table `hero_section`
--
ALTER TABLE `hero_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `how_it_works`
--
ALTER TABLE `how_it_works`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mission_vision`
--
ALTER TABLE `mission_vision`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_fk_customer_email` (`customer_email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category_name` (`category_name`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourcing_benefits`
--
ALTER TABLE `sourcing_benefits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourcing_hero`
--
ALTER TABLE `sourcing_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourcing_inquiries`
--
ALTER TABLE `sourcing_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourcing_process`
--
ALTER TABLE `sourcing_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sourcing_quality`
--
ALTER TABLE `sourcing_quality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wishlist_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `business_hours`
--
ALTER TABLE `business_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `company_story`
--
ALTER TABLE `company_story`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_footer`
--
ALTER TABLE `contact_footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_review`
--
ALTER TABLE `contact_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `core_values`
--
ALTER TABLE `core_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fiber`
--
ALTER TABLE `fiber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hero_section`
--
ALTER TABLE `hero_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `how_it_works`
--
ALTER TABLE `how_it_works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mission_vision`
--
ALTER TABLE `mission_vision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sourcing_benefits`
--
ALTER TABLE `sourcing_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sourcing_hero`
--
ALTER TABLE `sourcing_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sourcing_inquiries`
--
ALTER TABLE `sourcing_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sourcing_process`
--
ALTER TABLE `sourcing_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sourcing_quality`
--
ALTER TABLE `sourcing_quality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fiber`
--
ALTER TABLE `fiber`
  ADD CONSTRAINT `fk_fiber_email` FOREIGN KEY (`email`) REFERENCES `registration` (`email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `registration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
