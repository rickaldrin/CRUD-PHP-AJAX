/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.11-MariaDB : Database - todolist_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`todolist_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `todolist_db`;

/*Table structure for table `todo` */

DROP TABLE IF EXISTS `todo`;

CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(75) DEFAULT NULL,
  `task_status` varchar(75) DEFAULT 'pending',
  `dtc` datetime DEFAULT NULL,
  KEY `todo_id` (`todo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

/*Data for the table `todo` */

insert  into `todo`(`todo_id`,`task_name`,`task_status`,`dtc`) values 
(24,'Task 0011','pending','2020-06-13 14:20:03'),
(25,'Task 0012','pending','2020-06-13 14:20:46'),
(26,'Task 000','pending','2020-06-13 14:21:13'),
(27,'Task 00111','Completed','2020-06-13 14:22:04'),
(28,'Task 001','Completed','2020-06-13 14:23:12');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
