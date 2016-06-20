DROP TABLE IF EXISTS `scripts`;
CREATE TABLE IF NOT EXISTS `scripts` (
  `id` varchar(255) NOT NULL,
  `xml` text NOT NULL,
  `lua` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `scripts` (`id`, `xml`, `lua`) VALUES
('custom', '<xml xmlns="http://www.w3.org/1999/xhtml"></xml>', ''),
('main', '<xml xmlns="http://www.w3.org/1999/xhtml"><block type="controls_if" id="#k:`8J.D:{zzYDg00AnU" x="109" y="30"><value name="IF0"><block type="logic_compare" id="-92_1,Ve7hB!5Q.,VRKh"><field name="OP">GT</field><value name="A"><block type="sensors" id="#lk|+Xd;OpMg*=]))P}s"><field name="select">temperature</field></block></value><value name="B"><block type="math_number" id="wNzqwnx3yZzR=IGMAM1*"><field name="NUM">15</field></block></value></block></value><statement name="DO0"><block type="setcommand" id="bh90jirdqe!b.NXEf9?B"><field name="command">traitement</field><value name="NAME"><block type="on_off" id="UIbvnLJ%MRvmz07jC%pw"><field name="command">1</field></block></value></block></statement></block></xml>', 'if (temperature) > 15 then\n  set(traitement,(1));\nend\n');

 INSERT INTO `scripts` (`id`, `xml`, `lua`) VALUES ('header', '', 'function run() info="Lua script executed"; '), ('footer', ' return info; end', '')

ALTER TABLE `scripts`
 ADD PRIMARY KEY (`id`);
 
