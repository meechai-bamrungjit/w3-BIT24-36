SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ลบตารางเดิมออกก่อนเพื่อป้องกัน Error สร้างซ้ำ
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `menus`;
DROP TABLE IF EXISTS `menu_types`;
DROP TABLE IF EXISTS `users`;

-- 1. ตาราง users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`, `fname`, `lname`, `created_at`) VALUES
(1, 'admin', '1234', 'Sompong', 'Sandee', '2026-05-05 11:28:45'),
(2, 'user1', '4321', 'Somchai', 'Jaidee', '2026-05-05 11:28:45');

-- 2. ตาราง menus
CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` double NOT NULL,
  `menu_image` text NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `menus` (`menu_id`, `menu_name`, `menu_price`, `menu_image`) VALUES
(1, 'น้ำโกโก้', 45, 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=800'),
(2, 'น้ำองุ่น', 40, 'https://images.unsplash.com/photo-1534353473418-4cfa6c56fd38?w=800'),
(3, 'น้ำแตงโม', 40, 'https://images.unsplash.com/photo-1589733955941-5eeaf752f6dd?w=800'),
(4, 'น้ำเปล่า', 15, 'https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=800');

-- 3. ตาราง orders
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` double NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_menus` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`order_id`, `user_id`, `menu_id`, `quantity`, `total_price`, `order_date`) VALUES
(1, 2, 1, 2, 90, '2026-08-16 10:00:00'),
(2, 2, 4, 1, 15, '2026-08-16 10:05:00');

COMMIT;