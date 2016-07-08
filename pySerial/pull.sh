#!/bin/sh
awk '
/^M/ {exit;}
 {print;}' < /dev/ttyUSB2 > usb2
