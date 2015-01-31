#!/bin/bash
DIR="/home/webide/repositories/my-pi-projects/cuve"

JOUR=$(date '+%d-%m-%Y %H-%M-%S')

# Affichage en degre C
ECHELLE="cm"
VOLUME="litres"

#Choix des couleurs
COUL_ECHELLE="#000099" COUL_VOLUME="#FF0000"

#Graphs par jour
rrdtool graph $DIR/h_cuve_24h.png --start -1d --title="Hauteur d'eau sur 24 heures" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf"

#Graphs par semaine
rrdtool graph $DIR/h_cuve_1w.png --start -1w --title="Hauteur d'eau sur 1 semaine" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" 