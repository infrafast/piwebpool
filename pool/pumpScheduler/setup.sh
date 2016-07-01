#!/bin/sh
pause(){
 echo press enter    
 sed -n q </dev/tty
}

#necessary packages
sudo apt-get --assume-yes install apache2 php5 php5-mysql ssmtp anacron mysql-server
pause

#website root
sudo ln -s /usr/share/adafruit/webide/repositories/my-pi-projects/pool/pumpScheduler /var/www/html/
pause

#database
echo create database
mysql pool -uroot -pQuintal74605 < ./sql/create.sql
echo create measures table
mysql pool -uroot -pQuintal74605 < ./sql/measures.sql
echo create pump schedule table
mysql pool -uroot -pQuintal74605 < ./sql/pumpSchedule.sql
echo create scripts table
mysql pool -uroot -pQuintal74605 < ./sql/scripts.sql
echo create settings table
mysql pool -uroot -pQuintal74605 < ./sql/settings.sql
pause

#file permission and configuration
sudo chmod 774 /etc/ssmtp/ssmtp.conf
sudo usermod -a -G webide www-data
chmod 0775 css js
#periodic execution of the script
sudo ln -s /var/www/html/pumpScheduler/hourlycrontab.sh /etc/cron.hourly/pumpScheduler
#this is to access the ttyUSB0 from apache
sudo usermod -a -G dialout www-data

