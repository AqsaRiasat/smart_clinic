-- Database creation
CREATE DATABASE IF NOT EXISTS `smart_clinic_db`;
USE `smart_clinic_db`;

-- Table structure for table `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `appointments`
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `department` varchar(50) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `contact_messages`
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =============================================
-- Default Users Data
-- =============================================
INSERT INTO `users` (`fullname`, `email`, `password`) VALUES
('Aqsa Riyasat', 'aqsa@gmail.com', '123aqsa'),
('Hamza Ali', 'hamza@gmail.com', '123456'),
('Zainab Khan', 'zainab@gmail.com', '123456'),
('Bilal Ahmed', 'bilal@gmail.com', '123456')
ON DUPLICATE KEY UPDATE `fullname` = VALUES(`fullname`), `password` = VALUES(`password`);

-- =============================================
-- Sample Contact Messages Data
-- =============================================
INSERT INTO `contact_messages` (`name`, `email`, `subject`, `message`) VALUES
('Usman Tariq', 'usman@gmail.com', 'Inquiry regarding MRI & Ultrasound charges', 'Hello, I wanted to know the pricing and available slots for full abdominal ultrasound and lab blood tests.'),
('Fatima Noor', 'fatima@gmail.com', 'Sunday Doctor Availability', 'Hi, does the cardiology department have specialist consultants on Sundays for emergency checkups?'),
('Aamir Raza', 'aamir@gmail.com', 'Health Insurance Coverage Policy', 'Do you accept corporate Jubilee Health and EFU insurance panel cards for cashless hospital appointments?'),
('Sana Javed', 'sana@gmail.com', 'Appreciation for Nursing Staff', 'I had a very smooth experience yesterday during my visit. Thank you to Dr. Sarah and the friendly reception team!');
