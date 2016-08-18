#!/bin/sh
# cron script for checking wlan connectivity
# and reboot raspberry in case of loss
LOGID="HOURLYCRONTAB.SH: "
logger "$LOGID starting" 
IP_FOR_TEST="$(hostname -f).infrafast.com"
PING_COUNT=1
PING="/bin/ping"
IFUP="/sbin/ifup"
IFDOWN="/sbin/ifdown --force"
INTERFACE="wlan0"
FFLAG="/var/www/html/piwebpool/stuck.fflg"

# ping test
$PING -c $PING_COUNT $IP_FOR_TEST > /dev/null 2> /dev/null
if [ $? -ge 1 ]
then
    logger "$LOGID ping $IP_FOR_TEST faild : $INTERFACE seems to be down..."
        if [ -e $FFLAG ]
        then
                logger "$LOGID $INTERFACE is still down, REBOOT to recover ..."
                rm -f $FFLAG 2>/dev/null
                sudo reboot
        else
                logger "$LOGID restarting $INTERFACE ..."
                touch $FFLAG
                sudo ifdown $INTERFACE && sudo service networking restart && sudo ifup $INTERFACE
                sudo systemctl daemon-reload
        fi
else
    logger "$LOGID $INTERFACE is up and $IP_FOR_TEST is alive"
    rm -f $FFLAG 2>/dev/null
fi


#execute periodic piweb actions
logger "$LOGID Executing piweb cronaction"
cd /var/www/html/piwebpool
#php -dextension=lua.so cronaction.php
php cronaction.php
