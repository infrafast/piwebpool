#!/bin/sh
awk '
/CR/ {exit;}
 {print;}' < /dev/ttyUSB2 > usb2
