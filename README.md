---------------------------------------------------------
WELCOME TO PIWEB POOL MANAGER
---------------------------------------------------------

The first full open source Raspberry PI PHP web-based application that automates the control of swiming pool with following features:
    - real time water quality measurement (PH, ORP, Temperature)
    - history (graphs) of commands and measures
    - weather forecast 
    - recommendation / advise on water treatment
    - controls up to 4 power outlets
    - customizable notifications by email, sms or other channel throught standard API
    - scheduler that control filtration aoccrding to water temperature
    - can be controlled over your iPhone or any mobile device
    - provide unlimited configuratio capabilities with a graphical scripting front end, no need to know programming
    - notifications (SMS, email, or smartphone)

Interfaces with :
    - Domoticz and any other home automation system thru a simple HTTP API
    - Any Smartphone applications

Supported hardware:
    - any ph,ORP and temperature probes should work
    - the application is currently using the atlas-scientific EZO circuit with USB Isolation Carrier Board
    - in case you want to interface with other circuit, all you have to do is adjusting getTemperature(), getORP() and getPh() in functions.php

---------------------------------------------------------
SETUP
---------------------------------------------------------
You will find a script named setup.sh in the root directory, this script partially automates the installation of the application.
Some manual steps are however required. You are advise to make the installation on a fresh raspberry dedicated to the application.
Otherwise, have a look to the script before to make sure it doesn't break anything if you perform the setup on a productive raspberry 
already used for other need. In case you have issues with dependencies and packages, please refer to the list later in this document
so you can fix manually.


INSTALLATION

1) cd to your /var/www/html
   sudo git clone git@bitbucket.org:infrafast/piwebpool.git
   cd piwebpool

2)  run the piwebpool install script using command "source setup.sh"
    You can change default values in setup.sh file if you wish
    Be careful, in particular the webroot is set to the piwebpool folder which could screw your existing install

CONFIGURATION
    
3) check and modify the configuration with your setup:
    
    index.php                                       : locate loadWeather("46.203962, 6.133670",0); and change it with your own coordinate
    configuration                                   : change your db password
    USBDevices.id                                   :map your sensors to the correct devices
    scripts/hourlypiwebpool.sh                      :change INTERFACE="wlan0" to your network interface
    
    /etc/rc.local                                   :make sure rc.local is updated
    /etc/ssmtp/ssmtp.conf                           :edit your service provider info
        root=postmaster
        mailhub=yourproviderserver:587
        hostname=piweb
        AuthUser=youruseremail
        AuthPass=yourpass
        UseSTARTTLS=YES    
        rewriteDomain=yourdomain
        FromLineOverride=YES
    /etc/ssmtp/revaliases                           :edit your service provider info
        www-data:youruseremail:yourproviderserver:587
    /etc/apache2/sites-available/000-default.conf   :make sure the documentroot point to piwebpool directory
    /etc/php5/(cli+apache)/php.ini
        Add extension=lua.so to php.ini file
        find "Dynamic Extensions" and add extension=lua.so
        
5) it is advised to reboot your rasp to check everything is ok or alternatively restart all services
    e.g. sudo /etc/init.d/apache2 restart


Options:
--------

A) Make sure your raspberry config is ok
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

B) setup wifi if not done (optionnal)
    sudo vi /etc/wpa_supplicant/wpa_supplicant.conf
        country=FR                                                                                                                                              
        ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev                                                                                                 
        update_config=1                                                                                                                                         
        network={                                                                                                                                               
           ssid="ASUS_AP"                                                                                                                                       
           psk="jt2p9ug1"                                                                                                                                       
        } 

C) install adafruit webide (optional) if you want to contribute         
    curl https://raw.githubusercontent.com/adafruit/Adafruit-WebIDE/alpha/scripts/install.sh | sudo sh
    goto http://your_raspberry_ip/config change port to 8090 as 80 is used by apache
    sudo service adafruit-webide.sh restart

Dependencies and third party tools (all pre-setup in the package):      
    wiringpi                    :gpio commands
    python-serial               :data acquisition via usb devices
    php5-mysql,mysql-server:    :database and connectivity
    apache2,php5                :webserver 
    php5-curl                   :interfacing other system via HTTP/Json API (like domoticz)
    php5-gd                     :image png generation    
    ssmtp                       :email notification
    anacron                     :hourly execution of tasks (used by pump scheduler)
    php-pear,php5dev,pecl       :compilation of lua for php
    lua5.1,liblua5.1            :lua script execution engine (also include liblua5.1-dev which include the "include" necessary to compile)
    phpserial.php               :patched with if ($this->_exec("stty") === 0) { changed to if ($this->_exec("stty --version") === 0) {
    tablegear                   :dynamic modified and displayed tables
    blockly                     :visual scripting
    phpmygraph                  :measures and commands graphs
    gdtext                      :text image drawing
    simpleweather.js            :weather forecast
    loadingoverlay.js           :loading page animation
    jquery                      :webpage scripting
    lua table persistence       :for persistent variable
    Thanks for the work of idleman 
    
---------------------------------------------------------
BUGS
---------------------------------------------------------
    - not really a bug but an implementation improvement: 
        Lua scripts are stored in the DB with encoded HTML chartset. 
        for some reason the code from updateScript in "action.php" decode the receive POST but SQL still store it encoded.    - 
    
---------------------------------------------------------
TODO LIST 
---------------------------------------------------------
    - sanity check of all external url script/reference to be able to run without internet connexion
    - use HTTPS
    - basic auth implementation
    - set debug level
    - initUSB.py to :
            catch exception if device is not existing
            raise SerialException("could not open port %s: %s" % (self._port, msg)) 
            store the device in text file corresponding to Ph Orp and Rtd
    - to read the device in file generated by python initUSB
    - add user/admin setup  
        - editable field in script table with possible value: "user","admin","none"
        - header and footer will have "none"
        - custom will have "user"
        - main will have "admin"
    - implement installation wizard
    - finalize forecast / interpretation of the data (graph.php)
    - implement i18n
    - use PDO or mysqli 
    - script combo populated by select * from scripts ID
    - calibration bug review
    - implement wifi wizard (https://github.com/sabhiram/raspberry-wifi-conf)
    - system hardening:
        - see : http://iqjar.com/jar/raspberry-pi-rebooting-itself-when-it-becomes-unreachable-from-outside-networks/
        - implement watchdog
        - http://juice4halt.com/

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