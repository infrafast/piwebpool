#!/bin/sh
sudo ln -s ./sql/header.lua /tmp
sudo ln -s ./sql/footer.lua /tmp
mysql pool -uroot -pQuintal74605 < ./sql/lua.sql