#!/bin/sh
mysql -uroot -p Quintal74605 pool < ./sql/create.sql
mysql -uroot -p Quintal74605 pool < ./sql/measures.sql
mysql -uroot -p Quintal74605 pool < ./sql/pumpSchedule.sql
mysql -uroot -p Quintal74605 pool < ./sql/scripts.sql
mysql -uroot -p Quintal74605 pool < ./sql/settings.sql
