#!/bin/sh

#execute periodic piweb actions
cd /var/www/html/pool
php -dextension=lua.so cronaction.php

# cron script for checking wlan connectivity
# change 192.168.1.1 to whatever IP you want to check.
IP_FOR_TEST="www.google.com"
PING_COUNT=1

PING="/bin/ping"
IFUP="/sbin/ifup"
IFDOWN="/sbin/ifdown --force"

INTERFACE="eth0"

FFLAG="/var/www/html/pool/stuck.fflg"

# ping test
$PING -c $PING_COUNT $IP_FOR_TEST > /dev/null 2> /dev/null
if [ $? -ge 1 ]
then
    logger "$INTERFACE seems to be down, trying to bring it up..."
        if [ -e $FFLAG ]
        then
                logger "$INTERFACE is still down, REBOOT to recover ..."
                rm -f $FFLAG 2>/dev/null
                sudo reboot
        else
                touch $FFLAG
                logger $(sudo $IFDOWN $INTERFACE)
                sleep 10
                logger $(sudo $IFUP $INTERFACE)
        fi
else
#    logger "$INTERFACE is up"
    rm -f $FFLAG 2>/dev/null
fi
