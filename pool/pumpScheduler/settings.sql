DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` ( `id` VARCHAR(40) NOT NULL , `value` BOOLEAN NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `settings` (`id`, `value`) VALUES ('actionTableCollapse', '0'), ('scheduleTableCollapse', '0'), ('sensorTableCollapse', '0'), ('blocklyTableCollapse', '0');