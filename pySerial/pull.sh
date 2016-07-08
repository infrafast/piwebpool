#!/bin/sh
awk '
/\neu/ {exit;}
 {print;}' < /dev/ttyUSB2     
