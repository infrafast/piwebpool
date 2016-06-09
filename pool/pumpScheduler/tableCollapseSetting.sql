DROP TABLE IF EXISTS `tableCollapseSetting`;
CREATE TABLE `tableCollapseSetting` ( `id` VARCHAR(40) NOT NULL , `value` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `tableCollapseSetting` (`id`, `value`) VALUES ('actionTable', '0'), ('scheduleTable', '0')