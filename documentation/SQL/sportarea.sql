-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2015 at 11:25 AM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.21-1+deb.sury.org~precise+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `peditel`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_roles`
--

CREATE TABLE IF NOT EXISTS `assigned_roles` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `role_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `assigned_roles_to_roles` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`user_id`, `role_id`) VALUES
(0, 0),
(1, 1),
(77, 1),
(83, 1),
(86, 1),
(2, 2),
(3, 2),
(5, 2),
(8, 2),
(12, 2),
(14, 2),
(15, 2),
(16, 2),
(19, 2),
(21, 2),
(26, 2),
(28, 2),
(29, 2),
(31, 2),
(34, 2),
(42, 2),
(43, 2),
(45, 2),
(50, 2),
(52, 2),
(53, 2),
(54, 2),
(58, 2),
(64, 2),
(65, 2),
(68, 2),
(70, 2),
(71, 2),
(72, 2),
(75, 2),
(76, 2),
(4, 3),
(20, 3),
(30, 3),
(46, 3),
(47, 3),
(48, 3),
(51, 3),
(57, 3),
(9, 4),
(11, 4),
(18, 4),
(22, 4),
(23, 4),
(27, 4),
(35, 4),
(37, 4),
(41, 4),
(55, 4),
(56, 4),
(60, 4),
(62, 4),
(66, 4),
(67, 4),
(73, 4),
(6, 5),
(7, 5),
(10, 5),
(13, 5),
(17, 5),
(24, 5),
(25, 5),
(32, 5),
(33, 5),
(36, 5),
(38, 5),
(39, 5),
(40, 5),
(44, 5),
(49, 5),
(59, 5),
(61, 5),
(63, 5),
(69, 5),
(74, 5);

-- --------------------------------------------------------

--
-- Table structure for table `crud_logs`
--

CREATE TABLE IF NOT EXISTS `crud_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('c','r','u','d') COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `table` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_id` int(10) unsigned DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crud_logs_to_users` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=955 ;

--
-- Dumping data for table `crud_logs`
--

--
-- Table structure for table `errors`
--

CREATE TABLE IF NOT EXISTS `errors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `error` text COLLATE utf8_unicode_ci,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `line` int(10) unsigned DEFAULT NULL,
  `first_seen` datetime NOT NULL,
  `last_seen` datetime NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '1',
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `request` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `errors_for_users` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=254 ;

--
-- Table structure for table `forgot_passwords`
--

CREATE TABLE IF NOT EXISTS `forgot_passwords` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `found` tinyint(1) NOT NULL COMMENT 'if the email address was found or not',
  `reset` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if the password was reset or not',
  `ip2long` int(11) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `forgot_passwords_to_users` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu` tinyint(1) NOT NULL,
  `menu_icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=609 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `table`, `name`, `menu`, `menu_icon`, `module_id`) VALUES
(400, 'settings', 'Setări', 0, 'icon-wrench', NULL),
(401, 'users', 'Utilizatori', 1, 'icon-wrench', NULL),
(402, 'roles', 'Roluri', 0, 'icon-wrench', 400),
(405, 'errors', 'Erori sistem', 0, 'icon-wrench', 400),
(411, 'dashboard', 'Dashboard', 0, 'icon-home', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `account_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_to_accounts` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `public`, `account_id`) VALUES
(1, 'Superadmin', 0, NULL),
(2, 'Operator', 1, NULL),
(3, 'Utilizator', 1, NULL);
-- --------------------------------------------------------

--
-- Table structure for table `roles_in_modules`
--

CREATE TABLE IF NOT EXISTS `roles_in_modules` (
  `role_id` mediumint(8) unsigned NOT NULL,
  `module_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`module_id`),
  KEY `roles_in_modules_to_modules` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles_in_modules`
--

INSERT INTO `roles_in_modules` (`role_id`, `module_id`) VALUES
(1, 100),
(2, 100),
(1, 400),
(2, 400),
(1, 401),
(2, 401),
(1, 402),
(2, 402),
(1, 405),
(2, 405),
(1, 406),
(2, 406),
(1, 407),
(2, 407),
(1, 408),
(2, 408),
(1, 409),
(2, 409),
(1, 410),
(2, 410),
(1, 411),
(2, 411);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `full_court` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'RO: complet',
  `solution` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'RO: complet',
  `solution_details` text COLLATE utf8_unicode_ci COMMENT 'RO: complet',
  `pronouncement_date` datetime DEFAULT NULL COMMENT 'RO: complet',
  `document_session` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'RO: complet',
  `document_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'RO: complet',
  `document_date` datetime DEFAULT NULL COMMENT 'RO: complet',
  `case_id` int(10) unsigned NOT NULL,
  `court_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sessions_unique_key_1` (`date`,`case_id`,`court_id`),
  KEY `sessions_to_cases` (`case_id`),
  KEY `sessions_to_courts` (`court_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('boolean','integer','float','enum','checkbox','string','textarea') COLLATE utf8_unicode_ci NOT NULL,
  `possible_values` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` mediumint(8) unsigned NOT NULL,
  `account_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_accounts` (`setting`,`account_id`),
  KEY `category_id` (`category_id`),
  KEY `settings_to_accounts` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting`, `title`, `description`, `type`, `possible_values`, `value`, `category_id`, `account_id`) VALUES
(1, 'environment', 'Environment', NULL, 'enum', '{"development":"Development","staging":"Staging","production":"Production"}', 'development', 1, NULL),
(2, 'email_address', 'Email adresa', NULL, 'string', '', 'hegedus.norbert@yahoo.ro', 1, NULL),
(3, 'email_name', 'Email nume', NULL, 'string', '', 'Norbert Hegedus', 1, NULL),
(4, 'remember_cookie_lifetime', 'Durata cookie logare', 'Durata de viata a cookie-ului de logare automata.', 'enum', '{"60":"1 Minut","3600":"1 Ora","21600":"6 Ore","43200":"12 Ore","86400":"1 Zi","172800":"2 Zile","259200":"3 Zile"}', '60', 1, NULL),
(5, 'results_per_page', 'Numar rezultate per pagina', 'Numarul de rezultate (utilizatori, clienti, etc) afisati per pagina', 'enum', '{"15":"15 rezultate","25":"25 rezultate","50":"50 rezultate","100":"100 rezultate"}', '15', 1, NULL),
(6, 'date_format', 'Format data', 'Formatul datei afisat in cadrul portalului', 'enum', '{"Y-m-d":"yyyy-mm-dd","Y.m.d":"yyyy.mm.dd","Y/m/d":"yyyy/mm/dd","d-m-Y":"dd-mm-yyyy","d.m.Y":"dd.mm.yyyy","d/m/Y":"dd/mm/yyyy"}', 'd/m/Y', 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `settings_categories`
--

CREATE TABLE IF NOT EXISTS `settings_categories` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `settings_categories`
--

INSERT INTO `settings_categories` (`id`, `name`) VALUES
(1, 'Setari globale'),
(2, 'Setari generale'),
(3, 'Date pentru contracte'),
(4, 'Date pentru facturare'),
(5, 'Notificari');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sha1(plain text password + salt). plain text password: Minimum 8 chars, At least one upper char, At least one special char, At least one cipher',
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'do NOT update it!',
  `status` enum('active','pending','suspended') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_salt` (`salt`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `salt`, `status`, `deleted`) VALUES
(1, 'Super', 'Admin', 'superadmin@sample.com', '8158b68d28c389a3fd2d0c561f2f0eb57ede086f', 'jtoxHSRBYsK1ZiugDIAT', 'active', 0),

-- --------------------------------------------------------

--
-- Table structure for table `_information_table`
--

CREATE TABLE IF NOT EXISTS `_information_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
