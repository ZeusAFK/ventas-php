/*
SQLyog Community compiled by ZeusAFK v11.0 (32 bit)
MySQL - 5.6.17 : Database - ventas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ventas` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `ventas`;

/*Table structure for table `category` */

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `shortname` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (1,'Art Prints','Phasellus pretium mauris ut lacus vehicula volutpat. Morbi at sodales purus. Donec dapibus malesuada nunc.','art-print-category-image.jpg','art-prints',0,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (2,'Books','Nullam commodo sapien nec nulla ultrices venenatis. Vestibulum ante ipsum primis in faucibus orci luctus.','books_category_image.jpg','books',0,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (3,'Smartphones','Donec purus lacus, pulvinar non vestibulum ut, accumsan eu justo. Nullam molestie finibus dolor aliquet.','smartphone-category-image.jpg','smartphones',0,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (4,'Gaming','Nunc dignissim viverra imperdiet. Praesent condimentum porttitor felis nec porta. Proin efficitur pellentesque tellus, vitae.','','gaming',0,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (5,'Fashion','Integer nunc libero, viverra elementum tortor scelerisque, feugiat tempus ex. Etiam a odio egestas, vulputate.','','fashion',0,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (6,'Posters','Proin feugiat nisi tellus, non imperdiet purus imperdiet id. Mauris tellus libero, vulputate pellentesque metus.',NULL,'art-prints-posters',1,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (7,'Tepestries','Proin feugiat finibus tortor, ac elementum orci consequat eget. Quisque varius et neque quis efficitur.',NULL,'art-prints-trapestries',1,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (8,'Acrylic Art Boards','Aliquam ac nisl ut ipsum auctor venenatis. Vivamus eleifend felis elit, eget scelerisque urna fringilla.',NULL,'art-prints-acrylic-art-boards',1,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (9,'Art Canvas Boards','Quisque tincidunt nisl id eros euismod fringilla. Phasellus nec ipsum et enim fermentum ornare. Nunc.',NULL,'art-prints-art-canvas-boards',1,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (10,'Licensed Manga','Aenean sem ex, pharetra sit amet lacus eget, dignissim tempus eros. Nullam congue, nulla eget.',NULL,'books-licensed-manga',2,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (11,'Magazines','Aliquam eu enim molestie, malesuada ante ut, facilisis lorem. Aenean id quam mauris. Cum sociis.',NULL,'books-magazines',2,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (12,'Cases','Phasellus eget tincidunt justo, quis tempus arcu. Pellentesque habitant morbi tristique senectus et netus et.',NULL,'smartphone-cases',2,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (13,'Accessories','Praesent imperdiet tellus congue venenatis elementum. Cum sociis natoque penatibus et magnis dis parturient montes.',NULL,'smartphone-accessories',3,1);
insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (14,'wallpapers','Aenean sed est egestas, finibus odio at, malesuada eros. Nulla scelerisque risus et elit cursus.',NULL,'smartphones-wallpapers',3,1);

/*Table structure for table `usuario` */

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` char(40) NOT NULL,
  `firname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `authority` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id`,`username`,`password`,`firname`,`lastname`,`authority`,`status`) values (1,'jfzabala','21bd12dc183f740ee76f27b78eb39c8ad972a757','Fernando','Zabala',1,1);

/* Procedure structure for procedure `getCategories` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategories`()
BEGIN
	SELECT `id`, `name`, `description`, `picture`, `shortname`, `parent` FROM category WHERE `status` <> 0 ORDER BY parent;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCategory` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategory`(IN varShortname VARCHAR(50))
BEGIN
	SELECT c1.id, c1.name, c1.description, c1.picture, c1.shortname, c2.id, c2.name, c2.shortname
	FROM category AS c1 
		LEFT JOIN category AS c2 ON c2.id = c1.parent
	WHERE c1.shortname = varShortname
		AND c1.status <> 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getSubCategories` */

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubCategories`(IN varCategory INT)
BEGIN
	SELECT `id`, `name`, `description`, `picture`, `shortname` 
	FROM category 
	WHERE parent = varCategory
		AND `status` <> 0;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
