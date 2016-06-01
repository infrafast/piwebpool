#!/usr/bin/python
import sys
# appends to PYTHONPATH the location of the example codes
sys.path.append(r'/home/pi/git/quick2wire-python-api/src/')
from time import sleep
from quick2wire.gpio import Pin, exported
with exported(Pin(15, Pin.Out)) as LED :
	LED.value = 1

print "Content-type: text/html"
print
print "<html>"
print "Allumer la lampe"
print "</html>"