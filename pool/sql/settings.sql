DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `userSetting` BOOLEAN NOT NULL ,
  `description` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
  
INSERT INTO `settings` (`id`, `value`, `userSetting`,`description`) VALUES
('webURL', 1, true, 'Activation planificateur filtration'),
('scheduler', 1, true, 'Activation planificateur filtration'),
('ORPConsign', 750, true, 'Consigne ORP'),
('PHConsign', 7.24, true, 'Consigne PH'),
('TEMPConsign', 28, true, 'Consigne Température'),
('e_mail', "szemrot@hotmail.com", true, 'email recevant les notifications'),
('logTable', 1, false, ''),
('actionTable', 1, false, ''),
('blocklyTable', 1, false, ''),
('Planificateur', 1, false, ''),
('sensorTable', 0, false, ''),
('Parametres', 1, false, ''),
('measureIndex', 30, false, 'Compteur dernière mesure');

ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`); 