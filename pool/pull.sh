#!/bin/sh
while :
do
    awk '
    /EOF/ {exit;}
        {print;}' < /dev/ttyUSB2 > /var/www/html/pool/usb2
    sleep 1
done