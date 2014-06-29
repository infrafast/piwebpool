#!/bin/bash
DIR="/home/webide/repositories/my-pi-projects/cuve"

# Pour le deplacement des fichiers img vers le repertoire du serveur web.
#source='/home/super/programmes/profondeur/*_cuve_*.png'
#destination='/var/www/cuve/img'
JOUR=$(date '+%d-%m-%Y %H-%M-%S')

# Affichage en degre C
ECHELLE="cm"
VOLUME="litres"

#Choix des couleurs
COUL_ECHELLE="#000099" COUL_VOLUME="#FF0000"

#Graphs par heure
rrdtool graph $DIR/h_cuve_4h.png --start -4h --title="Hauteur d'eau sur 4 heures" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:LAST:"Mesure\: %.0lf" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" COMMENT:" \n" COMMENT:"Dernier releve $JOUR"
rrdtool graph $DIR/v_cuve_4h.png --start -4h --title="Volume sur 4 heures" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:LAST:"Mesure\: %.0lf" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" COMMENT:" \n" COMMENT:"Derniere estimation $JOUR"

#Graphs par jour
rrdtool graph $DIR/h_cuve_24h.png --start -1d --title="Hauteur d'eau sur 24 heures" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" 
rrdtool graph $DIR/v_cuve_24h.png --start -1d --title="Volume sur 24 heures" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" 

#Graphs par semaine
rrdtool graph $DIR/h_cuve_1w.png --start -1w --title="Hauteur d'eau sur 1 semaine" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" 
rrdtool graph $DIR/v_cuve_1w.png --start -1w --title="Volume sur 1 semaine" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf"

#Graphs par mois
rrdtool graph $DIR/h_cuve_1m.png --start -1m  --title="Hauteur d'eau sur 1 mois" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf"
rrdtool graph $DIR/v_cuve_1m.png --start -1m  --title="Volume sur 1 mois" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" 

#Graphs pour 6 mois
rrdtool graph $DIR/h_cuve_6m.png --start -25w  --title="Hauteur d'eau sur 6 mois" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" 
rrdtool graph $DIR/v_cuve_6m.png --start -25w  --title="Volume sur 6 mois" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf" 

#Graphs par an
rrdtool graph $DIR/h_cuve_1y.png --start -1y  --title="Hauteur d'eau sur 1 an" --vertical-label="cm" DEF:haut=$DIR/capa_cuve.rrd:haut:AVERAGE LINE1:haut$COUL_ECHELLE:"Hauteur d'eau en $ECHELLE\n" GPRINT:haut:AVERAGE:"Moy\: %.0lf" GPRINT:haut:MIN:"Mini\: %.0lf" GPRINT:haut:MAX:"Maxi\: %.0lf" \
rrdtool graph $DIR/v_cuve_1y.png --start -1y  --title="Volume sur 1 an" --vertical-label="Litres" DEF:capa=$DIR/capa_cuve.rrd:capa:AVERAGE LINE1:capa$COUL_VOLUME:"Volume de la cuve en $VOLUME\n" GPRINT:capa:AVERAGE:"Moy\: %.0lf" GPRINT:capa:MIN:"Mini\: %.0lf" GPRINT:capa:MAX:"Maxi\: %.0lf"

#Transfert des données sur le serveur Web
#chown www-data:www-data $source
#sudo mv $source $destination