#!/usr/bin/python
import sys

# appends to PYTHONPATH the location of the example codes
sys.path.append(r'/home/pi/git/quick2wire-python-api/src/')
from time import sleep

pin_num = int(sys.argv[1]) if len(sys.argv) > 1 else 15
val_num = int(sys.argv[2]) if len(sys.argv) > 2 else 0

from quick2wire.gpio import Pin, exported
with exported(Pin(pin_num, Pin.Out)) as LED :
	LED.value = val_num

print "Content-type: text/html"
print
print pin_num