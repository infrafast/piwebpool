#!/usr/bin/python
import sys

# appends to PYTHONPATH the location of the example codes
sys.path.append(r'/home/pi/git/quick2wire-python-api/src/')

pin_num = int(sys.argv[1]) if len(sys.argv) > 1 else 16
from quick2wire.gpio import Pin
inPin = Pin(pin_num, Pin.In)

print "Content-type: text/html"
print
print inPin.value