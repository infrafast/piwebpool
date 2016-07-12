DROP TABLE IF EXISTS `scripts`;
CREATE TABLE IF NOT EXISTS `scripts` (
  `id` varchar(255) NOT NULL,
  `xml` text NOT NULL,
  `lua` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
 
INSERT INTO `scripts` (`id`, `xml`, `lua`) VALUES
('custom', '<xml xmlns="http://www.w3.org/1999/xhtml"></xml>', ''),
('main', '&lt;xml xmlns="http://www.w3.org/1999/xhtml"&gt;&lt;block type="variables_set" id="B]P2Ee!Dy^}mSk2{4g_c" x="97" y="19"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="z`fw9,GRplfJq3]RP[1n"&gt;&lt;mutation items="8"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id=".[#0`r,gC,R%Z9AL,=L_"&gt;&lt;field name="TEXT"&gt;&agrave; &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="dynamicData" id=",GyZ3V:kUp*PQ{U{U3.P"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD2"&gt;&lt;block type="text" id="0?h|VL]K@}g(,4Z3U.cp"&gt;&lt;field name="TEXT"&gt;h, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD3"&gt;&lt;block type="dynamicData" id=".;*aZo7kV0whS@Az0qqU"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD4"&gt;&lt;block type="text" id="b?5B]X2A5NctY=dG}.[;"&gt;&lt;field name="TEXT"&gt;&deg;C, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD5"&gt;&lt;block type="dynamicData" id="DSm?H0yUkLf:d0)PyJ,S"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD6"&gt;&lt;block type="text" id="I(@aL(m0AB!27s^LIPU@"&gt;&lt;field name="TEXT"&gt;mV, Ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD7"&gt;&lt;block type="dynamicData" id="`JLuiip8Dqw?c%rF1A3U"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="l3.rre@Q^6z1I=GspA;|"&gt;&lt;field name="command"&gt;log&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="57#JgVrwyzZcS14VN|x#"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="LqI|ms-G~+.Qbl][H_dU"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="RDsd:z~N}0(~M(x1:pje"&gt;&lt;field name="TEXT"&gt;.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="3Ik/c}U^FvpMc]Mkibb!"&gt;&lt;mutation else="1"&gt;&lt;/mutation&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="1SQ9M646)fK^j2AfYw=n"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="C|CEFM-n?YV)VdsAhnhD"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="ARL:4,dPe=wG7JkrD)Fl"&gt;&lt;field name="NUM"&gt;15&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="math_change" id="wu*^f_G`3]Rtx6]%jmmn"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;value name="DELTA"&gt;&lt;block type="math_number" id="40BWy%+[^,ClPoc@qOwe"&gt;&lt;field name="NUM"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="e-:lXcLj4l.%7RXvPa?0"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="qT!_D`/jq`?T-NiEc~Qp"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="crWc@li`F)^wz`=~RF,g"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="at9|XsjbZ4of9/b2R{VO"&gt;&lt;field name="NUM"&gt;2&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="gNbi)6}glFr~Ezq_bK)g"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="|+M[NUn1gcI=Z?uMA*3G"&gt;&lt;field name="command"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id=".xE0^?7O;kH29[Ux7^84"&gt;&lt;field name="VAR"&gt;memoire["temperatureFaible"]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="math_number" id="g=X8FaLt.`[XuVT=X,HU"&gt;&lt;field name="NUM"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="XWxd,}I|K]q?TjGboIi5"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text" id="=IOrOn]fl.41s?T%];Ij"&gt;&lt;field name="TEXT"&gt; Traitement arr&ecirc;t&eacute;, &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;statement name="ELSE"&gt;&lt;block type="setcommand" id="~jFPwmPFD336^QjLQ-b|"&gt;&lt;field name="command"&gt;traitement1&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="PqJa{^qmTRwmC-}-+n!5"&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="mnD*{e!M9CL;Zc5=QN%?"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="C4zLWuKDhVP]sr[rIHZ("&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="Dw6(%U8_f.|M!6U9P1(l"&gt;&lt;field name="select"&gt;temperature&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="9uh?F0.z-k])An)NI6_]"&gt;&lt;field name="NUM"&gt;3&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="math_change" id="%t771mH]Jyw[:!Is-b%j"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;value name="DELTA"&gt;&lt;block type="math_number" id="A%AkdzfqR}c;O4[kT,[5"&gt;&lt;field name="NUM"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="controls_if" id="(/,pnN}dji:UxcZ0aLh1"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="XxwFTG|a|3!}pTFt=j5R"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="HAsxsO]!UkE_zQtJrCGT"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="IF|.dL;VO]K?r84XGS^d"&gt;&lt;field name="NUM"&gt;2&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="setcommand" id="a^46,4JdO[h%/2e2:8YP"&gt;&lt;field name="command"&gt;filtration&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="on_off" id="bJ:%YR1UIuWaBrREZ2f="&gt;&lt;field name="command"&gt;1&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="hTmgXdr/R^N,KY+L1lPR"&gt;&lt;field name="VAR"&gt;memoire["gel"]&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="math_number" id="}:+f/^Z^X7R.nHynV^lG"&gt;&lt;field name="NUM"&gt;0&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="variables_set" id="f{~mRB*0?jHa(9/0VmjT"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="P6iQ6aUyk(P]8uv!mI:("&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="bD^uq_O+c%6wIhi:ynAB"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="text" id="DB%z~|zF`2kAAK5r.@_d"&gt;&lt;field name="TEXT"&gt; Attention, risque de gel!  Filtration activ&eacute;e.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="_r31.}Le!r.0w2%l5^j*"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_operation" id="zSce%Cd!m8MJXwk7g}kw"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="3*lww/YRM?wNbof1H/EW"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id=";9T{C=P;N-U%ZXWuKs#2"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="0_gT/T?Hjn9%E+d3`E9_"&gt;&lt;field name="NUM"&gt;7&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id="Z,1FyDzL~NNwvIVTY#xI"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="+lxy:pCGAh=OG)^k5jkK"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id=".UHfCeH=v+2z@3RQ/@^}"&gt;&lt;field name="select"&gt;ph&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="hDT@4}pEjlG}1{NT3D7#"&gt;&lt;field name="NUM"&gt;8&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_operation" id="akeX;TDrVO#5D{rPqv]K"&gt;&lt;field name="OP"&gt;OR&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="logic_compare" id="N@RTf4~*v+;y/4pr(bl+"&gt;&lt;field name="OP"&gt;LT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="YqUgqo`j~+bP66:mPUb-"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="xyhIdJ%_8`Oc1f|s:nU-"&gt;&lt;field name="NUM"&gt;550&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="logic_compare" id="9s2z/qOpA}BA6{(-79~j"&gt;&lt;field name="OP"&gt;GT&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="L!^@BmB8.Rwj?k{Ur]UJ"&gt;&lt;field name="select"&gt;orp&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="APrTG`;s6Ftp#s149J(m"&gt;&lt;field name="NUM"&gt;800&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="jkb654y.12]LPs|)dJeK"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="s-DBqaE!Dp0`T{~0rdY!"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="WP5|8{?i1RsaqUg2^f~g"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="text" id="5Y]v:C;IZ6yeE::JdeK]"&gt;&lt;field name="TEXT"&gt; Attention &agrave; la qualit&eacute; de l''eau.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="S+?;KDoWPw?VS0(l]2h3"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="vQp51%*GJ%n~+%^Fk,/M"&gt;&lt;field name="OP"&gt;EQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="dynamicData" id="[~{[S*I5_mhv7[rg*6el"&gt;&lt;field name="select"&gt;hour&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="math_number" id="eIB3OsrHZZV;t*9)yQ*b"&gt;&lt;field name="NUM"&gt;20&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="f4G(!19%Hf-iT%@`XLd["&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="BJmrnT6?)B;Hy|5hUoI*"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="text" id="5c:O1N-=xEL#vr=RaG_V"&gt;&lt;field name="TEXT"&gt;Rapport journalier: &lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="co!ZL}B;fx7eO]-ceQ3o"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="pmJJkuZfv@5+d)4L]R=*"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="zAR=KK3KbZYE3=g,HGX1"&gt;&lt;field name="VAR"&gt;rapport&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;next&gt;&lt;block type="controls_if" id="*n4agXBBUpv5{D:_qIAq"&gt;&lt;value name="IF0"&gt;&lt;block type="logic_compare" id="70t)D`K;g4D;i34QY]Jw"&gt;&lt;field name="OP"&gt;NEQ&lt;/field&gt;&lt;value name="A"&gt;&lt;block type="variables_get" id="J!YOTfoyBxTZ00Wj]^Be"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="B"&gt;&lt;block type="text" id="L[,ShRbzHR=D#H:9@0CV"&gt;&lt;field name="TEXT"&gt;.&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;statement name="DO0"&gt;&lt;block type="variables_set" id="k.ARgxShZ*Q~A~O1]?OL"&gt;&lt;field name="VAR"&gt;emailNotif&lt;/field&gt;&lt;value name="VALUE"&gt;&lt;block type="text_join" id="n7]D*uzLlo75.i%gW_3J"&gt;&lt;mutation items="2"&gt;&lt;/mutation&gt;&lt;value name="ADD0"&gt;&lt;block type="variables_get" id="Tg;yCN[ew52xh2%5{!(D"&gt;&lt;field name="VAR"&gt;message&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;value name="ADD1"&gt;&lt;block type="variables_get" id="B7;X:q}W6*(~Ja20m0b-"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="2}-17)j(5efYt)!%%ZW5"&gt;&lt;field name="command"&gt;email&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id="q^n1kwocykG3BPm_L)gG"&gt;&lt;field name="VAR"&gt;emailNotif&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;next&gt;&lt;block type="message" id="#Fq;5,!LQ_5ta+ZO^Y4R"&gt;&lt;field name="command"&gt;log&lt;/field&gt;&lt;value name="NAME"&gt;&lt;block type="variables_get" id=".zy[|h3FuT7~a+:%:b6G"&gt;&lt;field name="VAR"&gt;alarme&lt;/field&gt;&lt;/block&gt;&lt;/value&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/statement&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/next&gt;&lt;/block&gt;&lt;/xml&gt;', 'message = table.concat({''&agrave; '', hour, ''h, '', temperature, ''&deg;C, '', orp, ''mV, Ph'', ph});\nlog((message));\nalarme = ''.'';\nif (temperature) &lt; 15 then\n  memoire[''temperatureFaible''] = memoire[''temperatureFaible''] + 1\n  if (memoire[''temperatureFaible'']) == 2 then\n    set(traitement1,(0));\n    memoire[''temperatureFaible''] = 0;\n    alarme = '' Traitement arr&ecirc;t&eacute;, '';\n  end\n else\n  set(traitement1,(1));\nend\nif (temperature) &lt; 3 then\n  memoire[''gel''] = memoire[''gel''] + 1\n  if (memoire[''gel'']) == 2 then\n    set(filtration,(1));\n    memoire[''gel''] = 0;\n    alarme = alarme .. '' Attention, risque de gel!  Filtration activ&eacute;e.'';\n  end\nend\nif (ph) &lt; 7 or ((ph) &gt; 8 or ((orp) &lt; 550 or (orp) &gt; 800)) then\n  alarme = alarme .. '' Attention &agrave; la qualit&eacute; de l\\''eau.'';\nend\nif (hour) == 20 then\n  rapport = ''Rapport journalier: '' .. message;\n  email((rapport));\nend\nif (alarme) ~= ''.'' then\n  emailNotif = message .. alarme;\n  email((emailNotif));\n  log((alarme));\nend\n');

insert into scripts (id,xml,lua) values ('header','',LOAD_FILE('/tmp/header.lua'));
insert into scripts (id,xml,lua) values ('footer','',LOAD_FILE('/tmp/footer.lua'));

ALTER TABLE `scripts`
 ADD PRIMARY KEY (`id`);
