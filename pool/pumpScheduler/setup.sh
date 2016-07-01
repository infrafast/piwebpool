#!/bin/sh

#database
mysql -uroot -p Quintal74605 pool < ./sql/create.sql
mysql -uroot -p Quintal74605 pool < ./sql/measures.sql
mysql -uroot -p Quintal74605 pool < ./sql/pumpSchedule.sql
mysql -uroot -p Quintal74605 pool < ./sql/scripts.sql
mysql -uroot -p Quintal74605 pool < ./sql/settings.sql

#file permission and configuration
sudo chmod 774 /etc/ssmtp/ssmtp.conf
sudo usermod -a -G webide www-data
chmod 0775 css js

#periodic execution of the script
ln -s /var/www/html/pumpScheduler/hourlycrontab.sh /etc/cron.hourly/pumpScheduler
#this is to access the ttyUSB0 from apache
sudo usermod -a -G dialout www-data