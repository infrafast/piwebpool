#!/usr/bin/python
# -*-coding:Utf-8 -*
# José - Juin 2014

import urllib2
import sys
import rrdtool
import logging
import logging.handlers
import argparse


def dropsms(texte):

    user = '19107501'
    pas = 'oGVsksAr0geO6j'
    url = 'https://smsapi.free-mobile.fr/sendmsg?&user='+user+'&pass='+pas+'&msg='+texte
    sms_feedback = 'SMS sent'
    
    req = urllib2.Request(url)
    try:
      reponse = urllib2.urlopen(req)
    
    except IOError, e:
      if hasattr(e,'code'):
        if e.code == 400:
            sms_feedback = 'SMS missing parameter.'
        if e.code == 402:
            sms_feedback = 'too many SMS request in short time.'
        if e.code == 403:
            sms_feedback = 'SMS service not activated or incorrect credentials.'
        if e.code == 500:
            sms_feedback = 'SMS server unavailable.'

    logger.info(sms_feedback)
    #print (sms_feedback)

    return

niveau_mini = 55
niveau_maxi = 65

LOG_FILENAME = "/tmp/monitor.log"
ALERT = 0
SMS = 0
LOG_LEVEL = logging.INFO

message = "Variation volume:"

# Define and parse command line arguments
parser = argparse.ArgumentParser(description="tank monitoring and alert")
parser.add_argument("-s", "--sms", help="monitor tank volume variation to (default '" + LOG_FILENAME + "')")
 
args = parser.parse_args()
if args.sms:
    SMS = args.sms

logger = logging.getLogger(__name__)
logger.setLevel(LOG_LEVEL)
handler = logging.handlers.TimedRotatingFileHandler(LOG_FILENAME, when="midnight", backupCount=1)
formatter = logging.Formatter('%(asctime)s %(levelname)-8s %(message)s')
handler.setFormatter(formatter)
logger.addHandler(handler)



#base RDTOOL
database_file = "/home/webide/repositories/my-pi-projects/cuve/capa_cuve.rrd"
#startTime = str(now - retention)
#endTime = str(now)

MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-24h', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-24h', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio24h = (round(niveau_maxi / niveau_mini,2)-1)*100


MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-8h', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-8h', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio8h = (round(niveau_maxi / niveau_mini,2)-1)*100

MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-60s', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-60s', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio30s = (round(niveau_maxi / niveau_mini,2)-1)*100


#rajouter une autre condition qui permet de capturer le moment pour eviter de recevoir des sms sans arret -
if ratio8h > 7 and ratio8h < 9 :
    ALERT = 1
    message = message + " [MOTION]"
# le niveau reste haut pendant plus de une minute; la pompe ne s'est pas mise en route...
if MAX_values > niveau_maxi*1.05 :
    ALERT = 1
    message = message + " [PUMP BLOCKED]"


message=message+" current="+str(ratio30s)+"% ./last 8h="+str(ratio8h)+"% last 24h="+str(ratio24h)+"%"
#print (message)
logger.info(str(ratio30s)+" "+str(ratio8h)+" "+str(ratio24h))

if ALERT or SMS:
    dropsms(message)    
    

