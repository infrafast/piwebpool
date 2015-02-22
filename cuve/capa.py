#!/usr/bin/python
#coding: utf8
#+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
# thomas
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
import math
import logging
import logging.handlers
import argparse
import time  # this is only being used as part of the example

LOG_FILENAME = "/tmp/capa.log"
LOG_LEVEL = logging.INFO
 
# Define and parse command line arguments
parser = argparse.ArgumentParser(description="capa service")
parser.add_argument("-l", "--log", help="file to write log to (default '" + LOG_FILENAME + "')")
 
args = parser.parse_args()
if args.log:
    LOG_FILENAME = args.log
 
# Configure logging to log to a file, making a new file at midnight and keeping the last 1 day's data
logger = logging.getLogger(__name__)
logger.setLevel(LOG_LEVEL)
handler = logging.handlers.TimedRotatingFileHandler(LOG_FILENAME, when="midnight", backupCount=1)
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

def median(mylist):
#---------------------------------------------------------------------------------------------
# calcule la médiane d'une liste
#--------------------------------------------------------------------------------------------- 
    sorts = sorted(mylist)
    length = len(sorts)
    if not length % 2:
        return (sorts[length / 2] + sorts[length / 2 - 1]) / 2.0
    return sorts[length / 2]


def LectureDistanceMoyenne(GPIO_TRIGGER,GPIO_ECHO,nbMesures):
#---------------------------------------------------------------------------------------------
# Mesure de distance à partir du capteur HC-sr04
# nbMesure : un nb entier qui correspond au nb de mesure à faire pour déterminer une seul valeure
# plus ce nb est élevé, plus la précision augmente mais plus le temps de mesure est lon
# principe : on fait nbMesure. On met chaque résultat dans une liste
# on retire la valeur la plus petite (j'ai constaté que de temps à autre, on a une valeur nettement trop faibl
# puis, on prend la valeur la plus petite. L'idée étant que lorsque la CPU travaille trop
# on sort un peu tard de la boucle while
#------------------------------------------------------------------------------------------------ 
    liste=[]
    # je fais autant de mesures que demandée et je les place dans liste
    for i in range(nbMesures):
        liste.append(LectureDistance(GPIO_TRIGGER,GPIO_ECHO))

    distance =median(liste)
    return distance
    
def LectureDistance(GPIO_TRIGGER,GPIO_ECHO):
#------------------------------------------------------
# Mesure de distance à partir du capteur HC-sr04
#------------------------------------------------------    
    # Use BCM GPIO references
    # instead of physical pin numbers
    GPIO.setmode(GPIO.BCM)
    # Set pins as output and input
    GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
    GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo

    # Set trigger to False (Low)
    GPIO.output(GPIO_TRIGGER, False)

    # La doc indique de mettre au moins 60ms entre deux "pulse to triger"
    time.sleep(0.06)

    # Send 10us pulse to trigger. cela déclenche une demande de mesure
    GPIO.output(GPIO_TRIGGER, True)
    time.sleep(0.00001)
    GPIO.output(GPIO_TRIGGER, False)
    start = time.time()

    while (GPIO.input(GPIO_ECHO)==0 and time.time()-start<0.01):
        # Facultatif 0.00005 seconde correspond à une distance de 0.85 cm donc négligabl
        # mais permet ainsi au CPU d'etre un peu libéré. Un peu seulement.
        time.sleep(0.00005)
        continue
    start = time.time()
    #on récupère ainsi l'heure d'envoie du signal par le capte
    while (GPIO.input(GPIO_ECHO)==1 and time.time()-start<0.01):
        time.sleep(0.00005)
        continue
    stop = time.time()

    # Calculate pulse length
    elapsed = stop-start

    # Distance pulse travelled in that time is time
    # multiplied by the speed of sound (cm/s)
    distance = elapsed * 34000

    # That was the distance there and back so halve the value
    distance = distance / 2

    #GPIO.cleanup()
    return distance


# Calcul volume
LARGEUR=50
LONGUEUR=50
FOND = 100

#nombre d'echantillon par minute
FREQ = 60          
#nombre d'acquisition pourfaire la moyenne
SAMPLES = 3
NDERIVE = 10
PEAK = 5

index = 0
liste_acquisition=[0]*NDERIVE
derivee=[0]*NDERIVE
delay = FREQ


while True:
    
    distance=LectureDistanceMoyenne(GPIO_TRIGGER,GPIO_ECHO,SAMPLES)
    # Mesure hauteur d'eau = difference entre cuve pleine et capteur 18cm
    distance = FOND - distance
    
    vol = LARGEUR * LONGUEUR * distance
    volume = vol / 1000


    liste_acquisition[index]=distance
    diff=abs(liste_acquisition[index]-median(liste_acquisition))
    if diff > PEAK:
        diff = PEAK
    
    derivee[index]=diff
    index = index +1
    if index == NDERIVE:
        index = 0


    delay = math.floor(FREQ/2 + median(derivee)*0.3*FREQ)

    lissage = median(liste_acquisition)
    logger.info(str(distance)+" "+str(lissage)+" "+str(delay))

    #base RDTOOL
    #database_file = "/home/webide/repositories/my-pi-projects/cuve/capa_cuve.rrd"
    #rrdtool.update(database_file, "N:%.2f" % lissage+":%.2f" % volume)
    time.sleep(60/delay)
