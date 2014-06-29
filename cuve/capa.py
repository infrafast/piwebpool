#!/usr/bin/python
#+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
#|R|a|s|p|b|e|r|r|y|P|i|-|S|p|y|.|c|o|.|u|k|
#+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
#
# ultrasonic_1.py
# Measure distance using an ultrasonic module
#
# Author 1ere partie: Matt Hawkins
# Date   : 09/01/2013
# Author 2eme partie: Jose
# Date   : 10/05/2013

# Import required Python libraries
import time
import RPi.GPIO as GPIO
import rrdtool
import datetime

# Use BCM GPIO references
# instead of physical pin numbers
GPIO.setmode(GPIO.BCM)

# Define GPIO to use on Pi
GPIO_TRIGGER = 17
GPIO_ECHO = 23

# Set pins as output and input
GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo

# Set trigger to False (Low)
GPIO.output(GPIO_TRIGGER, False)

# Allow module to settle
time.sleep(0.5)

# Send 10us pulse to trigger
GPIO.output(GPIO_TRIGGER, True)
time.sleep(0.00001)
GPIO.output(GPIO_TRIGGER, False)
start = time.time()
while GPIO.input(GPIO_ECHO)==0:
start = time.time()

while GPIO.input(GPIO_ECHO)==1:
stop = time.time()

# Calculate pulse length
elapsed = stop-start

# Distance pulse travelled in that time is time
# multiplied by the speed of sound (cm/s)
distance = elapsed * 34300

# That was the distance there and back so halve the value
distance = distance / 2

# Mesure de la hauteur d'eau en faisant la diff�rence entre la hauteur cuve pleine et le capteur 18 cm
fond=131.5
distance = fond - distance

# Fonction de calcul du volume th�orique de la cuve
largeur=100
longueur=210

vol = largeur * longueur * distance
volume = vol / 1000

# D�coche les commentaires pour consulter les logs
print  "%.0f" % distance+" "+"%.0f" % volume

#Transfert dans la base rrdtool
#database_file = "/home/super/programmes/profondeur/capa_cuve.rrd"
#rrdtool.update(database_file, "N:%.2f" % distance+":%.0f" % volume)

# Reset GPIO settings
GPIO.cleanup()