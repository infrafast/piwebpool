import os         #import OS module to easily exit the program
import serial     #import serial module to enable serial commands
import threading  #import threading module to create a separate thread for reading the serial port

ser = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB2',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate
)

def read_from_port(ser):    #create definition for your serial read thread
  line=""                #initiate read variable we'll call 'line'
  while True:               #start the While loop
    data = ser.read()       #read the serial port and store in the 'data' variable
    if(data == "\r"):       #if there is a carriage return
      print line    #print the output
      line = ""             #set the variable back to nothing
    else:
      line = line + data    #append the data onto the line variable

ser.write('\r')     #an initial write to clear the serial buffer
#flush = ser.read(3) #flush into variable (only needed for EZO circuits)

thread = threading.Thread(target=read_from_port, args=(ser,)) #create the thread to read the serial port, include the target definition and the serial protocol
thread.start()  #start the thread

while True:
