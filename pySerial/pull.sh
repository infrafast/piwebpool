#!/bin/sh
awk '
/EOF/ {exit;}
 {print;}' < /dev/ttyUSB2 > usb2
