import os         #import OS module to easily exit the program
import serial     #import serial module to enable serial commands

ser0 = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB0',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate
)

ser1 = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB1',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate
)

ser2 = serial.Serial(      #initiate the serial connection into the 'ser' variable
  port='/dev/ttyUSB2',    #set the port address of the Atlas stamp
  baudrate=9600          #set the baudrate


ser0.write('\r')     #an initial write to clear the serial buffer
ser1.write('\r')
ser2.write('\r')

ser0.read(3)    #need to determine which device is in which port
ser1.read(3)
ser2.read(3)

ser0.write('C,0\r')     #disqble continuous reqd mode
ser1.write('C,0\r')     #disqble continuous reqd mode
ser2.write('C,0\r')     #disqble continuous reqd mode


ser0.close()           #close the serial port
ser1.close()
ser2.close()
os._exit(1)           #exit the program
