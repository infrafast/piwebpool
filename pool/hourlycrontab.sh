#!/bin/sh


# cron script for checking wlan connectivity
# and reboot raspberry in case of loss
IP_FOR_TEST="$(hostname -f).infrafast.com"
#IP_FOR_TEST="www.google.com"
PING_COUNT=1

PING="/bin/ping"
IFUP="/sbin/ifup"
IFDOWN="/sbin/ifdown --force"

INTERFACE="wlan0"

FFLAG="/var/www/html/pool/stuck.fflg"
# ping test
$PING -c $PING_COUNT $IP_FOR_TEST > /dev/null 2> /dev/null
if [ $? -ge 1 ]
then
    logger "ping $IP_FOR_TEST faild : $INTERFACE seems to be down, trying to bring it up..."
        if [ -e $FFLAG ]
        then
                logger "$INTERFACE is still down, REBOOT to recover ..."
                rm -f $FFLAG 2>/dev/null
                sudo reboot
        else
                touch $FFLAG
                sudo ifdown $INTERFACE && sudo service networking restart && sudo ifup $INTERFACE
                sudo systemctl daemon-reload
                logger "$INTERFACE restarted ..."
        fi
else
#    logger "$INTERFACE is up"
    logger "$IP_FOR_TEST is alive ..."
    rm -f $FFLAG 2>/dev/null
fi


#execute periodic piweb actions
logger "Executing piweb cronaction"
cd /var/www/html/pool
#php -dextension=lua.so cronaction.php
logger "piweb cronaction finished"
