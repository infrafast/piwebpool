#!/bin/sh
sudo ln -s ./sql/header.lua /tmp
sudo ln -s ./sql/footer.lua /tmp
mysql -uroot -pQuintal74605 < ./sql/lua.sql