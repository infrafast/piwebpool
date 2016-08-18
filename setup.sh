#!/bin/sh

#git repository name
reponame="piwebpool"
#folder used to store the repository when working with adafruit webide
webiderepo="/usr/share/adafruit/webide/repositories/$reponame/"
#directory of piweb, normally in html apache folder
piwebpooldir="/var/www/html"


pause(){
 echo press enter    
 sed -n q </dev/tty
}



#necessary packages 
# php-pear and php5-dev are for pecl and compliation of lua for php
#note : liblua5.1 also include liblua5.1-dev which include the "include" necessary to compile lua for php
#php5-gd is for image png generation
#php5-curl is for connecting to donmoticz or any other system via JSON call
echo "DOWNLOADING AND SETTING UP ALL NECESSARY PACKAGES"
sudo apt-get update
sudo apt-get --assume-yes install apache2 php5 php5-mysql php5-gd ssmtp anacron mysql-server lua5.1 liblua5.1 php-pear php5-dev python-serial php5-curl
pause
#echo "watchdog setup"
#sudo modprobe bcm2708_wdog
#sudo update-rc.d watchdog defaults
#pause
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

#if we use adafruit webide, then we link the repository to where it should be in prod
if [ -d "$webiderepo" ]
then
	sudo ln -s "$webiderepo" "$piwebpooldir"
else
	echo "$webiderepo not found."
fi


#website
echo "CONFIGURING APACHE"
sudo ln -s "$piwebpooldir/$reponame" "/var/www/html/"
#document root to be DocumentRoot /var/www/html/pool
sudo sed -i 's_DocumentRoot /var/www/html_DocumentRoot $piwebpooldir/$reponame_' /etc/apache2/sites-available/000-default.conf
sudo service apache2 restart
pause

#database
#at the end, need to have only one master sql file that do everything
echo "Please enter your database root password: "
read pwd_variable
cp ./scripts/header.lua /tmp
cp ./scripts/footer.lua /tmp
echo "create database Pool"
mysql -uroot -p$pwd_variable < ./scripts/create.sql
echo "create all tables"
mysql pool -uroot -p$pwd_variable < ./scripts/piwebpool.sql
echo "create lua header and footer code"
mysql pool -uroot -p$pwd_variable < ./scripts/lua.sql
pause

#file permission and configuration
echo "setting up permission and others"
chown -R www-data.www-data "$piwebpooldir/$reponame"
sudo chmod 774 /etc/ssmtp/ssmtp.conf
sudo usermod -a -G webide www-data
chmod g+w $piwebpooldir/$reponame
chmod -R 0775 css js include
#periodic execution of the script
sudo ln -s "$piwebpooldir/$reponame/scripts/hourlypiwebpool.sh" /etc/cron.hourly/
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

pause
echo "setting up regulatory WIFI to FR"
echo "REGDOMAIN=FR" > /etc/default/crda
echo "options cfg80211 ieee80211_regdom=FR"  >  /etc/modprobe.d/cfg80211.conf


echo "Modifying rc.local"
sudo sed -i 's_exit 0 #Piwebcontrol_' /etc/rc.local
sudo sh -c "cat ./scripts/rc.local >> /etc/rc.local"
pause


#system startup and hardening
#sudo echo "python /var/www/html/pool/initUSB.py" >> /etc/rc.local
echo "Some remaining action have to be done manually"
echo "Then, test with sudo ./hourlycrontab.sh"


