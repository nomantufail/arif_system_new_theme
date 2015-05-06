-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2015 at 02:06 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arif_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `role`) VALUES
(1, 'virik', 'virik123', 'viriklogistics', 2),
(2, 'test', '123', 'Test User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'arshad', '', '', '2015-04-10 12:24:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'akram', '', '', '2015-04-10 12:25:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'noman', '', '', '2015-04-10 14:27:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 'shahid', '', '', '2015-04-10 14:28:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, 'soe you', '', '', '2015-04-14 07:23:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(6, 'soe you', '', '', '2015-04-14 07:39:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `inserted_at`, `updated_at`) VALUES
(1, 'some', '', '2015-04-10 12:38:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoices`
--

CREATE TABLE IF NOT EXISTS `purchase_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `transaction_type` tinyint(4) NOT NULL DEFAULT '1',
  `paid` double NOT NULL,
  `extra_info` text NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase_invoices`
--

INSERT INTO `purchase_invoices` (`id`, `invoice_date`, `supplier_id`, `transaction_type`, `paid`, `extra_info`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, '2015-04-14', 2, 0, 0, '', '2015-04-14 10:22:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_invoice_items`
--

CREATE TABLE IF NOT EXISTS `purchase_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `cost_per_item` double NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `purchase_invoice_items`
--

INSERT INTO `purchase_invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `cost_per_item`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 1, 1, 12, 1112, '2015-04-14 10:22:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `router`
--

CREATE TABLE IF NOT EXISTS `router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `router`
--

INSERT INTO `router` (`id`, `controller`, `function`) VALUES
(1, 'customers', 'index'),
(2, 'products', 'index'),
(3, 'purchases', 'credit_purchase'),
(4, 'sales', 'credit_sale'),
(5, 'stock', 'index'),
(6, 'accounts', 'index'),
(7, 'reports', 'index'),
(8, 'suppliers', 'index'),
(9, 'settings', 'accounts');

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoices`
--

CREATE TABLE IF NOT EXISTS `sale_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `transaction_type` tinyint(4) NOT NULL DEFAULT '1',
  `recieved` double NOT NULL,
  `extra_info` text NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sale_invoices`
--

INSERT INTO `sale_invoices` (`id`, `invoice_date`, `customer_id`, `transaction_type`, `recieved`, `extra_info`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, '2015-04-10', 3, 0, 4, '', '2015-04-10 14:28:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, '2015-04-10', 4, 0, 4, '', '2015-04-10 14:29:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_invoice_items`
--

CREATE TABLE IF NOT EXISTS `sale_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `sale_price_per_item` double NOT NULL DEFAULT '0',
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sale_invoice_items`
--

INSERT INTO `sale_invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `sale_price_per_item`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 1, 1, 3, 4, '2015-04-10 14:28:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 2, 1, 3, 4, '2015-04-10 14:29:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `product_id`, `quantity`, `updated_at`) VALUES
(1, 1, 6, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `inerted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `address`, `inerted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'arshad', '', '', '2015-04-14 07:27:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(2, 'soem supplier', '', '', '2015-04-14 07:38:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'else', '', '', '2015-04-14 07:41:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_accounts`
--

CREATE TABLE IF NOT EXISTS `user_bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_bank_accounts`
--

INSERT INTO `user_bank_accounts` (`id`, `title`, `type`, `inserted_at`, `updated_at`, `deleted_at`, `deleted`) VALUES
(1, 'new titile', 'current', '2015-04-14 09:43:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'bank account 1', 'current', '2015-04-14 09:44:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, 'bank account 2', 'current', '2015-04-14 09:44:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, 'bank account 3', 'current', '2015-04-14 09:44:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_date` date NOT NULL,
  `summary` varchar(250) NOT NULL,
  `inserted_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `voucher_date`, `summary`, `inserted_at`, `deleted_at`, `updated_at`, `deleted`) VALUES
(2, '2015-04-14', 'this is other information', '2015-04-14 11:56:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(3, '2015-04-14', '', '2015-04-14 11:58:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(4, '2015-04-14', '', '2015-04-14 12:00:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(5, '2015-04-14', '', '2015-04-14 12:00:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(6, '2015-04-14', '', '2015-04-14 12:03:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(7, '2015-04-14', '', '2015-04-14 12:04:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(8, '2015-04-14', '', '2015-04-14 12:04:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_entries`
--

CREATE TABLE IF NOT EXISTS `voucher_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_id` int(11) NOT NULL,
  `ac_title` varchar(100) NOT NULL,
  `ac_sub_title` varchar(100) NOT NULL,
  `ac_type` varchar(100) NOT NULL,
  `related_customer` varchar(100) NOT NULL,
  `related_supplier` varchar(100) NOT NULL,
  `related_business` varchar(100) NOT NULL,
  `related_other_agent` varchar(100) NOT NULL,
  `quantity` double NOT NULL,
  `cost_per_item` double NOT NULL,
  `amount` double NOT NULL,
  `dr_cr` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `voucher_entries`
--

INSERT INTO `voucher_entries` (`id`, `voucher_id`, `ac_title`, `ac_sub_title`, `ac_type`, `related_customer`, `related_supplier`, `related_business`, `related_other_agent`, `quantity`, `cost_per_item`, `amount`, `dr_cr`, `description`) VALUES
(1, 2, 'some', '', 'asset', '0', '0', '0', '', 4, 100, 400, 1, ''),
(2, 2, 'some', '', 'payable', '0', '0', '0', '', 4, 100, 400, 0, ''),
(3, 2, '', '', 'asset', '0', '0', '0', '', 0, 0, 0, 1, ''),
(4, 2, '', '', 'payable', '0', '0', '0', '', 0, 0, 0, 0, ''),
(5, 3, 'some', '', 'asset', '0', '0', '0', '', 5, 5, 25, 1, ''),
(6, 3, 'some', '', 'payable', '0', '0', '0', '', 5, 5, 25, 0, ''),
(7, 3, '', '', 'asset', '0', '0', '0', '', 0, 0, 0, 1, ''),
(8, 3, '', '', 'payable', '0', '0', '0', '', 0, 0, 0, 0, ''),
(9, 4, 'some', '', 'asset', '', '', 'Malik Petroleum', '', 5, 5, 25, 1, ''),
(10, 4, 'some', '', 'payable', '', 'else', '', '', 5, 5, 25, 0, ''),
(11, 4, '', '', 'asset', '', '', 'Malik Petroleum', '', 0, 0, 0, 1, ''),
(12, 4, '', '', 'payable', '', 'else', '', '', 0, 0, 0, 0, ''),
(13, 5, 'some', '', 'asset', '', '', 'Malik Petroleum', '', 5, 5, 25, 1, ''),
(14, 5, 'some', '', 'payable', '', 'else', '', '', 5, 5, 25, 0, ''),
(15, 5, '', '', 'asset', '', '', 'Malik Petroleum', '', 0, 0, 0, 1, ''),
(16, 5, '', '', 'payable', '', 'else', '', '', 0, 0, 0, 0, ''),
(17, 6, 'some', '', 'asset', '', '', 'Malik Petroleum', '', 5, 5, 25, 1, ''),
(18, 6, 'some', '', 'payable', '', 'else', '', '', 5, 5, 25, 0, ''),
(19, 7, 'some', '', 'asset', '', '', 'Malik Petroleum', '', 5, 5, 25, 1, ''),
(20, 7, 'some', '', 'payable', '', 'else', '', '', 5, 5, 25, 0, ''),
(21, 8, 'some', '', 'asset', '', '', 'Malik Petroleum', '', 34, 43, 1462, 1, ''),
(22, 8, 'some', '', 'payable', '', 'soem supplier', '', '', 34, 43, 1462, 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
