#!/bin/sh
awk '
/EOF/ {exit;}
 {print;}' < /dev/ttyUSB2 > /var/www/html/pool/usb2
