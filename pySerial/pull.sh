#!/bin/sh
awk '
/\n/ {exit;}
 {print;}' < /dev/ttyUSB2 > usb2
