#!/bin/bash
DIR="/home/webide/repositories/my-pi-projects/cuve"

JOUR=$(date '+%d-%m-%Y %H-%M-%S')

# Affichage en degre C
ECHELLE="cm"
VOLUME="litres"

#Choix des couleurs
COUL_ECHELLE="#000099" COUL_VOLUME="#FF0000"

#Graphs par heure
rrdtool graph $DIR/h_cuve_1h.png --start -1h --title="Hauteur d'eau sur 1 heure" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:LAST:"Mesure\: %.0lf" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" COMMENT:" \n" COMMENT:"Dernier releve $JOUR"

#Graphs par 4 heure
rrdtool graph $DIR/h_cuve_4h.png --start -4h --title="Hauteur d'eau sur 4 heures" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:LAST:"Mesure\: %.0lf" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" COMMENT:" \n" COMMENT:"Dernier releve $JOUR"
#rrdtool graph $DIR/v_cuve_4h.png --start -4h --title="Volume sur 4 heures" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:LAST:"Mesure\: %.0lf" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" COMMENT:" \n" COMMENT:"Derniere estimation $JOUR"
