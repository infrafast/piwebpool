#!/usr/bin/python
# -*-coding:Utf-8 -*
# José - Juin 2014

import urllib2
import sys

user = '19107501'
texte = 'hello world'
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