SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `expenses` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `expenses`;

CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(6) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `expdata` (
  `id` int(11) NOT NULL,
  `xDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Person` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method_id` smallint(6) NOT NULL,
  `category_id` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `paymentmethods` (
  `id` smallint(6) NOT NULL,
  `Method` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `view_all` (
`id` int(11)
,`Date` date
,`Amount` decimal(10,2)
,`Person` varchar(20)
,`Description` varchar(255)
,`Method` varchar(255)
,`Category` varchar(255)
);
DROP TABLE IF EXISTS `view_all`;

CREATE ALGORITHM=MERGE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_all` AS select `expdata`.`id` AS `id`,`expdata`.`xDate` AS `Date`,`expdata`.`Amount` AS `Amount`,`expdata`.`Person` AS `Person`,`expdata`.`Description` AS `Description`,`paymentmethods`.`Method` AS `Method`,`categories`.`Name` AS `Category` from ((`expdata` join `paymentmethods` on((`expdata`.`method_id` = `paymentmethods`.`id`))) join `categories` on((`expdata`.`category_id` = `categories`.`id`))) order by `expdata`.`xDate`,`expdata`.`id`;


ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD FULLTEXT KEY `Name` (`Name`);

ALTER TABLE `expdata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `xDate` (`xDate`),
  ADD KEY `Person` (`Person`),
  ADD KEY `method_id` (`method_id`),
  ADD KEY `category_id` (`category_id`),
  ADD FULLTEXT KEY `Description` (`Description`);

ALTER TABLE `paymentmethods`
  ADD PRIMARY KEY (`id`),
  ADD FULLTEXT KEY `Method` (`Method`);


ALTER TABLE `categories`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;
ALTER TABLE `expdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paymentmethods`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

ALTER TABLE `expdata`
  ADD CONSTRAINT `expdata_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `method_id_paymethod_id` FOREIGN KEY (`method_id`) REFERENCES `paymentmethods` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
