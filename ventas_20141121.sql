/*
SQLyog Community compiled by ZeusAFK v11.0 (32 bit)
MySQL - 5.6.17 : Database - ventas_deckerstore
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `userid` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `provider` varchar(50) NOT NULL,
  `lastaccess` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `account` */

insert  into `account`(`userid`,`email`,`name`,`provider`,`lastaccess`,`status`) values ('109719209221776707238','zeusafk@gmail.com','Fernando Zabala','googleplus','2014-11-17 10:15:50',1);

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `userid` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`userid`,`status`) values ('109719209221776707238',1);

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL,
  `product` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `quantity` int(1) NOT NULL DEFAULT '1',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_cart_userid` (`userid`),
  KEY `fk_cart_product` (`product`),
  CONSTRAINT `fk_cart_product` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `fk_cart_userid` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `cart` */

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text,
  `picture` varchar(50) DEFAULT NULL,
  `shortname` varchar(150) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`description`,`picture`,`shortname`,`parent`,`status`) values (1,'Prueba',NULL,NULL,'prueba',0,1);

/*Table structure for table `currency` */

DROP TABLE IF EXISTS `currency`;

CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `symbol` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `currency` */

insert  into `currency`(`id`,`symbol`,`name`,`description`) values (1,'Bs','Boliviano','Estado Plurinacional de Bolivia');

/*Table structure for table `order` */

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL,
  `latitude` float(14,6) NOT NULL,
  `longitude` float(14,6) NOT NULL,
  `location` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `contact` text NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `order` */

/*Table structure for table `order_product` */

DROP TABLE IF EXISTS `order_product`;

CREATE TABLE `order_product` (
  `order` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`order`,`product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `order_product` */

/*Table structure for table `picture` */

DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(200) NOT NULL,
  `product` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_picture_product` (`product`),
  CONSTRAINT `fk_picture_product` FOREIGN KEY (`product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `picture` */

insert  into `picture`(`id`,`file`,`product`,`title`) values (1,'27c2d2a6a22b4cda22f64db80269e30848f62d19.png',2,'');
insert  into `picture`(`id`,`file`,`product`,`title`) values (2,'e2b9d457005e1239066edc53114706ac301448d2.png',3,'');

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `shortname` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `details` text NOT NULL,
  `delivery` text,
  `price` decimal(14,2) NOT NULL DEFAULT '0.00',
  `category` int(11) NOT NULL,
  `currency` int(11) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_product_currency` (`currency`),
  CONSTRAINT `fk_product_currency` FOREIGN KEY (`currency`) REFERENCES `currency` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `product` */

insert  into `product`(`id`,`name`,`shortname`,`description`,`details`,`delivery`,`price`,`category`,`currency`,`views`,`created`,`status`) values (1,'Prueba','prueba','','',NULL,0.00,1,1,35,'0000-00-00 00:00:00',0);
insert  into `product`(`id`,`name`,`shortname`,`description`,`details`,`delivery`,`price`,`category`,`currency`,`views`,`created`,`status`) values (2,'Prueba','prueba','','','<p>null</p>\r\n',22.00,1,1,18,'0000-00-00 00:00:00',1);
insert  into `product`(`id`,`name`,`shortname`,`description`,`details`,`delivery`,`price`,`category`,`currency`,`views`,`created`,`status`) values (3,'Otro producto con alguna descripcion','otro-producto-con-alguna-descripcion','','','<p>null</p>\r\n',33.00,1,1,7,'0000-00-00 00:00:00',1);

/*Table structure for table `slider` */

DROP TABLE IF EXISTS `slider`;

CREATE TABLE `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `slider` */

insert  into `slider`(`id`,`filename`,`link`,`status`) values (1,'','',1);
insert  into `slider`(`id`,`filename`,`link`,`status`) values (2,'','',1);
insert  into `slider`(`id`,`filename`,`link`,`status`) values (3,'','',1);
insert  into `slider`(`id`,`filename`,`link`,`status`) values (4,'','',1);

/* Function  structure for function  `SPLIT_STR` */

/*!50003 DROP FUNCTION IF EXISTS `SPLIT_STR` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STR`(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
) RETURNS varchar(255) CHARSET utf8
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '') */$$
DELIMITER ;

/* Procedure structure for procedure `addProductPicture` */

/*!50003 DROP PROCEDURE IF EXISTS  `addProductPicture` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `addProductPicture`(IN varProductId INT, IN varPicture VARCHAR(250))
BEGIN
	INSERT INTO picture (`file`, `product`) VALUES (varPicture, varProductId);
END */$$
DELIMITER ;

/* Procedure structure for procedure `addProductToCart` */

/*!50003 DROP PROCEDURE IF EXISTS  `addProductToCart` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `addProductToCart`(IN varUserId VARCHAR(50), IN varProduct INT)
BEGIN
	DECLARE varCount INT;
	
	SELECT COUNT(id) INTO varCount FROM cart WHERE userid = varUserid AND product = varProduct AND `status` = 1;
	
	IF varCount = 0 THEN
		INSERT INTO cart (userid, product, created) VALUES (varUserId, varProduct, NOW());
		SELECT 1 AS result;
	ELSE
		SELECT 2 AS result;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `authenticateUser` */

/*!50003 DROP PROCEDURE IF EXISTS  `authenticateUser` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `authenticateUser`(IN varUserId VARCHAR(50), IN varEmail VARCHAR(100), IN varName VARCHAR(100), IN varProvider VARCHAR(50))
BEGIN
	DECLARE varCount INT;
	
	SELECT COUNT(`userid`) INTO varCount FROM `account` WHERE `userid` = varUserId LIMIT 1;
	
	IF varCount = 0 THEN
		INSERT INTO `account` (`userid`, `email`, `name`, `provider`, `lastaccess`) VALUES (varUserId, varEmail, varName, varProvider, NOW());
		SELECT 1 AS result;
	ELSE
		UPDATE `account` SET `lastaccess` = NOW() WHERE `userid` = varUserId;
		SELECT 1 AS result;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `checkOutCart` */

/*!50003 DROP PROCEDURE IF EXISTS  `checkOutCart` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `checkOutCart`(IN varUserId VARCHAR(50), IN varLatitude FLOAT(14,2), IN varLongitude FLOAT(14,2), IN varLocation VARCHAR(250), IN varDescription TEXT, IN varContact TEXT)
BEGIN
	DECLARE varCount INT;
	DECLARE varOrderId INT;
	DECLARE varProduct INT;
	DECLARE varQuantity INT;
	DECLARE checkOutDone INT DEFAULT 0;
	DECLARE cursorCart CURSOR FOR SELECT `product`, `quantity` FROM cart WHERE userid = varUserId AND `status` = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET checkOutDone = 1;
		
	SELECT COUNT(id) INTO varCount FROM cart WHERE userid = varUserId AND `status` = 1;
	
	IF varCount = 0 THEN
		SELECT 2 AS result;
	ELSE
		INSERT INTO `order` (`userid`, `latitude`, `longitude`, `location`, `description`, `contact`, `date`) VALUES (varUserId, varLatitude, varLongitude, varLocation, varDescription, varContact, NOW());
		
		SET varOrderId = LAST_INSERT_ID();
		
		OPEN cursorCart;
		
		build_CartCheckOut: LOOP
			IF checkOutDone = 1 THEN
				LEAVE build_CartCheckOut;
			END IF;
			    
			FETCH cursorCart INTO varProduct, varQuantity;
			
			INSERT IGNORE INTO order_product (`order`, `product`, `quantity`) VALUES (varOrderId, varProduct, varQuantity);
		END LOOP build_CartCheckOut;
			
		CLOSE cursorCart;
		
		UPDATE cart SET `status` = 0 WHERE userid = varUserId;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `checkSiteAdmin` */

/*!50003 DROP PROCEDURE IF EXISTS  `checkSiteAdmin` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `checkSiteAdmin`(IN varUserId VARCHAR(50))
BEGIN
	SELECT COUNT(`userid`) as result FROM `admin` WHERE `userid` = varUserId AND `status` = 1 LIMIT 1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `createCategory` */

/*!50003 DROP PROCEDURE IF EXISTS  `createCategory` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `createCategory`(IN varParent INT, IN varName VARCHAR(250), IN varAlias VARCHAR(150))
BEGIN
	DECLARE varCount INT;
	DECLARE varParentAlias VARCHAR(150);
	
	SELECT COUNT(id) INTO varCount FROM category WHERE id = varParent LIMIT 1;
	
	if varCount > 0 THEN
		SELECT shortname INTO varParentAlias FROM category WHERE id = varParent LIMIT 1;
	
		INSERT INTO category (`name`, `shortname`, `parent`) VALUES (varName, CONCAT(varParentAlias, '-', varAlias), varParent);
	
		SELECT CONCAT(varParentAlias, '-', varAlias) AS alias;
	ELSE
		INSERT INTO category (`name`, `shortname`, `parent`) VALUES (varName, varAlias, varParent);
	
		SELECT varAlias AS alias;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `createProduct` */

/*!50003 DROP PROCEDURE IF EXISTS  `createProduct` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `createProduct`(IN varCategory INT, IN varName VARCHAR(250), IN varAlias VARCHAR(150))
BEGIN
	INSERT INTO product (`name`, `shortname`, `category`) VALUES (varName, varAlias, varCategory);
	
	SELECT varAlias AS alias;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCartProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCartProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartProducts`(IN varUserId VARCHAR(50))
BEGIN
	SELECT 
		product.id, 
		product.name,
		product.shortname,
		product.description,
		product.details,
		product.price,
		product.views,
		product.created,
		currency.id,
		currency.symbol,
		currency.name,
		currency.description,
		category.id,
		category.name,
		category.shortname,
		category.description,
		picture.id,
		picture.file,
		picture.title,
		cart.id,
		cart.quantity
	FROM product
		INNER JOIN category ON category.id = product.category
		INNER JOIN currency ON currency.id = product.currency
		INNER JOIN picture ON picture.product = product.id
		INNER JOIN cart ON cart.product = product.id
	WHERE cart.userid = varUserId
		AND cart.status = 1
	GROUP BY product.id
	ORDER BY product.created DESC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCartQuantity` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCartQuantity` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCartQuantity`(IN varUserId VARCHAR(50))
BEGIN
	SELECT COUNT(id) FROM cart WHERE userid = varUserid AND `status` = 1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCategories` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCategories` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategories`()
BEGIN
	SELECT `id`, `name`, `description`, `picture`, `shortname`, `parent` FROM category WHERE `status` <> 0 ORDER BY parent;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getCategory` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCategory` */;

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

/* Procedure structure for procedure `getCategoryProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getCategoryProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategoryProducts`(IN varCategory INT)
BEGIN
	SELECT 
		product.id, 
		product.`name`,
		product.shortname,
		product.description,
		product.details,
		product.price,
		product.views,
		product.created,
		currency.id,
		currency.symbol,
		currency.`name`,
		currency.description,
		category.id,
		category.`name`,
		category.shortname,
		category.description,
		picture.id,
		picture.file,
		picture.title
	FROM product
		INNER JOIN category ON category.id = product.category
		INNER JOIN currency ON currency.id = product.currency
		LEFT JOIN picture ON picture.product = product.id
	WHERE category IN (
			SELECT c2.id
			FROM category AS c1
				INNER JOIN category AS c2 ON c2.parent = c1.id
			WHERE c1.id = varCategory
		) OR category = varCategory
		AND product.`status` <> 0
	GROUP BY product.id
	ORDER BY product.created DESC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getNewsProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getNewsProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getNewsProducts`()
BEGIN
	SELECT 
		product.id, 
		product.name,
		product.shortname,
		product.description,
		product.details,
		product.price,
		product.views,
		product.created,
		currency.id,
		currency.symbol,
		currency.name,
		currency.description,
		category.id,
		category.name,
		category.shortname,
		category.description,
		picture.id,
		picture.file,
		picture.title
	FROM product
		INNER JOIN category ON category.id = product.category
		INNER JOIN currency ON currency.id = product.currency
		INNER JOIN picture ON picture.product = product.id
	WHERE product.status <> 0
	GROUP BY product.id
	ORDER BY product.created DESC
	LIMIT 20;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getOrderProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getOrderProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getOrderProducts`(IN varOrder INT)
BEGIN
	SELECT product.id, order_product.quantity, product.`name`, product.shortname, product.description, product.price, currency.symbol
	FROM order_product
		INNER JOIN product ON product.id = order_product.product
		INNER JOIN currency ON currency.id = product.currency
	WHERE order_product.`order` = varOrder;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getProduct` */

/*!50003 DROP PROCEDURE IF EXISTS  `getProduct` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getProduct`(IN varProduct VARCHAR(100))
BEGIN
	UPDATE product SET views = views + 1 WHERE shortname = varProduct;
	
	SELECT 
		product.id, 
		product.`name`,
		product.shortname,
		product.description,
		product.details,
		product.delivery,
		product.price,
		product.views,
		product.created,
		currency.id,
		currency.symbol,
		currency.`name`,
		currency.description,
		c1.id,
		c1.`name`,
		c1.shortname,
		c1.description,
		c2.id,
		c2.`name`,
		c2.shortname,
		c2.description
	FROM product
		INNER JOIN category AS c1 ON c1.id = product.category
		LEFT JOIN category AS c2 ON c2.id = c1.parent
		INNER JOIN currency ON currency.id = product.currency
	WHERE product.shortname = varProduct
		AND product.`status` <> 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getProductPictures` */

/*!50003 DROP PROCEDURE IF EXISTS  `getProductPictures` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductPictures`(IN varProduct INT)
BEGIN
	SELECT 
		picture.id,
		picture.file,
		picture.title
	FROM picture
		INNER JOIN product ON product.id = picture.product
	WHERE product.id = varProduct;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getSliderElements` */

/*!50003 DROP PROCEDURE IF EXISTS  `getSliderElements` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getSliderElements`()
BEGIN
	SELECT `id`, `filename`, `link`, `status` FROM slider WHERE `status` <> 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getSubCategories` */

/*!50003 DROP PROCEDURE IF EXISTS  `getSubCategories` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getSubCategories`(IN varCategory INT)
BEGIN
	SELECT `id`, `name`, `description`, `picture`, `shortname` 
	FROM category 
	WHERE parent = varCategory
		AND `status` <> 0;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getTopViewedProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getTopViewedProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getTopViewedProducts`()
BEGIN
	SELECT 
		product.id, 
		product.name,
		product.shortname,
		product.description,
		product.details,
		product.price,
		product.views,
		product.created,
		currency.id,
		currency.symbol,
		currency.name,
		currency.description,
		category.id,
		category.name,
		category.shortname,
		category.description,
		picture.id,
		picture.file,
		picture.title
	FROM product
		INNER JOIN category ON category.id = product.category
		INNER JOIN currency ON currency.id = product.currency
		INNER JOIN picture ON picture.product = product.id
	WHERE product.status <> 0
	GROUP BY product.id
	ORDER BY product.views DESC
	LIMIT 10;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getUserOrders` */

/*!50003 DROP PROCEDURE IF EXISTS  `getUserOrders` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserOrders`(IN varUserId VARCHAR(50))
BEGIN
	SELECT `id`, `latitude`, `longitude`, `location`, `description`, `contact`, `date`, `status` FROM `order` WHERE `userid` = varUserId AND `status` <> 0 ORDER BY `status` ASC, `date` DESC;
END */$$
DELIMITER ;

/* Procedure structure for procedure `removeCategory` */

/*!50003 DROP PROCEDURE IF EXISTS  `removeCategory` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `removeCategory`(IN varCategory INT)
BEGIN
	DECLARE varProductsCount INT;
	DECLARE varCategoriesCount INT;
	
	SELECT COUNT(id) INTO varProductsCount FROM product WHERE category = varCategory AND `status` <> 0;
	SELECT COUNT(id) INTO varCategoriesCount FROM category WHERE parent = varCategory AND `status` <> 0;
	
	IF varProductsCount = 0 AND varCategoriesCount = 0  THEN
		UPDATE category SET `status` = 0 WHERE id = varCategory LIMIT 1;
		SELECT 1 AS result;
	ELSE
		SELECT 2 AS result;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `removeProduct` */

/*!50003 DROP PROCEDURE IF EXISTS  `removeProduct` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `removeProduct`(IN varProduct INT)
BEGIN
	UPDATE product SET `status` = 0 WHERE id = varProduct LIMIT 1;
END */$$
DELIMITER ;

/* Procedure structure for procedure `removeProductFromCart` */

/*!50003 DROP PROCEDURE IF EXISTS  `removeProductFromCart` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `removeProductFromCart`(IN varUserId VARCHAR(50), IN varProduct INT)
BEGIN
	DECLARE varCount INT;
	
	SELECT COUNT(id) INTO varCount FROM cart WHERE userid = varUserId AND product = varProduct AND `status` = 1;
	
	IF varCount = 0 THEN
		SELECT 2 AS result;
	ELSE
		UPDATE cart SET `status` = 0 WHERE userid = varUserId AND product = varProduct AND `status` = 1;
		SELECT 1 AS result;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `updateCategory` */

/*!50003 DROP PROCEDURE IF EXISTS  `updateCategory` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategory`(IN varId INT, IN varName VARCHAR(250), IN varAlias VARCHAR(150), IN varDescription TEXT)
BEGIN
	DECLARE varParentId INT;
	DECLARE varParentAlias VARCHAR(150);
	
	SELECT parent INTO varParentId FROM category WHERE id = varId LIMIT 1;
	
	IF varParentId = 0 THEN
		UPDATE category SET `name` = varName, `shortname` = varAlias, `description` = varDescription WHERE id = varId;
		SELECT varAlias AS alias;
	ELSE
		SELECT shortname INTO varParentAlias FROM category WHERE id = varParentId;
		
		UPDATE category SET `name` = varName, `shortname` = CONCAT(varParentAlias, '-', varAlias), `description` = varDescription WHERE id = varId;
		SELECT CONCAT(varParentAlias, '-', varAlias) AS alias;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `updateCategoryPicture` */

/*!50003 DROP PROCEDURE IF EXISTS  `updateCategoryPicture` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCategoryPicture`(IN varCategoryId INT, IN varPicture VARCHAR(250))
BEGIN
	UPDATE category SET picture = varPicture WHERE id = varCategoryId;
END */$$
DELIMITER ;

/* Procedure structure for procedure `updateProduct` */

/*!50003 DROP PROCEDURE IF EXISTS  `updateProduct` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProduct`(IN varId INT, IN varName VARCHAR(250), IN varPrice DECIMAL(14,2), IN varAlias VARCHAR(150), IN varDescription TEXT, IN varDetails TEXT, IN varDelivery TEXT)
BEGIN
	UPDATE product SET `name` = varName, `price` = varPrice, `shortname` = varAlias, `description` = varDescription, `details` = varDetails, `delivery` = varDelivery WHERE id = varId LIMIT 1;
	SELECT varAlias as alias;
END */$$
DELIMITER ;

/* Procedure structure for procedure `updateProductInCartQuantity` */

/*!50003 DROP PROCEDURE IF EXISTS  `updateProductInCartQuantity` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `updateProductInCartQuantity`(IN varUserId VARCHAR(50), IN varCart INT, IN varQuantity INT)
BEGIN
	DECLARE varCount INT;
	
	SELECT COUNT(id) INTO varCount FROM cart WHERE userid = varUserId AND id = varCart AND `status` = 1;
	
	IF varCount = 0 OR varQuantity <= 0 THEN
		SELECT 2 AS result;
	ELSE
		UPDATE cart SET `quantity` = varQuantity WHERE userid = varUserId AND id = varCart AND `status` = 1;
		SELECT 1 AS result;
	END IF;
END */$$
DELIMITER ;

/* Procedure structure for procedure `updateSliderElementPicture` */

/*!50003 DROP PROCEDURE IF EXISTS  `updateSliderElementPicture` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `updateSliderElementPicture`(IN varId INT, IN varFilename VARCHAR(250))
BEGIN
	UPDATE slider SET filename = varFilename WHERE id = varId LIMIT 1;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
