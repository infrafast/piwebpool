#!/bin/sh
pause(){
 echo press enter    
 sed -n q </dev/tty
}

#necessary packages
# php-pear and php5-dev are for pecl and compliation of lua for php
#note : liblua5.1 also include liblua5.1-dev which include the "include" necessary to compile lua for php
#php5-gd is for image png generation
echo "DOWNLOADING AND SETTING UP ALL NECESSARY PACKAGES"
sudo apt-get --assume-yes install apache2 php5 php5-mysql php5-gd ssmtp anacron mysql-server lua5.1 liblua5.1 php-pear php5-dev python-serial
pause

# installing and compiling LUA 
echo "NOW CONFIGURING LUA  (symlink and lobrary copy)"
sudo ln -s /usr/include/lua5.1 /usr/include/lua
sudo ln -s /usr/include/lua5.1/* /usr/include
sudo cp /usr/lib/arm-linux-gnueabihf/liblua5.1.a /usr/lib/liblua.a
sudo cp /usr/lib/arm-linux-gnueabihf/liblua5.1.so /usr/lib/liblua.so
pause
echo "DOWNLOADING LUA FOR PHP"
#to be noticed: install via PECL is not working because 1.1.0 lead to compliation error -> sudo pecl install lua-1.1.0  fail
#therefore, we download 1.0.0 and compile it /set it up manually
wget https://pecl.php.net/get/lua-1.0.0.tgz
tar zxvf lua-1.0.0.tgz
cd lua-1.0.0
phpize
pause
echo "COMPILING LUA FOR PHP"
./configure --with-php-config=/usr/bin/php-config --with-lua=/usr/bin/lua
sudo make
sudo make install
cd ..
echo "REMOVING TEMP FILES"
pause
sudo rm -rf lua-1.0.0*

#website
echo "CONFIGURING APACHE"
sudo ln -s /usr/share/adafruit/webide/repositories/my-pi-projects/pool/pumpScheduler /var/www/html/
#document root to be DocumentRoot /var/www/html/pumpScheduler
sudo sed -i 's_DocumentRoot /var/www/html_DocumentRoot /var/www/html/pumpScheduler_' /etc/apache2/sites-available/000-default.conf
sudo service apache2 restart
pause

#database
#at the end, need to have only one master sql file that do everything
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

#file permission and configuration
echo "setting up permission and others"
sudo chmod 774 /etc/ssmtp/ssmtp.conf
sudo usermod -a -G webide www-data
chmod g+w .
chmod -R 0775 css js include
#periodic execution of the script
sudo ln -s /var/www/html/pumpScheduler/hourlycrontab.sh /etc/cron.hourly/pumpScheduler
#this is to access the ttyUSB0 from apache
sudo usermod -a -G dialout www-data
pause

#
echo "installing gpio command"
git clone git://git.drogon.net/wiringPi
cd wiringPi
git pull origin
./build
cd ..
echo "REMOVING TEMP FILES"
rm -rf wiringPi

pause
echo "cloning Blockly"
git clone https://github.com/google/blockly.git 

#system startup and hardening
#sudo echo "python /var/www/html/pumpScheduler/initUSB.py" >> /etc/rc.local
echo "Some remaining action have to be done manually"
echo "Then, test with sudo ./hourlycrontab.sh"


