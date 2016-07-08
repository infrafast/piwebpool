#!/bin/sh
awk `
/EOF/ {exit;}
 {print;}` < /dev/ttyUSB2 > usb2    



while read line; do
    if [ "$line" != "toto" ]; then
        echo "$line" > usb2
    else
        break
    fi
done < /dev/ttyUSB2