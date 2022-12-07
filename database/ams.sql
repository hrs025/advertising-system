-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2018 at 03:08 PM
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
-- Database: `ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `areaid` int(5) NOT NULL,
  `cityid` int(5) NOT NULL,
  `areaname` varchar(30) NOT NULL,
  `areadel` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`areaid`, `cityid`, `areaname`, `areadel`) VALUES
(1, 2, 'waghavadi road', 0),
(2, 2, 'talaja road', 0),
(3, 1, 'punagam', 0),
(4, 1, 'varachha', 0),
(5, 3, 'navagam', 0),
(6, 3, 'bedi road', 0),
(7, 5, 'st xaviers school', 0),
(8, 5, 'mahatma mandir road', 0),
(9, 6, 'dharagiri', 0),
(10, 6, 'jn tata road', 0),
(11, 7, 'dhanora', 0),
(12, 7, 'akota', 0),
(13, 8, 'andheri east', 0),
(14, 8, 'dharavi', 0),
(15, 10, 'jankipuram', 0),
(16, 10, 'aliganj', 0),
(17, 11, 'saligramam', 0),
(18, 11, 'anna nagar', 0),
(19, 12, 'nagarbhavi', 0),
(20, 12, 'kothnur', 0);

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cityid` int(5) NOT NULL,
  `cityname` varchar(20) NOT NULL,
  `citydel` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cityid`, `cityname`, `citydel`) VALUES
(1, 'surat', 0),
(2, 'bhavanagar', 0),
(3, 'jamnagar', 0),
(5, 'gandhinagar', 0),
(6, 'navasari', 0),
(7, 'vadodara', 0),
(8, 'mumbai', 0),
(10, 'lucknowb', 0),
(11, 'chennai', 0),
(12, 'banglore', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contactid` int(5) NOT NULL,
  `contactname` varchar(30) NOT NULL,
  `contactemail` varchar(30) NOT NULL,
  `contactmsg` varchar(100) NOT NULL,
  `contact_subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contactid`, `contactname`, `contactemail`, `contactmsg`, `contact_subject`) VALUES
(13, 'Naresh', 'nr@gmail.com', 'Plz send catalog on my mail', 'Regarding Hoardings');

-- --------------------------------------------------------

--
-- Table structure for table `emailsub`
--

CREATE TABLE `emailsub` (
  `emailsubid` int(5) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emailsub`
--

INSERT INTO `emailsub` (`emailsubid`, `email`) VALUES
(62, 'kabariyakritesh65@gmail.com'),
(63, 'rkatva29@gmail.com'),
(64, 'nareshrupareliya70@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedid` int(5) NOT NULL,
  `feedname` varchar(30) NOT NULL,
  `feedmsg` varchar(100) NOT NULL,
  `feel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedid`, `feedname`, `feedmsg`, `feel`) VALUES
(19, 'Service', 'Your hoarding service is awesome', 'good');

-- --------------------------------------------------------

--
-- Table structure for table `logintime`
--

CREATE TABLE `logintime` (
  `userid` varchar(30) NOT NULL,
  `logindate` date NOT NULL,
  `logintime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logintime`
--

INSERT INTO `logintime` (`userid`, `logindate`, `logintime`) VALUES
('kritesh123', '2018-04-17', '20:16:37'),
('ravi1111', '2018-04-18', '09:45:53'),
('nareshadmin', '2018-04-17', '21:41:48'),
('bhavesh', '2018-04-17', '18:49:35');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `packageid` int(5) NOT NULL,
  `packagename` varchar(20) NOT NULL,
  `packagedel` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`packageid`, `packagename`, `packagedel`) VALUES
(2, 'pro trander', 0),
(3, 'executive trander', 1),
(4, 'starter', 0),
(5, 'tycoon trander', 0),
(6, 'rookie', 0),
(7, 'trander', 0);

-- --------------------------------------------------------

--
-- Table structure for table `package_size`
--

CREATE TABLE `package_size` (
  `package_size_id` int(5) NOT NULL,
  `packageid` int(5) NOT NULL,
  `size_id` int(5) NOT NULL,
  `duration` int(5) NOT NULL,
  `price` int(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contactno` varchar(10) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `regdate` date NOT NULL,
  `block` int(5) NOT NULL,
  `type` int(5) NOT NULL,
  `profile` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `token` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`username`, `email`, `contactno`, `userid`, `password`, `regdate`, `block`, `type`, `profile`, `gender`, `token`, `status`) VALUES
('bhavesh panchal', 'bhaveshpanchal884@gmail.com', '9909385648', 'bhavesh', 'b6016119aa9c5a49ae408164e460fa15', '2018-04-17', 1, 2, 'profile/bhavesh.jpeg', 1, ' ', 1),
('Kabariya Kritesh', 'kabariyakritesh65@gmail.com', '7405880343', 'kritesh123', '962dbfa90ae3c56c71d1cfeb2295e1fe', '2016-04-07', 1, 1, 'profile/kritesh123.jpeg', 1, '', 1),
('Rupareliya Naresh', 'nareshrupareliya70@gmail.com', '8758441385', 'nareshadmin', 'b6016119aa9c5a49ae408164e460fa15', '2016-04-07', 1, 0, 'profile/nareshadmin.jpeg', 1, '', 1),
('Katva Ravi', 'rkatva29@gmail.com', '9726270878', 'ravi1111', '41deefc7b152e2dcd46239459893200d', '2016-04-07', 1, 2, 'profile/ravi111.jpeg', 1, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `size_id` int(5) NOT NULL,
  `size` varchar(50) NOT NULL,
  `size_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`areaid`),
  ADD KEY `cityidforignofcity` (`cityid`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cityid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactid`);

--
-- Indexes for table `emailsub`
--
ALTER TABLE `emailsub`
  ADD PRIMARY KEY (`emailsubid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedid`);

--
-- Indexes for table `logintime`
--
ALTER TABLE `logintime`
  ADD KEY `useridforeignofregistration` (`userid`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`packageid`);

--
-- Indexes for table `package_size`
--
ALTER TABLE `package_size`
  ADD PRIMARY KEY (`package_size_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `areaid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `cityid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contactid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `emailsub`
--
ALTER TABLE `emailsub`
  MODIFY `emailsubid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `packageid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `package_size`
--
ALTER TABLE `package_size`
  MODIFY `package_size_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(5) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_cityid_f_city` FOREIGN KEY (`cityid`) REFERENCES `city` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logintime`
--
ALTER TABLE `logintime`
  ADD CONSTRAINT `lt_userid_f_reg` FOREIGN KEY (`userid`) REFERENCES `registration` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
