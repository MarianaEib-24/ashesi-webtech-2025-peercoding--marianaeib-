-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 10:05 PM
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
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Anuj Kumar', 'admin@gmail.com', 'admin', 'admin123', '2025-12-18 13:24:45'),
(2, 'Sankye Eib', 'admin2@123', 'sankye.eib', 'admin123', '0000-00-00 00:00:00'),
(3, 'Nerrisa Abunu', 'nerrisa.abunu@gmail.com', 'nerrisa.abunu', '187ecd8bf39cecb3ba4f6826c894055a', '0000-00-00 00:00:00'),
(4, 'Marc Etienne', 'marc@gmail.com', 'marc.etienne', 'd50d7bf7f40158718099375d7117cf7c', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblauthors`
--

CREATE TABLE `tblauthors` (
  `id` int(11) NOT NULL,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(1, 'Anuj kumar', '2023-12-31 21:23:03', '2025-01-07 06:18:43'),
(2, 'Chetan Bhagatt', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(3, 'Anita Desai', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(4, 'HC Verma', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(5, 'R.D. Sharma ', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(9, 'fwdfrwer', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(10, 'Dr. Andy Williams', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(11, 'Kyle Hill', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(12, 'Robert T. Kiyosak', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(13, 'Kelly Barnhill', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(14, 'Herbert Schildt', '2023-12-31 21:23:03', '2025-01-07 06:18:50'),
(16, ' Tiffany Timbers', '2025-01-07 06:55:54', NULL),
(18, 'John Shovic', '2025-01-17 14:23:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblbooks`
--

CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` varchar(25) DEFAULT NULL,
  `BookPrice` decimal(10,2) DEFAULT NULL,
  `bookImage` varchar(250) NOT NULL,
  `isIssued` int(1) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `bookQty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `bookImage`, `isIssued`, `RegDate`, `UpdationDate`, `bookQty`) VALUES
(1, 'PHP And MySql programming', 5, 1, '222333', 20.00, 'php and sql.png', 0, '2024-01-02 01:23:03', '2025-12-18 17:59:27', 10),
(3, 'physics', 6, 4, '1111', 15.00, 'physics.png', NULL, '2024-01-02 01:23:03', '2025-12-18 18:06:44', 10),
(5, 'Murach\'s MySQL', 5, 1, '9350237695', 455.00, 'murach\'s sql.png', NULL, '2024-01-02 01:23:03', '2025-12-18 17:59:27', 20),
(6, 'WordPress for Beginners 2022: A Visual Step-by-Step Guide to Mastering WordPress', 5, 10, 'B019MO3WCM', 100.00, 'wordpress for beginners.png', NULL, '2024-01-02 01:23:03', '2025-12-18 17:59:27', 15),
(7, 'WordPress Mastery Guide:', 5, 11, 'B09NKWH7NP', 53.00, 'wordpres mastery guide.png', NULL, '2024-01-02 01:23:03', '2025-12-18 17:59:27', 14),
(8, 'Rich Dad Poor Dad: What the Rich Teach Their Kids About Money That the Poor and Middle Class Do Not', 8, 12, 'B07C7M8SX9', 120.00, 'rich dad poor dad.png', NULL, '2024-01-02 01:23:03', '2025-12-18 18:25:37', 5),
(9, 'The Girl Who Drank the Moon', 8, 13, '1848126476', 200.00, 'the girl who drank the moon.png', 1, '2024-01-02 01:23:03', '2025-12-18 18:26:05', 1),
(10, 'C++: The Complete Reference, 4th Edition', 5, 14, '007053246X', 142.00, 'c++ complete reference.png', NULL, '2024-01-02 01:23:03', '2025-12-18 18:25:22', 2),
(11, 'ASP.NET Core 5 for Beginners', 9, 11, 'GBSJ36344563', 422.00, 'asp.net.png', NULL, '2024-01-02 01:23:03', '2025-12-18 18:06:44', 5),
(12, 'Python Packages', 9, 16, '0367687771', 3034.00, 'python packages.png', 1, '2025-01-07 06:56:50', '2025-12-18 17:59:27', 25),
(13, 'Python All-in-One for Dummies', 9, 18, '9388991214', 700.00, 'python for dummies.jpg', 0, '2025-01-17 14:23:48', '2025-12-18 17:59:27', 30),
(14, 'Cry me  river', 4, 18, '56789056734', 2.00, 'cry me river.png', NULL, '2025-12-18 15:18:36', '2025-12-18 17:59:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(4, 'Romantic', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:11'),
(5, 'Technology', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:21'),
(6, 'Science', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:21'),
(7, 'Management', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:21'),
(8, 'General', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:21'),
(9, 'Programming', 1, '2025-01-01 07:23:03', '2025-01-07 06:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `tblissuedbookdetails`
--

CREATE TABLE `tblissuedbookdetails` (
  `id` int(11) NOT NULL,
  `BookId` int(11) DEFAULT NULL,
  `StudentID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT current_timestamp(),
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `ReturnStatus` int(1) DEFAULT NULL,
  `fine` int(11) DEFAULT NULL,
  `remark` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `StudentID`, `IssuesDate`, `ReturnDate`, `ReturnStatus`, `fine`, `remark`) VALUES
(1, 1, 'SID002', '2025-01-13 11:12:40', '2025-01-14 06:00:56', 1, 0, 'NA'),
(2, 7, 'SID010', '2025-01-14 05:55:25', '2025-12-18 18:25:46', 1, 0, 'NA'),
(3, 1, 'SID010', '2025-01-14 05:55:39', NULL, NULL, NULL, 'NA'),
(5, 1, 'SID002', '2025-01-14 06:02:14', '2025-01-14 06:03:36', 1, 0, 'ds'),
(6, 7, 'SID012', '2025-01-17 14:16:31', NULL, NULL, NULL, 'NA'),
(7, 13, 'SID013', '2025-01-17 14:24:47', '2025-01-17 14:25:52', 1, 0, 'NA'),
(8, 13, 'SID012', '2025-01-17 14:25:34', NULL, NULL, NULL, 'NA'),
(9, 7, 'SID101', '2025-12-17 13:30:03', '2025-12-18 18:25:30', 1, 0, 'NULL'),
(10, 12, 'SID101', '2025-12-18 15:35:08', NULL, NULL, NULL, ''),
(11, 14, 'SID101', '2025-12-18 16:08:00', '2025-12-18 17:27:02', 1, 0, ''),
(12, 8, 'SID101', '2025-12-18 16:40:58', '2025-12-18 18:25:37', 1, 0, ''),
(13, 10, 'SID101', '2025-12-18 16:58:49', '2025-12-18 18:25:22', 1, 0, 'Direct Issue'),
(14, 7, 'SID101', '2025-12-18 16:59:13', '2025-12-18 17:26:52', 1, 0, 'Request Approved'),
(15, 9, 'SID104', '2025-12-18 18:26:05', NULL, NULL, NULL, 'Request Approved');

-- --------------------------------------------------------

--
-- Table structure for table `tblrequests`
--

CREATE TABLE `tblrequests` (
  `id` int(11) NOT NULL,
  `StudentId` varchar(100) DEFAULT NULL,
  `BookId` int(11) DEFAULT NULL,
  `RequestDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT 0 COMMENT '0:Pending, 1:Approved, 2:Declined',
  `Remark` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblrequests`
--

INSERT INTO `tblrequests` (`id`, `StudentId`, `BookId`, `RequestDate`, `Status`, `Remark`) VALUES
(1, 'SID101', 12, '2025-12-18 15:34:24', 1, 'Approved'),
(2, 'SID101', 14, '2025-12-18 15:49:52', 1, 'Approved'),
(3, 'SID101', 13, '2025-12-18 15:50:05', 2, 'Declined'),
(4, 'SID101', 8, '2025-12-18 16:26:21', 1, 'Approved'),
(5, 'SID101', 7, '2025-12-18 16:46:08', 1, 'Approved'),
(6, 'SID104', 9, '2025-12-18 18:24:22', 1, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL,
  `StudentId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`id`, `StudentId`, `FullName`, `EmailId`, `MobileNumber`, `Password`, `Status`, `RegDate`, `UpdationDate`) VALUES
(1, 'SID002', 'Betty Blankson', 'bettyB@gmail.com', '9865472555', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-03 07:23:03', '2025-12-17 15:45:26'),
(4, 'SID005', 'sdfsd', 'csfsd@dfsfks.com', '8569710025', '92228410fc8b872914e023160cf4ae8f', 1, '2024-01-03 07:23:03', '2025-01-07 06:20:36'),
(8, 'SID009', 'test', 'test@gmail.com', '2359874527', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-03 07:23:03', '2025-01-07 06:20:36'),
(9, 'SID010', 'Sandra Cosey', 'sandra.cosey@gmail.com', '8585856224', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-03 07:23:03', '2025-12-17 15:45:52'),
(10, 'SID011', 'Sarita Pandey', 'sarita@gmail.com', '4672423754', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-03 07:23:03', '2025-01-07 06:20:36'),
(11, 'SID012', 'John Doe', 'john@test.com', '1234569870', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-03 07:23:03', '2025-01-07 06:20:36'),
(12, 'SID013', 'Santa Claus', 'santa@t.com', '1231231230', 'f925916e2754e5e03f75dd58a5733251', 1, '2025-01-17 14:20:50', '2025-12-17 15:44:51'),
(13, 'SID014', 'Kwadwo', 'kgasafo@ashesi.edu.gh', '0595490070', '25d55ad283aa400af464c76d713c07ad', 1, '2025-12-13 03:39:29', NULL),
(14, 'SID015', 'Mariana Eib', 'mariana.sankye@gmail.com', '0595490070', '3d9f3d4ed70d167b623deb0ef4893b64', 1, '2025-12-17 15:40:59', NULL),
(15, 'SID101', 'JKV', 'jkv@gmail.com', '0595266261', '5760e0cbb47a7a7c9097c6fcecdef6fa', 1, '2025-12-17 22:55:49', '2025-12-18 13:29:43'),
(17, 'SID104', 'Vanessa Logan', 'vanessa@gmail.com', '0594569906', 'd1dfeec6652fc1dbe60e3442d6b88482', 1, '2025-12-18 18:22:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblauthors`
--
ALTER TABLE `tblauthors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblrequests`
--
ALTER TABLE `tblrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `StudentId` (`StudentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblauthors`
--
ALTER TABLE `tblauthors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblrequests`
--
ALTER TABLE `tblrequests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
