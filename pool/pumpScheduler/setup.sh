#!/bin/sh
pause(){
 read -n1 -rsp $'Press any key to continue or Ctrl+C to exit...\n'
}

#necessary packages
sudo apt-get --assume-yes install apache2 php5 php5-mysql ssmtp anacron mysql-server
pause

#website root
sudo ln -s /usr/share/adafruit/webide/repositories/my-pi-projects/pool/pumpScheduler /var/www/html/
pause

#database
mysql -uroot -p Quintal74605 pool < ./sql/create.sql
mysql -uroot -p Quintal74605 pool < ./sql/measures.sql
mysql -uroot -p Quintal74605 pool < ./sql/pumpSchedule.sql
mysql -uroot -p Quintal74605 pool < ./sql/scripts.sql
mysql -uroot -p Quintal74605 pool < ./sql/settings.sql
pause

#file permission and configuration
sudo chmod 774 /etc/ssmtp/ssmtp.conf
sudo usermod -a -G webide www-data
chmod 0775 css js
#periodic execution of the script
ln -s /var/www/html/pumpScheduler/hourlycrontab.sh /etc/cron.hourly/pumpScheduler
#this is to access the ttyUSB0 from apache
sudo usermod -a -G dialout www-data