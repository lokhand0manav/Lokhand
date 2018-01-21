-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2018 at 08:31 AM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `department`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `P_ID` int(11) NOT NULL,
  `Fac_ID` int(11) NOT NULL,
  `Paper_title` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Paper_type` varchar(20) CHARACTER SET utf8 NOT NULL,
  `Paper_N_I` varchar(20) CHARACTER SET utf8 NOT NULL,
  `conf_journal_name` varchar(500) NOT NULL,
  `paper_category` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Date_from` date NOT NULL,
  `Date_to` date NOT NULL,
  `Location` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Paper_copy` blob NOT NULL,
  `Certificate_copy` blob NOT NULL,
  `report_copy` blob NOT NULL,
  `paper_path` varchar(100) CHARACTER SET utf8 NOT NULL,
  `certificate_path` varchar(100) CHARACTER SET utf8 NOT NULL,
  `report_path` varchar(100) CHARACTER SET utf8 NOT NULL,
  `Paper_co_authors` varchar(30) CHARACTER SET utf8 NOT NULL,
  `volume` varchar(30) CHARACTER SET utf8 NOT NULL,
  `h_index` int(11) NOT NULL,
  `FDC_Y_N` varchar(10) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`P_ID`, `Fac_ID`, `Paper_title`, `Paper_type`, `Paper_N_I`, `conf_journal_name`, `paper_category`, `Date_from`, `Date_to`, `Location`, `Paper_copy`, `Certificate_copy`, `report_copy`, `paper_path`, `certificate_path`, `report_path`, `Paper_co_authors`, `volume`, `h_index`, `FDC_Y_N`) VALUES
(134, 1, 'php', 'conference', 'national', 'ff', 'peer reviewed', '2017-11-06', '2017-11-07', 'g', '', '', '', ' papers/134.jpg', ' certificates/134.doc', '', '', '', 0, 'yes'),
(135, 1, 'os', 'conference', 'international', 'fg', 'peer reviewed', '2017-11-02', '2017-11-03', 's', '', '', '', 'NULL', 'NULL', 'NULL', '', '', 0, 'no'),
(137, 1, 'fdgdf', 'conference', 'national', 'ttr', 'peer reviewed', '2017-12-01', '2017-12-02', 'sd', '', '', '', 'not_applicable', '', '', 'g', 'f', 1, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `facultydetails`
--

CREATE TABLE `facultydetails` (
  `Fac_ID` int(11) NOT NULL,
  `F_NAME` varchar(50) NOT NULL,
  `Mobile` bigint(12) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(500) NOT NULL,
  `token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facultydetails`
--

INSERT INTO `facultydetails` (`Fac_ID`, `F_NAME`, `Mobile`, `Email`, `Password`, `token`) VALUES
(1, 'jyoti', 0, '', '', ''),
(8, 'Nikhil Vijay Sankpal', 9594467083, 'nsankpal97@gmail.com', '$2y$04$75RQ.RDmwTJjOoW9WqGCIuUusgLLiEh7RfJyg9BK2QMI4LpHWR/wi', ''),
(9, 'HOD', 9224626232, 'hodextc@somaiya.edu', '$2y$04$8LdYjuz6TvVb7bE.gX5QNuLIoKMElKMs/zfAB66nPfvNclvi1S63C', '');

-- --------------------------------------------------------

--
-- Table structure for table `fdc`
--

CREATE TABLE `fdc` (
  `FDC_ID` int(11) NOT NULL,
  `Fac_ID` int(11) NOT NULL,
  `Paper_title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `min_no` varchar(30) NOT NULL,
  `serial_no` varchar(30) NOT NULL,
  `period` int(10) NOT NULL,
  `od_approv` int(10) NOT NULL,
  `od_avail` int(10) NOT NULL,
  `fee_sac` int(10) NOT NULL,
  `fee_avail` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fdc`
--

INSERT INTO `fdc` (`FDC_ID`, `Fac_ID`, `Paper_title`, `min_no`, `serial_no`, `period`, `od_approv`, `od_avail`, `fee_sac`, `fee_avail`) VALUES
(42, 1, 'php', '', '', 0, 0, 0, 0, 0),
(43, 1, 'php', '', '', 0, 0, 0, 0, 0),
(44, 1, 'fdgdf', '', '', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `iv_attended`
--

CREATE TABLE `iv_attended` (
  `id` int(11) NOT NULL,
  `f_id` varchar(255) NOT NULL,
  `ind` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `permission` varchar(255) NOT NULL,
  `report` varchar(255) NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `t_from` date NOT NULL,
  `t_to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iv_attended`
--

INSERT INTO `iv_attended` (`id`, `f_id`, `ind`, `city`, `purpose`, `date`, `permission`, `report`, `certificate`, `t_from`, `t_to`) VALUES
(30, '8', 'Welspun India', 'www', '          				wqqww', '2018-01-01', '', '', '', '2018-01-29', '2018-01-30'),
(38, '8', 'aa', 'asas', '          				ass', '2018-01-01', '', '', '', '2018-01-01', '2018-01-03'),
(49, '8', 'sasas', 'a', '          				          	sss			          				          				          				          				', '2018-01-01', '', '', '', '2018-01-30', '2018-01-31'),
(56, '1', 'qq', 'e', '          				qq          				', '2018-01-01', '', '', '', '2018-01-02', '2018-01-03'),
(57, '8', 'ee', 'e', '          				ee          				', '2018-01-03', '', '', '', '2018-01-08', '2018-01-09'),
(58, '1', 'q', 'qqq', '          				          				sss          				          				          				          				          				', '2018-01-02', '', '', '', '2018-01-09', '2018-01-25'),
(59, '1', 'de', 'www', '          				          			www	          				          				          				          				          				', '2018-01-03', '', '', '', '2018-01-03', '2018-01-04');

-- --------------------------------------------------------

--
-- Table structure for table `iv_organized`
--

CREATE TABLE `iv_organized` (
  `id` int(11) NOT NULL,
  `f_id` varchar(255) NOT NULL,
  `ind` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `t_audience` varchar(255) NOT NULL,
  `staff` varchar(255) NOT NULL,
  `permission` varchar(255) NOT NULL,
  `report` varchar(255) NOT NULL,
  `certificate` varchar(255) NOT NULL,
  `attendance` varchar(255) NOT NULL,
  `t_from` date NOT NULL,
  `t_to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iv_organized`
--

INSERT INTO `iv_organized` (`id`, `f_id`, `ind`, `city`, `purpose`, `date`, `t_audience`, `staff`, `permission`, `report`, `certificate`, `attendance`, `t_from`, `t_to`) VALUES
(9, '8', 'qq', 'ddd', '          				       sss   				          				          				', '2018-01-03', 'fff', 'ggg', '', '', '', '', '2018-01-02', '2018-01-04'),
(13, '8', 'qq', 'ss', '          				     qq     				', '2018-01-10', 'sssss', 'sssssss', '', '', '', '', '2018-01-03', '2018-01-04'),
(15, '8', 'morgan', 'pune', 'Purpose is         				          				          				          				', '2018-01-01', 'Nikhil', 'Sankpal', '', '', '', '', '2018-01-01', '2018-01-02'),
(18, '8', '11', 'mumbvai', '          	111			          				', '2018-01-01', '222', '333', '', '', '', '', '2018-01-01', '2018-01-04'),
(19, '8', 'erere', 'mumbai', '          				rerer          				', '2018-01-01', 'dddd', 'ffdf', '', '', '', '', '2018-01-29', '2018-01-31'),
(24, '1', '11', 'ssa', '          				          			sss	          				          				          				          				          				', '2018-01-01', 'aasas', 'dsdad', '', '', '', '', '2018-01-02', '2018-01-03'),
(25, '8', 'xxx', 'xxx', '          				        xxx  				          				          				          				          				          				', '2018-01-02', 'xx', 'aaas', '', '', '', '', '2018-01-02', '2018-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `paper_review`
--

CREATE TABLE `paper_review` (
  `paper_review_ID` int(11) NOT NULL,
  `Fac_ID` int(11) NOT NULL,
  `Paper_title` varchar(30) NOT NULL,
  `Paper_type` varchar(20) NOT NULL,
  `Paper_N_I` varchar(20) NOT NULL,
  `paper_category` varchar(100) NOT NULL,
  `Date_from` date NOT NULL,
  `Date_to` date NOT NULL,
  `organised_by` varchar(100) NOT NULL,
  `details` varchar(100) NOT NULL,
  `mail_letter_path` varchar(100) NOT NULL,
  `certificate_path` varchar(100) NOT NULL,
  `report_path` varchar(100) NOT NULL,
  `volume` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paper_review`
--

INSERT INTO `paper_review` (`paper_review_ID`, `Fac_ID`, `Paper_title`, `Paper_type`, `Paper_N_I`, `paper_category`, `Date_from`, `Date_to`, `organised_by`, `details`, `mail_letter_path`, `certificate_path`, `report_path`, `volume`) VALUES
(7, 1, 'fgh', 'conference', 'national', 'peer reviewed', '2017-11-02', '2017-11-04', 'fgh', 'fh', 'not_applicable', '', '', ''),
(8, 8, 'Title1', 'conference', 'national', 'peer reviewed', '2017-12-01', '2017-12-03', 'Organized1', 'details1', 'NULL', '', '', 'volume1'),
(9, 8, 'title2', 'conference', 'national', 'peer reviewed', '2017-12-04', '2017-12-08', 'organized2', 'details2', '', '', '', 'volume1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`P_ID`),
  ADD KEY `F_ID` (`Fac_ID`);

--
-- Indexes for table `facultydetails`
--
ALTER TABLE `facultydetails`
  ADD PRIMARY KEY (`Fac_ID`);

--
-- Indexes for table `fdc`
--
ALTER TABLE `fdc`
  ADD PRIMARY KEY (`FDC_ID`),
  ADD KEY `F_ID` (`Fac_ID`);

--
-- Indexes for table `iv_attended`
--
ALTER TABLE `iv_attended`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iv_organized`
--
ALTER TABLE `iv_organized`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_review`
--
ALTER TABLE `paper_review`
  ADD PRIMARY KEY (`paper_review_ID`),
  ADD KEY `Fac_ID` (`Fac_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `P_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
--
-- AUTO_INCREMENT for table `facultydetails`
--
ALTER TABLE `facultydetails`
  MODIFY `Fac_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `fdc`
--
ALTER TABLE `fdc`
  MODIFY `FDC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `iv_attended`
--
ALTER TABLE `iv_attended`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `iv_organized`
--
ALTER TABLE `iv_organized`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `paper_review`
--
ALTER TABLE `paper_review`
  MODIFY `paper_review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `foreign key_F_ID` FOREIGN KEY (`Fac_ID`) REFERENCES `facultydetails` (`Fac_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `fdc`
--
ALTER TABLE `fdc`
  ADD CONSTRAINT `foreign key_fac id` FOREIGN KEY (`Fac_ID`) REFERENCES `facultydetails` (`Fac_ID`) ON UPDATE CASCADE;

--
-- Constraints for table `paper_review`
--
ALTER TABLE `paper_review`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`Fac_ID`) REFERENCES `facultydetails` (`Fac_ID`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
