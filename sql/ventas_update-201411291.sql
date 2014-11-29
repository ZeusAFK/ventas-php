CREATE TABLE `configuration`( `id` INT NOT NULL AUTO_INCREMENT, `key` VARCHAR(50) NOT NULL, `value` TEXT NOT NULL, PRIMARY KEY (`id`) );

INSERT INTO `configuration` (`key`) VALUES ('tos_text');

ALTER TABLE `configuration` ADD COLUMN `status` INT(1) DEFAULT 1 NOT NULL AFTER `value`;

DELIMITER $$

DROP PROCEDURE IF EXISTS `getConfigurationValue`$$

CREATE PROCEDURE `getConfigurationValue`(IN varKey VARCHAR(50))
BEGIN
	SELECT `value` FROM `configuration` WHERE `key` = varKey AND `status` <> 0;
END$$

DELIMITER ;

DELIMITER $$

DROP PROCEDURE IF EXISTS `updateConfigurationValue`$$

CREATE PROCEDURE `updateConfigurationValue`(IN varKey VARCHAR(50), IN varValue TEXT)
BEGIN
	UPDATE `configuration` SET `value` = varValue WHERE `key` = varKey AND `status` <> 0 LIMIT 1;
	SELECT 1 AS result;
END$$

DELIMITER ;