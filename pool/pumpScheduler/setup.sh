#!/bin/sh
pause(){
 echo press enter    
 sed -n q </dev/tty
}

#necessary packages
# php-pear and php5-dev are for pecl and compliation of lua for php
#note : liblua5.1 also include liblua5.1-dev which include the "include" necessary to compile lua for php
sudo apt-get --assume-yes install apache2 php5 php5-mysql ssmtp anacron mysql-server lua5.1 liblua5.1 php-pear php5-dev
pause

# installing and compiling LUA for PHP
echo NOW SETTING UP LUA FOR PHP
sudo ln -s /usr/include/lua5.1 /usr/include/lua
sudo ln -s /usr/include/lua5.1/* /usr/include
sudo cp /usr/lib/arm-linux-gnueabihf/liblua5.1.a /usr/lib/liblua.a
sudo cp /usr/lib/arm-linux-gnueabihf/liblua5.1.so /usr/lib/liblua.so
wget https://pecl.php.net/get/lua-1.0.0.tgz
tar zxvf https://pecl.php.net/get/lua-1.0.0.tgz
cd lua-1.0.0
phpize
./configure --with-php-config=/usr/bin/php-config --with-lua=/usr/bin/lua
sudo make
sudo make install
pause

#website
echo "CONFIGURING APACHE"
sudo ln -s /usr/share/adafruit/webide/repositories/my-pi-projects/pool/pumpScheduler /var/www/html/
sudo sed -i 's_DocumentRoot /var/www/html_DocumentRoot /var/www/html/pumpScheduler_' /etc/apache2/sites-available/000-default.conf
sudo service apache2 restart
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
pause

#
echo installing gprio command
git clone git://git.drogon.net/wiringPi
cd wiringPi
git pull origin
./build
cd ..
rm -rf wiringPi

