#!/bin/sh
echo "create database"
mysql -uroot -pQuintal74605 < ./sql/create.sql
echo "create measures table"
mysql pool -uroot -pQuintal74605 < ./sql/measures.sql
echo "create pump schedule table"
mysql pool -uroot -pQuintal74605 < ./sql/pumpSchedule.sql
echo "create scripts table"
mysql pool -uroot -pQuintal74605 < ./sql/scripts.sql
echo "create settings table"
mysql pool -uroot -pQuintal74605 < ./sql/settings.sql
pause