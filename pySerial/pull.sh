#!/bin/sh
while read line; do
    if [ "$line" != "\r" ]; then
        echo "$line" > usb2
    else
        break
    fi
done < /dev/ttyUSB2