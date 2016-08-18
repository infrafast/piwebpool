delete from scripts where id="header";
delete from scripts where id="footer";
insert into scripts (id,xml,lua) values ('header','',LOAD_FILE('/tmp/header.lua'));
insert into scripts (id,xml,lua) values ('footer','',LOAD_FILE('/tmp/footer.lua'));