Welcome to Piweb Pool Manager

The first full open source Raspberry PI PHP web-based application that automates the control of swiming pool with following features:
- water quality measurement (PH, ORP, Temperature)
- controls up to 4 power outlet (treatment, 
- scheduler that control filtration aoccrding to water temperature
- can be controlled over your iPhone or any mobile device
- provide graphical scripting capabilities (with Lua and Blockly)


Interfaces with :
- Domoticz and any other home automation system thru a simple HTTP API


Dependencies:
    
 

---------------------------------------------------------
PLATFORM SETUP FROM SCRACTH
---------------------------------------------------------

1) Make sure your raspberry config is ok
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

2) setup wifi (optionnal)
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