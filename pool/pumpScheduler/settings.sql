DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(40) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `userSetting` BOOLEAN NOT NULL ,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `value`, `userSetting`,`description`) VALUES
('scheduler', 1, true, 'Activation planificateur filtration'),
('logTable', 1, false, ''),
('actionTable', 1, false, ''),
('blocklyTable', 1, false, ''),
('Planificateur', 1, false, ''),
('sensorTable', 0, false, ''),
('Parametres', 1, false, ''),
('measureIndex', 0, false, '');

ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`);