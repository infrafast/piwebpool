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
    
    req = urllib2.Request(url)
    try:
      reponse = urllib2.urlopen(req)
    
    except IOError, e:
      if hasattr(e,'code'):
        if e.code == 400:
            print 'Un des paramètres obligatoires est manquant.'
        if e.code == 402:
            print 'Trop de SMS ont été envoyés en trop peu de temps.'
        if e.code == 403:
            print 'Le service n’est pas activé sur l’espace abonné, ou login / clé incorrect.'
        if e.code == 500:
            print 'Erreur côté serveur. Veuillez réessayez ultérieurement.'
    
    print 'Le SMS a été envoyé sur votre mobile.'

    return

niveau_mini = 56
niveau_maxi = 64

LOG_FILENAME = "/tmp/monitor.log"
ALERT = 0
AUTO = 0
LOG_LEVEL = logging.INFO

# Define and parse command line arguments
parser = argparse.ArgumentParser(description="tank monitoring and alert")
parser.add_argument("-a", "--auto", help="monitor tank volume variation to (default '" + LOG_FILENAME + "')")
 
args = parser.parse_args()
if args.auto:
    AUTO = args.auto

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
MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-60s', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-60s', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio30s = (round(niveau_maxi / niveau_mini,2)-1)*100

MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-8h', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-8h', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio8h = (round(niveau_maxi / niveau_mini,2)-1)*100

MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-24h', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-24h', '-e', 'now')
niveau_mini = (min(MIN_values)[0])[0]
ratio24h = (round(niveau_maxi / niveau_mini,2)-1)*100


message="Variation volume: actuel="+str(ratio30s)+"% sur 8h="+str(ratio8h)+"% sur 24h="+str(ratio24h)+"%"+" alert:"+str(ALERT)
print (message)
if ratio30s > 10:
    ALERT = 1
    
    
    dropsms(message)

