-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: mysql
-- Generation Time: Oct 14, 2011 at 01:08 PM
-- Server version: 4.1.14
-- PHP Version: 5.2.12
-- 
-- Shop mgt
-- 
-- 
-- Database: `shop_mgt`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `bill_details`
-- 

CREATE TABLE `bill_details` (
  `bill_num` int(10) default NULL,
  `item_id` int(10) default NULL,
  `quantity` float(10,3) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `bill_details`
-- 

INSERT INTO `bill_details` VALUES (38, 9, 1.000);
INSERT INTO `bill_details` VALUES (38, 6, 1.000);
INSERT INTO `bill_details` VALUES (36, 6, 1.000);
INSERT INTO `bill_details` VALUES (36, 8, 1.000);
INSERT INTO `bill_details` VALUES (37, 14, 1.000);
INSERT INTO `bill_details` VALUES (36, 5, 1.000);
INSERT INTO `bill_details` VALUES (37, 15, 2.000);

-- --------------------------------------------------------

-- 
-- Table structure for table `billing`
-- 

CREATE TABLE `billing` (
  `bill_num` int(10) NOT NULL auto_increment,
  `bill_amount` float(12,2) NOT NULL default '0.00',
  `customer_id` int(10) default NULL,
  `date` char(20) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`bill_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=39 ;

-- 
-- Dumping data for table `billing`
-- 

INSERT INTO `billing` VALUES (38, 9983.00, NULL, '29/07/2011 11:20:20');
INSERT INTO `billing` VALUES (37, 7550.00, NULL, '28/06/2011 11:49:01');
INSERT INTO `billing` VALUES (36, 16983.00, 22, '28/06/2011 11:47:29');

-- --------------------------------------------------------

-- 
-- Table structure for table `customers`
-- 

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL auto_increment,
  `customer_name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `contact_num` varchar(30) collate latin1_general_ci default NULL,
  `email_id` varchar(50) collate latin1_general_ci default NULL,
  `contact_addr1` varchar(50) collate latin1_general_ci default NULL,
  `contact_addr2` varchar(50) collate latin1_general_ci default NULL,
  `contact_addr3` varchar(50) collate latin1_general_ci default NULL,
  `contact_addr4` varchar(50) collate latin1_general_ci default NULL,
  `purchases` int(10) NOT NULL default '0',
  `total_amount` int(10) NOT NULL default '0',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`customer_id`),
  UNIQUE KEY `customer_name` (`customer_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=23 ;

-- 
-- Dumping data for table `customers`
-- 

INSERT INTO `customers` VALUES (5, 'Indira Bedi', '230 023023', 'indira.bedi@gmail.com', '1200, Commercial street', 'Bangalore', 'Karnataka', '', 2, 28083, '2009-01-14 17:17:30');
INSERT INTO `customers` VALUES (6, 'Sachin Tendulkar', '2320 02302', 'sachin@indiancricket.com', 'Banaswadi', 'Mumbai', 'Maharashtra', 'India', 3, 35920, '2009-01-07 19:37:44');
INSERT INTO `customers` VALUES (7, 'James Bond', '007', 'james_bond@gmail.com', 'Marriot, Residence Inn', 'Los Angeles', 'USA', '', 2, 42066, '2010-03-08 21:07:44');
INSERT INTO `customers` VALUES (8, 'Trinity Williams', '239 2042 430', 'trinity@yahoo.com', 'Trinity Church', 'Las Vegas', 'USA', '', 1, 13400, '2009-01-06 10:42:11');
INSERT INTO `customers` VALUES (9, 'Manmohan Singh', '400 450401', 'pm@india.com', 'New Delhi', '', '', '', 0, 0, '2009-01-14 14:22:10');
INSERT INTO `customers` VALUES (12, 'John Abraham', NULL, NULL, NULL, NULL, NULL, NULL, 1, 31733, '2009-01-14 14:34:36');
INSERT INTO `customers` VALUES (17, 'ABC', '123', 'abc@def.com', 'xyz', '', '', '', 0, 0, '2010-03-08 21:09:02');
INSERT INTO `customers` VALUES (22, 'Tony', NULL, NULL, NULL, NULL, NULL, NULL, 1, 16983, '2011-06-28 17:17:29');

-- --------------------------------------------------------

-- 
-- Table structure for table `items`
-- 

CREATE TABLE `items` (
  `id` int(10) NOT NULL auto_increment,
  `item_name` varchar(20) collate latin1_general_ci NOT NULL default '',
  `count` float(10,3) NOT NULL default '0.000',
  `original_price` float(10,2) NOT NULL default '0.00',
  `selling_price` float(10,2) NOT NULL default '0.00',
  `last_updated_time` varchar(16) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=27 ;

-- 
-- Dumping data for table `items`
-- 

INSERT INTO `items` VALUES (5, 'Nokia N72', 1.450, 6000.00, 6100.00, '11/12/2008 12:00');
INSERT INTO `items` VALUES (6, 'Nokia 6010', 167.000, 5053.00, 6783.00, '11/12/2008 12:12');
INSERT INTO `items` VALUES (7, 'Sony Ericsson w780i', 0.000, 5600.00, 5700.00, '11/12/2008 12:13');
INSERT INTO `items` VALUES (8, 'Seimens 500', 188.000, 4024.00, 4100.00, '12/12/2008 07:54');
INSERT INTO `items` VALUES (9, 'Motorola 5242', 253.000, 3043.00, 3200.00, '03/09/2010 17:56');
INSERT INTO `items` VALUES (10, 'Sony Ericsson w900i', 482.000, 7790.00, 7900.00, '12/12/2008 07:57');
INSERT INTO `items` VALUES (25, 'nokian73', 12.000, 7000.00, 90000.00, '29/07/2011 11:21');
INSERT INTO `items` VALUES (12, 'Sony', 87.000, 5032.00, 5500.00, '12/12/2008 08:48');
INSERT INTO `items` VALUES (13, 'New Item', 0.450, 300.00, 350.00, '17/12/2008 05:45');
INSERT INTO `items` VALUES (14, 'Virgin Mobile', 92.000, 2300.00, 2350.00, '28/12/2008 08:29');
INSERT INTO `items` VALUES (15, 'Nokia N85', 43.000, 2500.00, 2600.00, '28/12/2008 08:29');
INSERT INTO `items` VALUES (17, 'Sony VAIO', 100.000, 4000.00, 4600.00, '28/07/2010 16:11');
INSERT INTO `items` VALUES (18, 'IBM Thinkpad', 231.000, 5000.00, 5500.00, '28/07/2010 16:09');
INSERT INTO `items` VALUES (19, 'Nokia N72', 3.000, 6000.00, 6100.00, '28/07/2010 16:09');
INSERT INTO `items` VALUES (26, 'nokian73', 12.000, 7000.00, 8000.00, '08/06/2011 11:04');
INSERT INTO `items` VALUES (24, 'Mac', 20.000, 12.00, 13.00, '20/09/2010 11:06');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_roles`
-- 

CREATE TABLE `user_roles` (
  `role_id` int(10) NOT NULL auto_increment,
  `role_name` varchar(15) NOT NULL default '',
  `default` tinyint(1) NOT NULL default '0',
  `inventory` int(1) NOT NULL default '0',
  `amd_item` int(1) NOT NULL default '0',
  `view_item` int(1) NOT NULL default '0',
  `view_purchase_price` int(1) NOT NULL default '0',
  `billing` int(1) NOT NULL default '0',
  `customer_info` int(1) NOT NULL default '0',
  `view_customer` int(1) NOT NULL default '0',
  `amd_customer` int(1) NOT NULL default '0',
  `alarms` int(1) NOT NULL default '0',
  `administration` int(1) NOT NULL default '0',
  `view_user` int(1) NOT NULL default '0',
  `amd_user` int(1) NOT NULL default '0',
  `view_role` int(1) NOT NULL default '0',
  `amd_role` int(1) NOT NULL default '0',
  `change_password` int(1) NOT NULL default '0',
  PRIMARY KEY  (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- 
-- Dumping data for table `user_roles`
-- 

INSERT INTO `user_roles` VALUES (1, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT INTO `user_roles` VALUES (2, 'User', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1);
INSERT INTO `user_roles` VALUES (48, 'new_role', 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0);
INSERT INTO `user_roles` VALUES (49, 'role1', 0, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `ID` int(11) NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `password` varchar(40) NOT NULL default '',
  `role_id` int(10) NOT NULL default '0',
  `enabled` int(1) NOT NULL default '1',
  `default` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (1, 'Admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 1, 1);
INSERT INTO `users` VALUES (2, 'demo', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 2, 1, 1);
INSERT INTO `users` VALUES (66, 'new_admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 1, 0);
INSERT INTO `users` VALUES (69, 'user1', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 49, 1, 0);
INSERT INTO `users` VALUES (70, 'myuser', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 1, 1, 0);
