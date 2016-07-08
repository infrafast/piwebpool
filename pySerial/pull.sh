#!/bin/sh
awk '
/\r/ {exit;}
 {print;}' < /dev/ttyUSB2 > usb2
