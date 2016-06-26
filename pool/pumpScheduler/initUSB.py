import os         #import OS module to easily exit the program
import serial     #import serial module to enable serial commands
import threading  #import threading module to create a separate thread for reading the serial port

ser0 = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB0',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate
)

ser1 = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB1',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate
)

#ser2 = serial.Serial(      #initiate the serial connection into the 'ser' variable
#  port='/dev/ttyUSB0',    #set the port address of the Atlas stamp
#  baudrate=9600          #set the baudrate
#)

def read_from_port(ser):    #create definition for your serial read thread
  while True:               #start the While loop
    data = ser.read()       #read the serial port and store in the 'data' variable
    if(data == "\r"):       #if there is a carriage return
      line = ""             #set the variable back to nothing
    else:
      line = line + data    #append the data onto the line variable

ser.write('\r')     #an initial write to clear the serial buffer
ser1.write('\r')

ser.close()           #close the serial port
ser1.close()
os._exit(1)           #exit the program
