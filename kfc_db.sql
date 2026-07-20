-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2026 at 04:19 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kfc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` varchar(10) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` double NOT NULL,
  `menu_image` text NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_price`, `menu_image`, `type_id`) VALUES
('1', 'ชุดซิงเกอร์เบอร์เกอร์', 67, 'https://images.ctfassets.net/n4pc9wlortyn/6xIGgEQ7eJdaKdTRSUGajq/6cb51e9d63e6f7982aae7d01038465c1/JPU_Zinger_Set_480x388.png?h=600&w=800&fm=webp&fit=fill', 2),
('2', 'ปาร์ตี้ วิงซ์ภูเขาไฟระเบิด', 300, 'https://images.ctfassets.net/n4pc9wlortyn/7xilbNXvGJeHjfh2ywRidG/3e2cdb7304e2e7c59912aceb10b7b153/Volcano-wingz_Party.png?h=600&w=800&fm=webp&fit=fill', 1),
('3', 'ชิคแอนด์แชร์ ทีมนักเก็ตส์ป๊อป', 200, 'https://images.ctfassets.net/n4pc9wlortyn/629ri2TI1en2Gginq0hrxm/c2ff80c2df8049059cd360e7abb3ebc6/CHICK_N-_SHARE_NUGGETS_POP_TEAM_480x388.png?h=600&w=800&fm=webp&fit=fill', 5),
('4', 'ดิพโคนนัตตี้', 35, 'https://images.ctfassets.net/n4pc9wlortyn/H8sM9XS9fkkEdd0QMxnZx/da7f4d3f4ff7bfaaaf6064f7902db8bb/SoftServe_DipNutty-.png?h=900&w=1200&fm=webp&fit=fill', 3),
('5', 'เครื่องดื่มเป๊บซี่ 1 แก้ว', 35, 'https://images.ctfassets.net/n4pc9wlortyn/6vvUyuXaRROoCVhOY3nmLX/7f8d09b4d8ecbb318218886680d99681/Pepsi_1_Glass_480x388.png?h=600&w=800&fm=webp&fit=fill', 4),
('6', 'ชุดซิงเกอร์เบอร์เกอร์กระโหลกหมา', 677777777, 'https://images.ctfassets.net/n4pc9wlortyn/6xIGgEQ7eJdaKdTRSUGajq/6cb51e9d63e6f7982aae7d01038465c1/JPU_Zinger_Set_480x388.png?h=600&w=800&fm=webp&fit=fill', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_types`
--

CREATE TABLE `menu_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_types`
--

INSERT INTO `menu_types` (`type_id`, `type_name`) VALUES
(1, 'ชุดอิ่มกลุ่ม'),
(2, 'ชุดอิ่มเดี่ยว'),
(3, 'ของหวาน'),
(4, 'เครื่องดื่ม'),
(5, 'เครื่องเคียงและทานเล่น');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `menu_types`
--
ALTER TABLE `menu_types`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu_types`
--
ALTER TABLE `menu_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `menu_types` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
