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

import logging
import logging.handlers
import argparse
import time  # this is only being used as part of the example
 
import os               # Miscellaneous OS interfaces.
import sys              # System-specific parameters and functions. 
 
# Deafults
LOG_FILENAME = "/tmp/capa.log"
LOG_LEVEL = logging.INFO
 
# Define and parse command line arguments
parser = argparse.ArgumentParser(description="capa service")
parser.add_argument("-l", "--log", help="file to write log to (default '" + LOG_FILENAME + "')")
 
args = parser.parse_args()
if args.log:
    LOG_FILENAME = args.log
 
# Configure logging to log to a file, making a new file at midnight and keeping the last 3 day's data
logger = logging.getLogger(__name__)
logger.setLevel(LOG_LEVEL)
handler = logging.handlers.TimedRotatingFileHandler(LOG_FILENAME, when="midnight", backupCount=3)
formatter = logging.Formatter('%(asctime)s %(levelname)-8s %(message)s')
handler.setFormatter(formatter)
logger.addHandler(handler)

# Use BCM GPIO references
# instead of physical pin numbers
GPIO.setmode(GPIO.BCM)

# Define GPIO to use on Pi
GPIO_TRIGGER = 17
GPIO_ECHO = 23

# Set pins as output and input
GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo

logger.info("CAPA Daemon started")

while True:

    try:

        # Set trigger to False (Low)
        GPIO.output(GPIO_TRIGGER, False)
    
        # Allow module to settle
        #time.sleep(0.5)
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
    
        # Mesure hauteur d'eau = difference entre cuve pleine et capteur 18cm
        fond=131.5
        distance = fond - distance
    
        # Calcul volume
        largeur=100
        longueur=210
    
        vol = largeur * longueur * distance
        volume = vol / 1000
    
        #logfile
        #print  "%.0f" % distance+" "+"%.0f" % volume
        #logger.info("distance " + str(distance))
    
        #base RDTOOL
        database_file = "/home/webide/repositories/my-pi-projects/cuve/capa_cuve.rrd"
        rrdtool.update(database_file, "N:%.2f" % distance+":%.0f" % volume)
    
        # Reset GPIO settings
        #GPIO.cleanup()
    except  Exception, e:
        logger.error('Unexpected error: %s', sys.exc_info()[0])
    