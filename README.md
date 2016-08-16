---------------------------------------------------------
WELCOME TO PIWEB POOL MANAGER
---------------------------------------------------------

The first full open source Raspberry PI PHP web-based application that automates the control of swiming pool with following features:
- water quality measurement (PH, ORP, Temperature)
- controls up to 4 power outlet (treatment, 
- scheduler that control filtration aoccrding to water temperature
- can be controlled over your iPhone or any mobile device
- provide graphical scripting capabilities (with Lua and Blockly)


Interfaces with :
- Domoticz and any other home automation system thru a simple HTTP API


Dependencies:
    python-serial               :data acquisition via usb devices
    php5-mysql,mysql-server:    :database and connectivity
    apache2,php5                :webserver 
    php5-curl                   :interfacing other system via HTTP/Json API (like domoticz)
    php5-gd                     :image png generation    
    ssmtp                       :email notification
    anacron                     :hourly execution of tasks (used by pump scheduler)
    php-pear,php5dev and pecl   :compilation of lua for php
    lua5.1,liblua5.1            :lua script execution engine (also include liblua5.1-dev which include the "include" necessary to compile)
    phpserial.php               :patched with if ($this->_exec("stty") === 0) { changed to if ($this->_exec("stty --version") === 0) {

---------------------------------------------------------
PLATFORM SETUP FROM SCRACTH
---------------------------------------------------------
You will find a script named setup.sh in the root directory, this script almost fully automates the installation of the application.
Some manual steps are however required. You are advise to make the installation on a fresh raspberry dedicated to the application.
Otherwise, have a look to the script before to make sure it doesn't break anything if you perform the setup on a productive raspberry 
already used for other need. 

1) First, make sure your raspberry config is ok
    sudo raspi-config
         1-expand file system
         5-locale fr UTF 8
         5-timezone europe paris
         5-keyboard layout
             generic 105 - german french switzerland
         9-advanced - sethostname: piweb3
         9-advanced enable ssh
    apt-get install rpi-update
    rpi-update

2) setup wifi if not done (optionnal)
    sudo vi /etc/wpa_supplicant/wpa_supplicant.conf
        country=FR                                                                                                                                              
        ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev                                                                                                 
        update_config=1                                                                                                                                         
        network={                                                                                                                                               
           ssid="ASUS_AP"                                                                                                                                       
           psk="jt2p9ug1"                                                                                                                                       
        } 

3) install adafruit webide (optional)        
    curl https://raw.githubusercontent.com/adafruit/Adafruit-WebIDE/alpha/scripts/install.sh | sudo sh
    goto http://your_raspberry_ip/config change port to 8090
    sudo service adafruit-webide.sh restart

4) run the piwebpool install script
    source setup.sh

5) check and modify the configuration with your setup:
    hourlycrontab.sh                                :change INTERFACE="wlan0" to your network interface
    /etc/rc.local                                   :make sure rc.local is updated
    /etc/ssmtp/ssmtp.conf                           :edit your service provider info
        root=postmaster
        mailhub=mail.gandi.net:587
        hostname=piweb
        AuthUser=admin@infrafast.com
        AuthPass=Quxxxxxxxx04
        UseSTARTTLS=YES    
        rewriteDomain=infrafast.com
        FromLineOverride=YES
    /etc/ssmtp/revaliases                           :edit your service provider info
        www-data:admin@infrafast.com:mail.gandi.net:587
    /etc/apache2/sites-available/000-default.conf   :make sure the documentroot point to piweb directory
    /etc/php5/(cli+apache)/php.ini
        Add extension=lua.so to php.ini file (could be )
        find "Dynamic Extensions" and add extension=lua.so
        /etc/init.d/apache2 restart
   
---------------------------------------------------------
TODO LIST 
---------------------------------------------------------

    - use HTTPS
    - basic auth implementation
    - pursue the watchdog config
    - set debug level
    - initUSB.py to :
            catch exception if device is not existing
            raise SerialException("could not open port %s: %s" % (self._port, msg)) 
            store the device in text file corresponding to Ph Orp and Rtd
    - to read the device in file generated by python initUSB
    - http://juice4halt.com/
    - move all js code to js
    - add user/admin setup  
        - editable field in script table with possible value: "user","admin","none"
        - header and footer will have "none"
        - custom will have "user"
        - main will have "admin"
    - implement installation wizard
    - finalize forecast / interpretation of the data
    - implement i18n
    - use PDO or mysqli 
    - script combo populated by select * from scripts ID
    - calibration bug review
    - implement wifi wizard (https://github.com/sabhiram/raspberry-wifi-conf)
    

known bugs:
    - void 
    
    
---------------------------------------------------------
HISTORICAL NOTES
-------------------------------------------------------------------

//Operating System: Linux Solution: sendmail is searching for a FQDN ( fully qualified domain name ).
//To resolve this problem change /etc/hosts: FROM:
127.0.0.1       localhost
127.0.1.1       raspberrypi
TO:
127.0.0.1       localhost.localdomain piweb
127.0.1.1       piweb piweb.infrafast.com
edit /etc/hostname and change raspberrypi to piweb





---------------------------------------------------------
System hardening
---------------------------------------------------------
http://iqjar.com/jar/raspberry-pi-rebooting-itself-when-it-becomes-unreachable-from-outside-networks/

maybe put this in /etc/rc.d/rc.local:
    while [ 1 ]
    do
     if [ -z "$(ping -c 1 www.02144.com)" ]
     then
      shutdown -r now
      #ifconfig eth0 down && ifconfig eth0 up
      #/etc/init.d/networking restart
      #dhclient eth0
     fi
     sleep 600
    done


 /etc/watchdog.conf
    ---
    #uncomment the following:
    max-load-1
    ---

sudo service watchdog start


watchdog on Pi2? Must be wrong....
    sudo apt-get install watchdog
    sudo modprobe bcm2708_wdog
    sudo vi /etc/modules
    ---
    bcm2708_wdog
    ---
    sudo update-rc.d watchdog defaults
    sudo vi /etc/watchdog.conf
    ---
    #uncomment the following:
    max-load-1
    watchdog-device
    ---
    sudo service watchdog start



-------------------------------------------------------------------
GIT USAGE QUICK GUIDE
-------------------------------------------------------------------
git status
git add -A .                 
git status
git commit -a -m "comment"   
git push origin master       

git tag -a v1.4 -m "my version 1.4"
git tag
git show v1.4

git push --follow-tags
git push --tags                    push all tags