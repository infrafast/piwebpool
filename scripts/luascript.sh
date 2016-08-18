#!/bin/sh
sudo rm -rf /tmp/*.lua
sudo ln -s /usr/share/piwebpool/sql/header.lua /tmp
sudo ln -s /usr/share//piwebpool/sql/footer.lua /tmp
mysql pool -uroot -pQuintal74605 < ./sql/lua.sql