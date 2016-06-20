#!/usr/bin/python  
import serial
print "Welcome to the Atlas Scientific Raspberry Pi example."
usbport = '/dev/ttyAMA0'
ser = serial.Serial(usbport, 9600)
# turn on the LEDs
ser.write("L,1\r")
ser.write("C,1\r")
line = ""
while True:
     data = ser.read()
     if(data == "\r"):
           print "Received from sensor:" + line
           line = ""
     else:
           line = line + data