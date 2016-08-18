#!/bin/sh
sudo rm -rf /tmp/*.lua
sudo ln -s /usr/share/adafruit/webide/repositories/piweb/pool/sql/header.lua /tmp
sudo ln -s /usr/share/adafruit/webide/repositories/piweb/pool/sql/footer.lua /tmp
mysql pool -uroot -pQuintal74605 < ./sql/lua.sql