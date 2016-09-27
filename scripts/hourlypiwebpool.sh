#!/bin/sh
# cron script for checking wlan connectivity
# and reboot raspberry in case of loss
PIWEBDIR="/var/www/html/piwebpool"

LOGID="HOURLYPIWEPOOL.SH: "
logger -s "$LOGID starting" 
#IP_FOR_TEST="$(hostname -f).infrafast.com"
IP_FOR_TEST="www.googlelll.com"
PING_COUNT=1
PING="/bin/ping"
IFUP="/sbin/ifup"
IFDOWN="/sbin/ifdown --force"
INTERFACE="wlan0"
FFLAG="$PIWEBDIR/stuck.fflg"
LFLAG="$PIWEBDIR/noreboot.lflg"

# ping test
$PING -c $PING_COUNT $IP_FOR_TEST > /dev/null 2> /dev/null
if [ $? -ge 1 ]
then
    logger -s "$LOGID ping $IP_FOR_TEST failed : $INTERFACE seems to be down..."
    if [ -e $FFLAG ]
    then
        logger -s "$LOGID $INTERFACE still down even after service restart"
        rm -f $FFLAG 2>/dev/null
        if [ ! -e $LFLAG ]
        then    
            logger -s "Rebooting once to recover service"
            touch $LFLAG
            sudo reboot
        else
            logger -s "Keep system UP, no network."
        fi
    else
            logger -s "$LOGID restarting $INTERFACE ..."
            touch $FFLAG
            sudo ifdown $INTERFACE && sudo service networking restart && sudo ifup $INTERFACE
            sudo systemctl daemon-reload
    fi
else
    logger -s "$LOGID $INTERFACE is up and $IP_FOR_TEST is alive"
    rm -f $FFLAG 2>/dev/null
    rm -f $LFLAG 2>/dev/null
fi


#execute periodic piweb actions
logger -s "$LOGID Executing piweb cronaction"
cd $PIWEBDIR
#php -dextension=lua.so cronaction.php
#php cronaction.php
