#!/bin/sh
awk '
/EOF/ {exit;}
 {print;}' < /dev/ttyUSB1 > usb1
