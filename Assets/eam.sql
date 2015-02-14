-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2012 at 10:31 AM
-- Server version: 5.0.92
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eam`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets_hardware`
--

CREATE TABLE IF NOT EXISTS `assets_hardware` (
  `asset_hardware_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_type` varchar(50) DEFAULT NULL,
  `vendor` varchar(50) NOT NULL DEFAULT '',
  `model` varchar(30) NOT NULL DEFAULT '',
  `serialnumber` varchar(30) DEFAULT NULL,
  `asset_tag` varchar(24) DEFAULT NULL,
  `purchase_order` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `date_purchase` varchar(12) DEFAULT NULL,
  `date_decomission` varchar(12) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `comments` text,
  `monitor_size` int(2) DEFAULT NULL,
  `warranty` varchar(15) DEFAULT NULL,
  `cube` varchar(10) DEFAULT NULL,
  `field_address` text,
  `user_account` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`asset_hardware_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `assets_hardware`
--

INSERT INTO `assets_hardware` (`asset_hardware_id`, `asset_type`, `vendor`, `model`, `serialnumber`, `location`, `date_purchase`, `date_decomission`, `status`, `user`, `division`, `platform`, `comments`, `monitor_size`, `warranty`, `cube`, `field_address`, `user_account`) VALUES
(47, 'Printer', 'HP', 'LJ4200', '54646', 'Louisville', '03/01/2010', NULL, 'Deployed', 'Finance', 'Corporate', 'Printer', NULL, NULL, NULL, '445', NULL, NULL),
(41, 'Desktop', 'IBM', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, 'Printer', NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Desktop', 'Apple', '1', '1', 'Boston', '01/17/2012', NULL, 'Inventory', 'asad', 'Corporate', 'Mac', '5', NULL, '01/17/2012', '5', '5', 'asadac'),
(36, 'Laptop', 'Dell', 'E6220', 'CS54648', 'Santa Fe', '06/01/2011', NULL, 'Deployed', 'Lucky Lee', 'Europe', 'PC', NULL, NULL, '06/01/2014', NULL, '1e Banock\r\n', 'leeluc'),
(35, 'Laptop', 'Apple', 'MacBook Pro', '2986RMA32', 'Boston', '06/01/2011', NULL, 'Deployed', 'Mike Smith', 'Corporate', 'Mac', NULL, NULL, '06/01/2014', '3-144', NULL, 'smithm'),
(43, 'Laptop', 'Lenovo', 'T400', '6475hkjsaldla', 'Boston', NULL, NULL, 'Inventory', NULL, 'Europe', 'PC', NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Laptop', 'Dell', 'E6420', '231456', 'Boston', '02/05/2012', NULL, 'Deployed', 'Chuck Norris', 'Corporate', 'PC', NULL, NULL, '05/18/2015', '1234', NULL, 'norrisc'),
(32, 'Desktop', 'Dell', 'xps', '1234', 'Pittsburgh', '08/30/2011', NULL, 'Inventory', 'rashmi singh', 'Europe', 'PC', 'hfgh', NULL, '08/31/2011', '34235', 'ggdfdh', '56'),
(33, 'Desktop', 'Dell', '56546', '54654654645', 'Boston', '09/06/2011', NULL, 'Inventory', NULL, 'Corporate', 'PC', NULL, NULL, '02/08/2012', NULL, NULL, NULL),
(34, 'Desktop', 'Dell', '5543', '45464654', 'Chicago', '09/06/2011', NULL, 'Inventory', 'gfhfghfghf', 'Europe', 'Mac', 'dfgdfg', NULL, '02/16/2012', 'rfgdf', 'bdfgf', '453454'),
(37, 'Monitor', 'Apple', 'Cinema', 'overpriced', 'Boston', '07/05/2010', NULL, 'Deployed', 'Le High End Guy', 'Europe', 'Mac', NULL, NULL, NULL, NULL, NULL, 'highend'),
(38, 'Printer', 'Xerox', '7552', '23abc', 'Santa Fe', '12/05/2011', NULL, 'Deployed', NULL, 'Left Coast', 'Printer', NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Laptop', 'Lenovo', 'X201', 'x2011111', NULL, '09/05/2011', NULL, 'Inventory', NULL, NULL, 'PC', NULL, NULL, '09/05/2014', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets_hardware_monitor_size`
--

CREATE TABLE IF NOT EXISTS `assets_hardware_monitor_size` (
  `size` int(2) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `assets_hardware_monitor_size`
--

INSERT INTO `assets_hardware_monitor_size` (`size`, `id`) VALUES
(15, 1),
(17, 2),
(19, 3),
(20, 4),
(21, 5),
(22, 6),
(24, 7),
(26, 8),
(28, 9),
(30, 10);

-- --------------------------------------------------------

--
-- Table structure for table `assets_hardware_platform`
--

CREATE TABLE IF NOT EXISTS `assets_hardware_platform` (
  `platform_id` int(10) unsigned NOT NULL auto_increment,
  `platform` varchar(100) NOT NULL default '',
  `comments` text,
  PRIMARY KEY  (`platform_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `assets_hardware_platform`
--

INSERT INTO `assets_hardware_platform` (`platform_id`, `platform`, `comments`) VALUES
(1, 'PC', 'Windows hardware'),
(2, 'Mac', 'Apple Macintosh Hardware'),
(8, 'Printer', 'Printers, Multifunction Devices'),
(9, 'Mobile', 'Phones and Tablets');

-- --------------------------------------------------------

--
-- Table structure for table `assets_hardware_status`
--

CREATE TABLE IF NOT EXISTS `assets_hardware_status` (
  `assets_hardware_status` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `assets_hardware_status`
--

INSERT INTO `assets_hardware_status` (`assets_hardware_status`, `id`) VALUES
('Deployed', 2),
('Inventory', 3),
('Retired', 4);

-- --------------------------------------------------------

--
-- Table structure for table `assets_hardware_type`
--

CREATE TABLE IF NOT EXISTS `assets_hardware_type` (
  `assets_hardware_type` varchar(15) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `comments` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `assets_hardware_type`
--

INSERT INTO `assets_hardware_type` (`assets_hardware_type`, `id`, `comments`) VALUES
('Laptop', 1, 'Portable Computer'),
('Desktop', 2, 'Desktop computer'),
('Monitor', 3, 'LCD or CRT Monitor'),
('Printer', 4, 'Network and personal printers'),
('Peripheral', 5, 'Any Peripheral'),
('Other', 6, 'Any hardware item which doesn''t fit a defined category'),
('Server', 7, 'Servers'),
('Tablet', 8, 'Mobile device'),
('Smartphone', 9, 'SmartPhone\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `assets_software`
--

CREATE TABLE IF NOT EXISTS `assets_software` (
  `asset_software_id` int(10) unsigned NOT NULL auto_increment,
  `asset` varchar(100) NOT NULL default '',
  `vendor` varchar(30) NOT NULL default '',
  `version` varchar(20) NOT NULL,
  `date_purchase` varchar(12) default NULL,
  `license_type` varchar(50) NOT NULL default '',
  `status` varchar(50) default NULL,
  `user` varchar(50) default NULL,
  `division` varchar(50) default NULL,
  `comments` text,
  `platform` varchar(15) default NULL,
  `location` varchar(30) default NULL,
  `seats` varchar(12) default NULL,
  PRIMARY KEY  (`asset_software_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assets_software`
--

INSERT INTO `assets_software` (`asset_software_id`, `asset`, `vendor`, `version`, `date_purchase`, `license_type`, `status`, `user`, `division`, `comments`, `platform`, `location`, `seats`) VALUES
(4, 'Dreamweaver', 'Adobe', 'CS5', '10/01/2010', 'Adobe - Individually Purchased', NULL, NULL, 'Corporate', NULL, 'Windows', 'New York', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets_software_license`
--

CREATE TABLE IF NOT EXISTS `assets_software_license` (
  `assets_software_license` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='location lookup list' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `assets_software_license`
--

INSERT INTO `assets_software_license` (`assets_software_license`, `id`) VALUES
('Microsoft - MVL', 1),
('Microsoft - MSLP', 2),
('Microsoft - OEM', 3),
('Microsoft - Individually Purchased', 4),
('Adobe - Volume License Program', 5),
('Adobe - Individually Purchased', 6),
('Other', 7);

-- --------------------------------------------------------

--
-- Table structure for table `assets_software_platform`
--

CREATE TABLE IF NOT EXISTS `assets_software_platform` (
  `assets_software_type` varchar(15) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='location lookup list' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `assets_software_platform`
--

INSERT INTO `assets_software_platform` (`assets_software_type`, `id`) VALUES
('Mac', 1),
('Windows', 2),
('Other', 4);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `company_id` int(11) NOT NULL auto_increment,
  `company_name` varchar(200) NOT NULL,
  PRIMARY KEY  (`company_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `company_name`) VALUES
(1, 'BigsmallWeb');

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `division` varchar(15) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `comments` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`division`, `id`, `comments`) VALUES
('Corporate', 1, 'Corporate'),
('Left Coast', 2, 'Left Coast'),
('Right Coast', 3, 'Right Coast'),
('Europe', 4, 'Europe');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `comments` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location`, `id`, `comments`) VALUES
('New York', 1, 'New York, NY'),
('Boston', 2, 'Boston Mass.'),
('Louisville', 4, 'Louisville Ky.'),
('Orlando', 5, 'Orlando, Fl.'),
('Indianapolis', 7, 'Indianapolis, In. '),
('Chicago', 9, 'Chicago, IL'),
('Pittsburgh', 10, 'Pittsburgh PA.'),
('Field', 11, 'Traveling Field users');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(30) default NULL,
  `password` varchar(30) NOT NULL default '',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `role` varchar(24) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `firstname`, `lastname`, `role`) VALUES
(1, 'eam', 'eam123', 'Primary', 'Admin', 'admin'),
(2, 'dudel', 'dude', 'Dude', 'LeMonde', 'editor');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `vendor_id` int(10) unsigned NOT NULL auto_increment,
  `vendor` varchar(100) NOT NULL default '',
  `comments` text,
  PRIMARY KEY  (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor`, `comments`) VALUES
(1, 'Dell', 'Dell desktops, laptops, and accessories'),
(2, 'Lenovo', 'Laptops and accessories'),
(3, 'HP', 'HP printers and accessories'),
(4, 'IBM', 'IBM laptops and accessories'),
(5, 'Apple', 'Apple products'),
(7, 'Asus', 'Asus - the greek god of Netbooks'),
(9, 'Brother', 'Printers');

-- --------------------------------------------------------

--
-- Table structure for table `vendors_software`
--

CREATE TABLE IF NOT EXISTS `vendors_software` (
  `vendor` varchar(30) NOT NULL default '',
  `vendor_id` int(11) NOT NULL auto_increment,
  `comments` varchar(30) default NULL,
  PRIMARY KEY  (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `vendors_software`
--

INSERT INTO `vendors_software` (`vendor`, `vendor_id`, `comments`) VALUES
('Microsoft', 1, 'Microsoft Software'),
('Adobe', 2, 'Adobe Software'),
('SHI', 3, 'SHI - Software reseller'),
('Dell', 4, 'Dell - Software reseller'),
('Other', 5, 'Any other vendor not listed');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
