-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 07:24 PM
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
-- Database: `eatbites`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `category` enum('western','local','desserts','sides','drinks') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `price`, `category`, `image`, `status`) VALUES
(1, 'Chicken Chop', 'Grilled chicken with sauce', 15.00, 'western', 'chicken.jpg', 'available'),
(2, 'Nasi Lemak', 'Traditional Malaysian dish', 8.00, 'local', 'nasilemak.jpg', 'available'),
(3, 'Chocolate Cake', 'Rich chocolate dessert', 6.50, 'desserts', 'cake.jpg', 'available'),
(4, 'French Fries', 'Crispy fries', 4.00, 'sides', 'fries.jpg', 'available'),
(5, 'Iced Lemon Tea', 'Refreshing drink', 3.00, 'drinks', 'lemontea.jpg', 'available'),
(6, 'Fish and Chips', 'Crispy battered fish with fries', 14.00, 'western', 'fishchips.jpg', 'available'),
(7, 'Chicken Burger', 'Crispy chicken fillet with special sauce', 10.50, 'western', 'chickenburger.jpg', 'available'),
(8, 'Beef Burger', 'Juicy beef patty with cheese and lettuce', 12.00, 'western', 'beefburger.jpg', 'available'),
(9, 'Spaghetti Carbonara', 'Creamy pasta with beef bacon', 13.00, 'western', 'carbonara.jpg', 'available'),
(10, 'Grilled Lamb Chop', 'Tender lamb chop with black pepper sauce', 18.00, 'western', 'lambchop.jpg', 'available'),
(11, 'Nasi Ayam', 'Steamed rice with roasted chicken and sauce', 9.50, 'local', 'nasiayam.jpg', 'available'),
(12, 'Laksa', 'Spicy coconut noodle soup', 10.00, 'local', 'laksa.jpg', 'available'),
(13, 'Char Kuey Teow', 'Stir-fried flat noodles with egg and prawns', 11.00, 'local', 'charkueyteow.jpg', 'available'),
(14, 'Mee Goreng', 'Spicy fried noodles with vegetables', 8.50, 'local', 'meegoreng.jpg', 'available'),
(15, 'Roti Canai', 'Flaky flatbread served with curry', 3.00, 'local', 'roticanai.jpg', 'available'),
(16, 'Tiramisu', 'Coffee-flavored Italian dessert', 7.50, 'desserts', 'tiramisu.jpg', 'available'),
(17, 'Cheesecake', 'Creamy cheesecake with biscuit base', 7.00, 'desserts', 'cheesecake.jpg', 'available'),
(18, 'Pancakes', 'Fluffy pancakes with maple syrup', 6.50, 'desserts', 'pancakes.jpg', 'available'),
(19, 'Waffle', 'Crispy waffle topped with chocolate sauce', 7.00, 'desserts', 'waffle.jpg', 'available'),
(20, 'Pavlova', 'Meringue-based dessert with fresh fruits', 5.50, 'desserts', 'pavlova.jpg', 'available'),
(21, 'Mozzarella Sticks', 'Cheesy sticks with marinara sauce', 6.00, 'sides', 'mozarellasticks.jpg', 'available'),
(22, 'Chicken Nuggets', 'Crispy chicken nuggets', 6.00, 'sides', 'chickennuggets.jpg', 'available'),
(23, 'Garlic Bread', 'Toasted bread with garlic butter', 4.00, 'sides', 'garlicbread.jpg', 'available'),
(24, 'Coleslaw', 'Fresh cabbage salad with creamy dressing', 3.50, 'sides', 'coleslaw.jpg', 'available'),
(25, 'Nachos', 'Crispy tortilla chips with cheese and salsa', 4.50, 'sides', 'nachos.jpg', 'available'),
(26, 'Mango Smoothie', 'fresh mango blended with yogurt', 6.00, 'drinks', 'mangosmoothie.jpg', 'available'),
(27, 'Iced Coffee', 'Cold brewed coffee with milk', 4.50, 'drinks', 'icedcoffee.jpg', 'available'),
(28, 'Hot Coffee', 'Freshly brewed hot coffee', 3.50, 'drinks', 'hotcoffee.jpg', 'available'),
(29, 'Green Tea', 'Hot green tea', 2.50, 'drinks', 'greentea.jpg', 'available'),
(30, 'Milk Tea', 'Classic milk tea', 4.00, 'drinks', 'milktea.jpg', 'available'),
(31, 'Chocolate Milkshake', 'Creamy chocolate milkshake', 5.50, 'drinks', 'chocolatemilkshake.jpg', 'available'),
(32, 'Strawberry Milkshake', 'Creamy strawberry milkshake', 5.50, 'drinks', 'strawberrymilkshake.jpg', 'available'),
(33, 'Orange Juice', 'Freshly squeezed orange juice', 4.00, 'drinks', 'orangejuice.jpg', 'available'),
(34, 'Mineral Water', 'Bottled mineral water', 2.00, 'drinks', 'water.jpg', 'available'),
(35, 'Soft Drink', 'Chilled carbonated beverage', 3.00, 'drinks', 'softdrink.jpg', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `table_no` varchar(10) DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `order_status` enum('pending','preparing','completed','canceled') DEFAULT 'pending',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `order_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `phone`, `table_no`, `total_price`, `order_status`, `payment_status`, `order_time`) VALUES
(2, 'zulaika', '01162079120', '12', 17.50, 'completed', 'Paid', '2026-01-19 23:19:42'),
(4, 'aa', 'aa', 'a', 13.00, 'canceled', 'Unpaid', '2026-01-20 00:05:49'),
(5, 'amil', '01162079120', '13', 13.00, 'completed', 'Paid', '2026-01-20 00:14:57'),
(8, 'muhammad syahmi', '01162079120', '20', 79.00, 'completed', 'Paid', '2026-01-20 05:42:52'),
(9, 'Lee Kwang Soo', '0178804989', '10', 46.00, 'completed', 'Unpaid', '2026-01-20 06:33:59'),
(10, 'yusuf', '011633025', '26', 56.50, 'pending', 'Unpaid', '2026-01-20 06:59:46'),
(11, 'amil', '0108218802', '1', 12.00, 'pending', 'Unpaid', '2026-01-20 07:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `menu_name` varchar(100) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL,
  `item_status` enum('pending','completed','canceled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `menu_name`, `price`, `quantity`, `subtotal`, `item_status`) VALUES
(3, 2, 5, 'Iced Lemon Tea', 3.00, 1, 3.00, 'completed'),
(4, 2, 2, 'Nasi Lemak', 8.00, 1, 8.00, 'completed'),
(5, 2, 3, 'Chocolate Cake', 6.50, 1, 6.50, 'completed'),
(9, 4, 3, 'Chocolate Cake', 6.50, 2, 13.00, 'canceled'),
(10, 5, 1, 'Chicken Chop', 15.00, 2, 30.00, 'canceled'),
(11, 5, 2, 'Nasi Lemak', 8.00, 1, 8.00, 'canceled'),
(12, 5, 3, 'Chocolate Cake', 6.50, 2, 13.00, 'completed'),
(15, 8, 9, 'Spaghetti Carbonara', 13.00, 2, 26.00, 'completed'),
(16, 8, 7, 'Chicken Burger', 10.50, 2, 21.00, 'completed'),
(17, 8, 24, 'Coleslaw', 3.50, 2, 7.00, 'completed'),
(18, 8, 30, 'Milk Tea', 4.00, 1, 4.00, 'completed'),
(19, 9, 2, 'Nasi Lemak', 8.00, 1, 8.00, 'completed'),
(20, 9, 10, 'Grilled Lamb Chop', 18.00, 1, 18.00, 'completed'),
(21, 9, 12, 'Laksa', 10.00, 2, 20.00, 'completed'),
(22, 10, 2, 'Nasi Lemak', 8.00, 2, 16.00, 'pending'),
(23, 10, 5, 'Iced Lemon Tea', 3.00, 2, 6.00, 'pending'),
(24, 10, 20, 'Pavlova', 5.50, 3, 16.50, 'pending'),
(25, 10, 22, 'Chicken Nuggets', 6.00, 3, 18.00, 'pending'),
(26, 11, 26, 'Mango Smoothie', 6.00, 2, 12.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `email`, `address`, `password_hash`, `status`) VALUES
(1, 'Amna Badariah', '01162079120', 'amna@gmail.com', 'D2-42-7, BLOK D2 RESIDENSI BANDAR RAZAK, JALAN RAZAK MANSION, SUNGAI BESI', '$2y$10$Y78h1Cxk/WBQO9QWf.87rOR0abV0nDDCuykA6AkOla3Gz.VHyzm5a', 'admin'),
(2, 'Nur Amalin', '0108218802', 'amalin@gmail.com', 'NO 37, JALAN NIRWANA 39', '$2y$10$HeXJmZsbaKnx1SslQORhDeuwhyvONdWChCVYahv1Cttkvvrtuo3Xq', 'kitchen'),
(3, 'aliffah ikramiena', '01162079120', 'iffah@gmail.com', 'NO 37, JALAN NIRWANA 39', '$2y$10$9/glZEYEslAhTKGCAjRlzuyQSCdGeUEzM4NhU87aWXmb832DODRxy', 'kitchen'),
(5, 'Fatin Nur Zulaika', '0178804989', 'zula@gmail.com', 'rumah e pokteh, uitm machang', '$2y$10$tnYghPmy4NbqydMADb31b.bzVKKMt9GhQrXpvPT0LsfOIaQ6txV5y', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
