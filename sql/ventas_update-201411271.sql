ALTER TABLE `picture` ADD COLUMN `status` INT(1) DEFAULT 1 NOT NULL AFTER `title`;

DELIMITER $$

DROP PROCEDURE IF EXISTS `getProductPictures`$$

CREATE PROCEDURE `getProductPictures`(IN varProduct INT)
BEGIN
	SELECT 
		picture.id,
		picture.file,
		picture.title
	FROM picture
		INNER JOIN product ON product.id = picture.product
	WHERE 	product.id = varProduct AND
		picture.`status` <> 0;
END$$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS `removeProductPicture`$$

CREATE PROCEDURE `removeProductPicture`(IN varPictureId INT)
BEGIN
	UPDATE picture SET `status` = 0 WHERE id = varPictureId;
	SELECT 1 AS result;
END$$

DELIMITER ;