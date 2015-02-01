#!/usr/bin/python
# -*-coding:Utf-8 -*
# José - Juin 2014

import urllib2
import sys
import rrdtool

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

#base RDTOOL
database_file = "/home/webide/repositories/my-pi-projects/cuve/capa_cuve.rrd"
#startTime = str(now - retention)
#endTime = str(now)
MAX_values = rrdtool.fetch(database_file, 'MAX','-s', 'end-30s', '-e', 'now')
niveau_maxi = (max(MAX_values[2])[0])
MIN_values = rrdtool.fetch(database_file, 'MIN','-s', 'end-30s', '-e', 'now')
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



dropsms("Variation volume: actuel="+str(ratio30s)+"% sur 8h="+str(ratio8h)+"% sur 24h="+str(ratio24h)+"%")
