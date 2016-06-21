DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(40) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `userSetting` BOOLEAN NOT NULL ,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `value`, `userSetting`,`description`) VALUES
('scheduler', 1, true, 'Activation planificateur filtration'),
('logTableCollapse', 1, false, ''),
('actionTableCollapse', 1, false, ''),
('blocklyTableCollapse', 1, false, ''),
('scheduleTableCollapse', 1, false, ''),
('sensorTableCollapse', 0, false, ''),
('settingsTableCollapse', 1, false, '');


ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);