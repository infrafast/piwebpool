#!/bin/bash
# Auteur : infrafast info@infrafast.com
# Licence : GPL

#############
# Variables
#############

REPONAME="piwebpool"
WEBIDE="/usr/share/adafruit/webide/repositories/$REPONAME"
PIWEBPOOLDIR="/var/www/html/$REPONAME"
INSTALLVERSION="0.1"
ERR="\033[1;31m"
NORMAL="\033[0;39m"
INFO="\033[1;34m"
WARN="\033[1;33m"
OK="\033[1;32m"
IPADDRESS=$(hostname -I)
HOSTNAME=$(cat /etc/hostname)
CRONSCRIPT="hourlypiwebpool.sh"

doInstall=0
#Installer le serveur web (se met à 0 si un autre serveur web est installé)
doapacheSetupError=1
isRoot=0
GlobalError=0
confirmErase=0
copyPiwebpool=1
resizeSD=1


################
# Messages GUI
################
# J'ai séparé les messages long du GUI du reste du programme
# Afin quel soit facilement modifiable

installMessage="\
Etapes:
---------------------------
* Renommer le Raspberry Pi
* Redimensionner la carte SD
* Mise à jour
* Terminal en français
------------------------------------
* Configuration du fuseau horaire
* Installation wiringPi (pour gérer les GPIO)
-------------------------------------------
* Copie de Piwebpool Server
* Installation du serveur web
* Création de l'utilisateur
* Permissions du serveur web
* Installation des utilitaires / cron
"

checkMessage="\
Nous allons revérifier toute l'installation et établir les pré-requis
"

renameMessage="\
Vous pouvez accéder à Piwebpool en utilisant un nom plutôt qu'une adresse IP \n\n\
\n\
\n\
Example : maison sera accessible sur http://maison.local/

"

saveMessage="\
Vous pouvez sauvegarder piwebpool sur une clé USB \n\n\
Ceci sauvegardera $PIWEBPOOLDIR dans le dossier Piwebpool \n\n\
Si une sauvegarde existe sur la clé, elle sera effacée \n\
si vous voulez conserver une sauvegarde précédente renommer le dossier \n\
"

restoreMessage="\
Vous pouvez revenir à un état précédent de Piwebpool depuis une clé USB \n\n\
Ceci effacera $PIWEBPOOLDIR et le replacera par celui \n\
dans le dossier sur la clé USB /Piwebpool
"

resizeSDCardMessage="\
Voulez vous redimensionner la carte SD de votre Raspberry Pi ?

Ceci sera fait au prochain redémarrage.
"

# Message d'erreurs

noInternetMessage="\
Je n'arrive pas à me connecter à github.com \n\
Voici votre adresse IP: $IPADDRESS\
"

ApacheMessage="\
Piwebpool utilise Apache comme serveur web par défaut\n\
Il semblerait que Apache (un autre serveur web) soit déjà installé...\n\n\

Voulez vous quand même installer Apache ? \n\
"
nginxMessage="\
Piwebpool utilise Apache comme serveur web par défaut\n\
Il semblerait que nginx (un autre serveur web) soit déjà installé...\n\n\

Voulez vous quand même installer Apache ? \n\
"

PiwebpoolMessage="\
Piwebpool semble avoir déjà été copié.\n\
Voulez vous que je le supprimer et que je le réinstalle ?\
"

localeMessage="\
Je n'ai pas réussi à mettre le terminal en français\n\
Pour autant, ceci n'aura aucune incidence sur la suite de l'installation\n\n\
Voici le message d'erreur:\
"

aptGetErrorMessage="\
Le gestionnaire de paquet apt-get est HS\n\
* Soit celui-ci a été interrompu\n\
* Soit il est en cours d'utilisation par un autre programme\n\
Supprimer le fichier de verrou est probablement la solution\n\n\
Voici le message d'erreur:\n\
"

gitErrorMessage="\
Impossible de récupérer le code source avec git\n\
Cela peut être du à un problème du coté de github\n\
Vous pouvez vérifier cela sur https://status.github.com/\n\n\
Voici le message d'erreur:\n\
"

wiringPiErrorMessage="\
Impossible de compiler wiringPi\n\
Voici le message d'erreur:\n\
"

ApacheErrorMessage="\
Le serveur web n'a pas réussi à se redémarrer correctement\n\
Voici le message d'erreur:\n\
"

#Un joli logo ascii sans avoir à installer un programme pour ça
PiwebpoolLogo(){
clear
echo -ne $INFO

cat<<EOF                                                                           
PIWEBPOOL

EOF

echo -ne $ERR
cat<<EOF 
██╗███╗   ██╗███████╗████████╗ █████╗ ██╗     ██╗     
██║████╗  ██║██╔════╝╚══██╔══╝██╔══██╗██║     ██║     
██║██╔██╗ ██║███████╗   ██║   ███████║██║     ██║     
██║██║╚██╗██║╚════██║   ██║   ██╔══██║██║     ██║     
██║██║ ╚████║███████║   ██║   ██║  ██║███████╗███████╗
╚═╝╚═╝  ╚═══╝╚══════╝   ╚═╝   ╚═╝  ╚═╝╚══════╝╚══════╝                                                   
EOF

echo -ne $NORMAL

}

##############
# Menus
##############

# Menu principal
mainMenu(){
	optionsMain=$(whiptail --title "Piwebpool Server $INSTALLVERSION" --menu "" --cancel-button "Annuler" 0 0 0 \
		"Configurer" "" \
		"Installer" "" \
		"Sauvegarder" "" \
		"Restaurer" "" \
		"Quitter" "" 3>&1 1>&2 2>&3)

	case $optionsMain in
		"Installer")
			installMenu;;
		"Configurer")
			setupMenu;;
		"Sauvegarder")
			saveMenu;;
		"Restaurer")
			restoreMenu;;
		*)
			echo -e "$OK ... A la prochaine! $NORMAL"
			;;
	esac
}

# Menu d'installation
installMenu(){
	if(whiptail --title "Installation" --yesno "$installMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		doInstall=1
	else
		echo -e "\033[1;34m... A la prochaine!\033[0;39m"
	fi
}

# Menu de configuration
setupMenu(){
	optionsSetup=$(whiptail --title "Piwebpool Server $INSTALLVERSION" --menu "" --cancel-button "Retour" 0 0 0 \
		"Installer pré-requis" "" \
		"Mettre à jour Piwebpool" "" \
		"Redimensionner la carte SD" "" \
		"Renommer le Raspberry Pi" ""  \
		"Scripts" "" \
		"Quitter" "" \
		 3>&1 1>&2 2>&3)

	case $optionsSetup in
		"Installer pré-requis")
			preRequisiteMenu;;
		"Mettre à jour Piwebpool")
			forcePiwebpoolUpdate;;
		"Redimensionner la carte SD")
			resizeSDCard
			setupMenu;;
		"Renommer le Raspberry Pi")
			renameMenu
			setupMenu;;
		"Scripts")
			scriptsMenu;;
		"Quitter")
			echo -e "$OK ... A la prochaine! $NORMAL";;
		*)
			mainMenu;;
	esac
}

# Menu vérification de Piwebpool
preRequisiteMenu(){
	if(whiptail --title "Vérification" --yesno "$checkMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		updateRaspberryPi
		setPermissions
		installDependenciesMenu
		installPiwebpoolMisc
		addCron
	else
		setupMenu
	fi
}

resizeSDCardMenu(){
	if(whiptail --title "Carte SD" --yesno "$resizeSDCardMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		resizeSDCard
	fi
}

# Menu de renommage du Raspberry Pi
renameMenu(){
	newhostname=$(whiptail --inputbox "$renameMessage" --title "Choissisez un nom" 0 0 3>&1 1>&2 2>&3)
	renamePi
}

# Menu de scripts pour les scripts
# Il faut créer un script au format .sh pour dans $PIWEBPOOLDIR/scripts/nom-du-plugin/nom-du-script.sh
# On peut utiliser les fonctions du script d'installation et les variables à l'intérieur d'un script
# Par example vous pouvez récupérer le nom $HOSTNAME ou l'adresse IP $IPADDRESS
# Vérifier si internet est connecté 
scriptsMenu(){
getAllScripts

while read -r nextScript
do 
	scriptName=$(echo "${nextScript//\/var\/www\/piwebpool\/scripts\//}")
	menu_options[ $i ]="$scriptName"
	(( i++ ))
	
	menu_options[ $i ]=""
	(( i++ ))
done <<<"$allScripts"

scriptToExecute=$(whiptail --title "scripts" --menu "Gérer un Plugin" 0 0 0 "${menu_options[@]}" 3>&1 1>&2 2>&3 )
executeScript
}

executeScript(){
if [[ -f $PIWEBPOOLDIR/scripts/$scriptToExecute ]];then
	chmod +x $PIWEBPOOLDIR/scripts/$scriptToExecute
	clear
	PiwebpoolLogo
	echo -e "$OK -----> Exécution de $scriptToExecute $NORMAL"
	dir=$(dirname $PIWEBPOOLDIR/scripts/$scriptToExecute)
	cd $dir;. $PIWEBPOOLDIR/scripts/$scriptToExecute
else
	echo -e "$OK -----> Aucun script trouvé dans $PIWEBPOOLDIR/scripts/$scriptToExecute $NORMAL"
fi

}

# Menu de vérification des fichiers binaires
installDependenciesMenu(){
	allPackages="ssmtp\n mysql-server\n lua5.1\n liblua5.1\n python-serial\n"
	if(whiptail --title "Dependances binaires" --yesno "Je peux automatiquement installer les dependances\n\nVoici la liste: \n$allPackages" --yes-button "Oui" --no-button "Non" 0 0) then
    	debconf-apt-progress -- apt-get install -q -y $allPackages
    	if [[ $globalError -ne 0 ]];then
    		aptgetErrorMenu
    	fi
		whiptail --title "Packages" --msgbox "Packages installés" 0 0
	fi
}

saveMenu(){
	if(whiptail --title "Sauvegarde USB" --yesno "$saveMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		saveUSB
	else
		mainMenu
	fi
}

restoreMenu(){
	if(whiptail --title "Restauration USB" --yesno "$restoreMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		restoreUSB
		setPermissions
	else
		mainMenu
	fi
}


## Menu d'erreurs


# Menu Internet HS
noInternetMenu(){
	whiptail --title "Vérifier que vous êtes connecté à internet" --msgbox "$noInternetMessage" 0 0
	echo -e "$ERR - Impossible de continuer sans internet $NORMAL"
}

# Menu Apache déjà installé
ApacheAlreadyInstalledMenu(){
	if(whiptail --title "Un serveur web est déjà installé" --yesno "$ApacheMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		doapacheSetupError=1
	else
		doapacheSetupError=0
	fi
}

# Menu Nginx déjà installé
nginxAlreadyInstalledMenu(){
	if(whiptail --title "Un serveur web est déjà installé" --yesno "$nginxMessage" --yes-button "Oui" --no-button "Non" 0 0) then
		doapacheSetupError=1
	else
		doapacheSetupError=0
	fi
}

# Menu error APT-GET
aptgetErrorMenu(){
	#Récupère le message d'erreur apt-get
	getAptError

	#Affiche l'erreur dans la GUI
	whiptail --title "le gestionnaire de paquet ne réponds pas" --msgbox "$aptGetErrorMessage $aptError" 0 0
	echo -e "$ERR Impossible de continuer sans apt-get $NORMAL"
	echo -e "$WARN ERREUR - $aptGetErrorMessage $aptError"
	exit 1
}

# Menu erreur git
gitErrorMenu(){
	#Récupère le message d'erreur de git clone
	getGitError

	#Affiche l'erreur dans la GUI
	whiptail --title "le gestionnaire de paquet ne réponds pas" --msgbox "$gitErrorMessage $gitError" 0 0
	exit 1
}

# Menu erreur wiringPi
wiringPiErrorMenu(){
	getWiringPiError

	whiptail --title "Echec de la compilation de WiringPi" --msgbox "$wiringPiErrorMessage $wiringPiError" 0 0
}

# Menu erreur Apache
ApacheErrorMenu(){
	whiptail --title "Echec du lancement de Apache" --msgbox "$ApacheErrorMessage $ApacheError" 0 0
}

confirmEraseUSB(){
	if(whiptail --title "Confirmer la suppression de la sauvegarde" --yesno "Une sauvegarde précédente existe la supprimer ?" --yes-button "Oui" --no-button "Non" 0 0) then
		confirmErase=1
	else
		confirmErase=0
	fi
}



##############
# Scripts
##############
# Toutes les parties de l'installation sont séparés en fonctions
# Ceci afin de faciliter les tests de chaque partie

#Vérifie que vous êtes bien en root
verifyRoot() {
	if [ $(id -u) -ne 0 ]; then
		echo -e "\033[1;31mVous avez oublié de vous mettre en root!\033[0;39m"
		echo -e "Tapez \033[1;34msudo $0\033[0;39m"
		isRoot=0
	else
		isRoot=1
	fi
}

#Vérifie l'état de la connexion internet
checkInternet(){
	ping -c1 www.github.com > /dev/null 2>&1 && internet=1 || internet=0
	echo -e "$OK -----> Vérification de la connexion à internet $NORMAL"
	if [[ $internet -eq 0 ]]
		then
			noInternetMenu
	fi
}

#Récupère le message d'erreur APT-GET
getAptError(){
	rm -f /tmp/aptError.log

	#On lance apt-get update en dry-run et on sauve le log dans /tmp/aptError.log
	apt-get update -s -q -y > /tmp/aptError.log 2>&1
	aptError=$(cat /tmp/aptError.log)
}

#Récupère le message d'erreur de git
getGitError(){
	gitError=$(cat /tmp/gitError.log)
}

#Récupère le message d'erreur de WiringPi
getWiringPiError(){
	wiringPiError=$(cat /tmp/wiringPiError.log)
}

#Récupère le message d'erreur de Apache
getApacheError(){
	ApacheError=$(cat /tmp/ApacheReload.log)
}

#Met à jour le Raspberry Pi en utilisant whiptail comme interface
updateRaspberryPi(){
	echo -e "$OK -----> Mise à jour du Raspberry Pi $NORMAL"

	#debconf-apt-progress permet d'afficher la progression de la mis à jour dans une GUI en français
	#debconf-apt-progress -- apt-get -q -y update
	globalError=$?
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi
	#debconf-apt-progress -- apt-get -q -y upgrade
	globalError=$?
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi

	#On installe aussi le client git
	debconf-apt-progress -- apt-get install -q -y git-core
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi
}

#Change les locales de l'anglais au français de manière non interactive
setLocaleToFrench(){
	echo -e "$OK -----> Configuration du terminal en français... Patientez s'il vous plaît ... $NORMAL"

	#Ajout des locales FR
	sed -i -e 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen

	#Met FR en locale par défaut
	echo 'LANG="fr_FR.UTF-8 UTF-8"'>/etc/default/locale
	update-locale LANG=fr_FR.UTF-8
	export LANG=fr_FR.UTF-8

	#Les locales sont installés silencieusement
	dpkg-reconfigure --frontend=noninteractive locales > /tmp/localeSetup.log 2>&1
	globalError=$?
	#En cas d'erreur on affiche le message
	if [[ $globalError -ne 0 ]];then
		localeError=$(cat /tmp/localeSetup.log)
		whiptail --title "Locales FR" --msgbox "$localeMessage $localeError" 0 0
	fi
}

#Gestion automatique des fuseaux horaires à l'aide de tzupdate
configureTimeZone(){
	echo -ne "$OK -----> Configuration du fuseau horaire $NORMAL"

	#Vérifie que Python PIP est disponible
	debconf-apt-progress -- apt-get install -q -y python-pip
	globalError=$?
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi

	#Installation silencieuse du Package python tzupdate
	pip install --quiet tzupdate

	#Si l'installation c'est correctement passé lancé tzupdate silencieusement
	if [ -f /usr/local/bin/tzupdate ];then
		tzupdate > /dev/null 2>&1

		#On récupère après la zone géographique pour l'afficher
		currentTimeZone=$(tzupdate -p|awk '{print $4}')
		echo -e "$WARN : $currentTimeZone $NORMAL"
	else
		echo -e "$ERR Impossible de changer le fuseau horaire automatiquement (ce n'est pas nécessaire) $NORMAL"
	fi
}

#Vérification sommaire de l'existance d'autres serveur web
#Si un autre serveur web est installé prévient l'utilisateur
#Afin qu'il choissisent s'il veut installer Apache ou pas
checkWebServer(){
	if [ -f "/usr/sbin/apache2" ];then
		ApacheAlreadyInstalledMenu
	fi

	if [ -f "/usr/sbin/nginx" ];then
		nginxAlreadyInstalledMenu
	fi
}

#Installation du serveur web et de SQLite
apacheSetupError(){
	echo -e "$OK -----> Installation du serveur web $NORMAL"
	debconf-apt-progress -- apt-get install -q -y apache2 php5 php5-mysql php5-gd php5-dev php5-curl php-pear
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi
}

#Configure Apache pour bloquer l'accès à la base de données
setupWebServer(){
echo -e "$OK -----> Configuration du serveur web (/etc/Apache/Apache.conf) $NORMAL"

#cat <<\EOF > /etc/Apache/Apache.conf
#server.modules = (
#        "mod_access",
#        "mod_alias",
#        "mod_compress",
#        "mod_redirect",
#       "mod_rewrite",
#)
#EOF
sudo sed -i 's_DocumentRoot /var/www/html_DocumentRoot $piwebpooldir/$reponame_' /etc/apache2/sites-available/000-default.conf

apacheSetupError=$?

if [[ apacheSetupError -eq 1 ]];then
	echo -e "$ERR - Le fichier /etc/apache2/sites-available/000-default.conf n'a pas été modifié $NORMAL"
fi

#Activation de PHP et rechargement du serveur
	service apache2 restart > /tmp/ApacheReload.log 2>&1
	globalError=$?
	if [[ $globalError -ne 0 ]];then
		getApacheError
		ApacheErrorMenu
		echo -e "$ERR - La configuration de /etc/Apache/Apache.conf a échoué $NORMAL"
		echo -e "$WARN ERREUR: $ApacheError $NORMAL"
	fi

}


#Clonage de Piwebpool
#Si Piwebpool a déjà été cloné alors on propose à l'utilisateur de le réinstaller
clonePiwebpool(){
	if [[ copyPiwebpool -eq 1 ]];then
		if [[ -d "$PIWEBPOOLDIR" ]];then
				if(whiptail --title "Piwebpool déjà installé" --yesno "$PiwebpoolMessage" --yes-button "Oui" --no-button "Non" 0 0) then
					echo -e "$ERR -----> Réinstallation de Piwebpool Server $NORMAL"
					rm -rf $PIWEBPOOLDIR
					git clone https://github.com/infrafast/piwebpool.git $PIWEBPOOLDIR > /tmp/gitError.log 2>&1
					globalError=$?
					if [[ $globalError -ne 0 ]];then
						gitErrorMenu
					fi
				fi
		else
			echo -e "$OK -----> Copie de Piwebpool Server $NORMAL"
			git clone https://github.com/infrafast/piwebpool.git $PIWEBPOOLDIR > /tmp/gitError.log 2>&1
			globalError=$?
			if [[ $globalError -ne 0 ]];then
				gitErrorMenu
			fi
		fi
	fi
}

# Mis à jour forcé de Piwebpool
# Cela n'affectera pas la base de données 
forcePiwebpoolUpdate(){
PiwebpoolLogo
echo -e "$OK -----> Mise à jour de Piwebpool Server $NORMAL"

cd $PIWEBPOOLDIR && git fetch --all > /dev/null 2>&1
fetchStatus=$?
cd $PIWEBPOOLDIR && lastcomment=$(git reset --hard origin/master | awk '{$1="";$2="";$3="";$4="";$5="";print $0;}') > /dev/null 2>&1
resetStatus=$?
cd $PIWEBPOOLDIR && pullLog=$(git pull origin master) > /dev/null 2>&1
pullStatus=$?

if [[ $fetchStatus -eq 0 ]] && [[ $resetStatus -eq 0 ]] && [[ $pullStatus -eq 0 ]];then
	
	echo -e "$INFO -----> Dernier statut - $lastcomment $NORMAL"
	# On revérifie les permissions
	setPermissions
else
	echo -e "$ERR -----> La mise à jour a échoué $NORMAL"
	echo $pullLog
fi



}

#Vérification des permissions pour Piwebpool Server et le plugin radioRelay
setPermissions(){
	echo -e "$OK -----> Modifications des permissions de Piwebpool $NORMAL"
	touch $PIWEBPOOLDIR/logfile.txt
	chown -R www-data:www-data $PIWEBPOOLDIR
	chmod 750 -R $PIWEBPOOLDIR
    #file permission and configuration
    chmod 774 /etc/ssmtp/ssmtp.conf
    usermod -a -G webide www-data
    chmod g+w $PIWEBPOOLDIR
    chmod -R 0775 $PIWEBPOOLDIR/css $PIWEBPOOLDIR/js $PIWEBPOOLDIR/include
    #this is to access the ttyUSB0 from apache
    sudo usermod -a -G dialout www-data
}

# Cherche des scripts dans les scripts
getAllScripts(){
	allScripts=$(find $PIWEBPOOLDIR/scripts -name "*.sh")
	if [[ -z "${allScripts// }" ]];then
		allScripts="Aucun Script disponible"
	fi
}

# Donne les permissions root au serveur web à un programme
# Les permissions ont été géré de façon à limité au maximum l'accès
giveRootPermissions(){
	rootProgram=$1
	chown root:www-data $rootProgram
	chmod 000 $rootProgram
	chmod +sx $rootProgram
}

# Installation de wiringPi dans /opt/wiringPi
# Une fois installé , wiringPi n'utilisera pas ce dossier qui ne contient que les sources
installWiringPi(){
	#Vérifie si WiringPi est installé sinon on ne l'installe pas
	if [[ ! -f /usr/local/bin/gpio ]];then
		echo -e "$OK -----> Copie de wiringPi $NORMAL"

		#Si les sources ont déjà été copié on les efface pour les retélécharger
		if [ -d /opt/wiringPi ];then
			rm -rf /opt/wiringPi
		fi

		cd /opt/
		git clone git://git.drogon.net/wiringPi /opt/wiringPi > /tmp/gitError.log 2>&1
		globalError=$?
		if [[ $globalError -ne 0 ]];then
			gitErrorMenu
		fi
		cd /opt/wiringPi/
		echo -e "$OK -----> Installation de wiringPi $NORMAL"
		./build > /tmp/wiringPiError.log 2>&1
		globalError=$?
		if [[ $globalError -ne 0 ]];then
			wiringPiErrorMenu
		fi
	fi
}

# Execution des divers composants
installPiwebpoolMisc(){

echo -e "$OK -----> Installation des dépendances $NORMAL"

if [[ -s $PIWEBPOOLDIR/db/.database.db ]];then
	# Installation de supervisor
	debconf-apt-progress -- apt-get install -q -y supervisor
	globalError=$?
	if [[ $globalError -ne 0 ]];then
		aptgetErrorMenu
	fi

	# Configuration du socket dans supervisor
cat <<\EOF > /etc/supervisor/conf.d/Piwebpool.conf
[program:Piwebpool]
command=/usr/bin/php $PIWEBPOOLDIR/socket.php
autostart=true
autorestart=true
stdout_logfile=/var/log/PiwebpoolSocket.log
redirect_stderr=true
EOF

	supervisorFatalError=0

	# Lecture du fichier de configuration
	supervisorctl reread > /tmp/supervisorReReadError.log 2>&1
	supervisorError=$(cat /tmp/supervisorReReadError.log)
	if [[ ! $supervisorError == "No config updates to processes" && ! $supervisorError == "Piwebpool: available" ]];then
		echo -e "$ERR Erreur dans /etc/supervisor/conf.d/Piwebpool.conf - $supervisorError $NORMAL"
		supervisorFatalError=1
	fi

	# Ajout du socket dans supervisor
	supervisorctl update > /tmp/supervisorUpdateError.log 2>&1
	supervisorErrorUpdate=$(cat /tmp/supervisorUpdateError.log)
	if [[ $supervisorError == "" && ! $supervisorError == "Piwebpool: added process group" ]];then
		echo -e "$ERR Erreur dans /etc/supervisor/conf.d/Piwebpool.conf - $supervisorError $NORMAL"
		supervisorFatalError=1
	fi

	# Relancement du socket pour test
	if [[ $supervisorFatalError -eq 0 ]];then
		supervisorctl stop Piwebpool > /tmp/supervisorStopError.log 2>&1
		supervisorctl start Piwebpool > /tmp/supervisorStartError.log 2>&1

		supervisorStartError=$(cat /tmp/supervisorStartError.log)
		if [[ ! $supervisorStartError == "Piwebpool: started" ]];then
			echo -e "$ERR Erreur lancement du socket - $supervisorStartError $NORMAL"
			echo -e "$ERR Tapez $INFO sudo cat /var/log/PiwebpoolSocket.log pour plus d'information $NORMAL"
		fi
	fi

else
	echo -e "$ERR Aller sur $INFO http:///$HOSTNAME.local/piwebpool $ERR pour finalisez l'installation avant d'installer le socket $NORMAL"
fi

}
	
addCron(){
	echo -e "$OK -----> Installation du cron scénario $NORMAL"

	if [[ -f /etc/cron.hourly/$REPONAME ]];then
	    echo -e "$WARN -----> Installation du cron (déjà effectué) $NORMAL"	
		
	else
		#crontab -l | { cat; echo '*/1 * * * * wget "http://localhost/action.php?action=crontab" -O /dev/null 2>&1'; } | crontab -
		ln -s "$PIWEBPOOLDIR/scripts/$CRONSCRIPT" "/etc/cron.hourly/$REPONAME"
	fi
}

#Afin de sécuriser Piwebpool une fois l'installation fini, on supprime install.php
#Et on change le mot de passe de l'utilisateur par défaut (pi)
securityCheck(){
	if [[ -f $PIWEBPOOLDIR/install.php ]];then
		echo -e "$OK -----> Supression de install.php $NORMAL"
		rm $PIWEBPOOLDIR/install.php
		
	fi
}

# Pour redimensionner la carte sd, j'utilise raspi-config en mode unattended
resizeSDCard(){
	echo -e "$OK -----> Vérification du redimensionnement de la carte SD $NORMAL"
	raspi-config --expand-rootfs > /tmp/resizeSDCardError.log 2>&1
}

endInstall(){
	HOSTNAME=$(cat /etc/hostname)
	echo -e "$OK -----> Finissez l'installation en allant sur votre $WARNING navigateur $OK à $INFO http://$HOSTNAME.local $NORMAL"
	echo -ne "$WARN ATTENTE DE L'UTILISATEUR $NORMAL"
	databaseCreated=0
	while [[ databaseCreated -eq 0 ]]
	do
		if [ ! -s $PIWEBPOOLDIR/db/.database.db ];then
			echo -ne "."
		else
			echo -e "$OK --> OK! $NORMAL"
			databaseCreated=1
		fi
		sleep 3
	done
}

#http://unix.stackexchange.com/questions/60299/how-to-determine-which-sd-is-usb par F.Hauri
getUSB(){
	cut -d/ -f4 <(grep -vl ^0$ $(sed s@device/.*@size@ <(grep -l ^DRIVER=sd $(sed s+/rem.*$+/dev*/ue*+ <(grep -Hv ^0$ /sys/block/*/removable)) <(:))) <(:))

}

saveUSB(){
	PiwebpoolLogo
	USBDrive="/dev/$(getUSB)1"

	#Si aucun lecteur n'est detecté
	if [[ $USBDrive == "/dev/1" ]];then
		echo -e "$WARN -----> Aucun clé USB detecté ! $NORMAL"
	else
		echo -e "$OK -----> Clé USB trouvé sur $INFO $USBDrive $NORMAL"
		
		#Si le lecteur existe vraiment
		if [[ -e "$USBDrive" ]];then
		
			# Si la clé est déjà monté, on l'a démonte par sécurité
			if mount |grep "/media/backupUSB" > /dev/null;then
				umount /media/backupUSB
				#@todo rajouter un test
			fi

			# Si le dossier de montage n'existe pas on le crée
			if [ ! -d /media/backupUSB ];then
				mkdir /media/backupUSB
			fi
		
			# On monte la clé USB
			mount "$USBDrive" /media/backupUSB
			mountState=$?

			# Si le montage s'est déroulé correctement
			if [[ $mountState -eq 0 ]];then

				#Si une sauvegarde précédente, on prévient l'utilisateur
				if [ -d /media/backupUSB/Piwebpool ];then
					confirmEraseUSB
					#On efface la sauvegarde précédente
					if [[ confirmErase -eq 1 ]];then
						rm -rf /media/backupUSB/Piwebpool
						echo -e "$WARN -----> Supression de la sauvegarde précédente $NORMAL"
					else
						echo -e "$WARN -----> Annulation de la sauvegarde"
					fi
				else 
					confirmErase=1
				fi

				#Si pas de sauvegarde précédente ou confirmation de la suppression
				if [[ confirmErase -eq 1 ]];then
					echo -e "$OK -----> Copie des fichiers $NORMAL"
					cp -R $PIWEBPOOLDIR/ /media/backupUSB/Piwebpool
					copyState=$?

					if [[ $copyState -eq 0 ]];then
						echo -e "$OK -----> Copie réussi avec succès ! $NORMAL"

					else
						echo -e "$ERR -----> La copie a échoué ! $NORMAL"
					fi
				fi

				# Quoiqu'il arrive nous démontons la clé à la fin				
				echo -e "$OK -----> Démontage de la clé USB $NORMAL"
				umount /media/backupUSB
				umountState=$?
				
				#Si l'état de la clé n'est pas correcte
				if [ $umountState -eq 0 ];then
					echo -e "$OK -----> Vous pouvez retirer votre clé en toute sécurité $NORMAL"
				else
					echo -e "$ERR -----> La clé n'a pas été correctement démontée $NORMAL "
					echo -e "$INFO Vous pouvez la démonter manuellement en tapant $OK umount /media/backupUSB $NORMAL"
				fi
			
			else
				echo -e "$ERR -----> Impossible de monter ! $NORMAL"	
			fi

		else
			echo -e "$ERR -----> La détection a échoué ! $NORMAL"
		fi	
	fi
}

restoreUSB(){
	PiwebpoolLogo
	USBDrive="/dev/$(getUSB)1"

	#Si aucun lecteur n'est detecté
	if [[ $USBDrive == "/dev/1" ]];then
		echo -e "$WARN -----> Aucun clé USB detecté ! $NORMAL"
	else
		echo -e "$OK -----> Clé USB trouvé sur $INFO $USBDrive $NORMAL"
		
		#Si le lecteur existe vraiment
		if [[ -e "$USBDrive" ]];then
		
			# Si la clé est déjà monté, on l'a démonte par sécurité
			if mount |grep "/media/backupUSB" > /dev/null;then
				umount /media/backupUSB
				#@todo rajouter un test
			fi

			# Si le dossier de montage n'existe pas on le crée
			if [ ! -d /media/backupUSB ];then
				mkdir /media/backupUSB
			fi
		
			# On monte la clé USB
			mount "$USBDrive" /media/backupUSB
			mountState=$?

			# Si le montage s'est déroulé correctement
			if [[ $mountState -eq 0 ]];then

				rm -rf $PIWEBPOOLDIR
				echo -e "$WARN -----> Supression de piwebpool $NORMAL"

				echo -e "$OK -----> Restauration de la sauvegarde $NORMAL"
				cp -R /media/backupUSB/Piwebpool $PIWEBPOOLDIR/ 
				copyState=$?

				if [[ $copyState -eq 0 ]];then
					echo -e "$OK -----> La restauration est un succès ! $NORMAL"

				else
					echo -e "$ERR -----> La restauration a échoué ! $NORMAL"
				fi
				

				# Quoiqu'il arrive nous démontons la clé à la fin				
				echo -e "$OK -----> Démontage de la clé USB $NORMAL"
				umount /media/backupUSB
				umountState=$?
				
				#Si l'état de la clé n'est pas correcte
				if [ $umountState -eq 0 ];then
					echo -e "$OK -----> Vous pouvez retirer votre clé en toute sécurité $NORMAL"
					echo -e "$INFO Pour réouvrir la clé USB tapez : $ERR mount $USBDrive /media/backupUSB $NORMAL"
				else
					echo -e "$ERR -----> La clé n'a pas été correctement démonté $NORMAL "
					echo -e "$INFO Vous pouvez la démonter manuellement en tapant $OK umount /media/backupUSB $NORMAL"
				fi
			
			else
				echo -e "$ERR -----> Impossible de monter ! $NORMAL"	
			fi

		else
			echo -e "$ERR -----> La détection a échoué ! $NORMAL"
		fi	
	fi
}

# Renomme le Raspberry Pi sur le réseau
# Il sera alors accessible depuis newhostname.local
# Cela va modifier /etc/hosts et /etc/hostname où le daemon avahi
# va chercher le nom du Raspberry Pi
renamePi(){

PiwebpoolLogo
if [[ -z $newhostname ]];then
	newhostname="maison"
fi
		
cat <<EOF > /etc/hosts && 
127.0.0.1       localhost
::1             localhost ip6-localhost ip6-loopback
fe00::0         ip6-localnet
ff00::0         ip6-mcastprefix
ff02::1         ip6-allnodes
ff02::2         ip6-allrouters

127.0.1.1       $newhostname
EOF

echo $newhostname > /etc/hostname

hostname $newhostname
service avahi-daemon restart > /dev/null 2>&1
whiptail --title "Raspberry Pi s'appelle $newhostname.local" --msgbox "Tapez http://$newhostname.local/ pour accéder à Piwebpool" 0 0
echo -ne "$OK -----> Renommage du Raspberry Pi $NORMAL"
echo -e "$WARN : $newhostname.local $NORMAL"
}

###############
# La partie principale
###############
# Si vous voulez supprimer des étapes ou en rajouter
# C'est ici que tout se passe

#Vérification des droits administrateur
cd /
verifyRoot

if [[ $isRoot -eq 1 ]];then

	
	if [[ $# -eq 1 ]];then
		scriptToExecute=$1
		
		if [[ scriptToExecute -eq "noresize" ]];then
			resizeSDCard=0
		fi

	else


		# Affichage du menu principal
		mainMenu

		# Si Installer est appuyé
		if [[ $doInstall -eq 1 ]];then


			if [ $resizeSD -eq 1 ];then	
				resizeSDCardMenu # Redimensionnement de la carte SD
			fi

			# Renommer le Raspberry Pi
			renameMenu

			# Vérifier si github.com est accessible
			checkInternet
			if [[ $internet -eq 1 ]];then

				setLocaleToFrench # Mettre le terminal en français
				updateRaspberryPi # Mettre à jour le Raspberry Pi (apt-get update/upgrade)
				configureTimeZone # Configurer le fuseau horaire automatiquement (tzupdate)

				# Clone le repo ldleman/Piwebpool
				clonePiwebpool

				# Installe le serveur web
				checkWebServer
				if [[ $doapacheSetupError -eq 1 ]];then
				 	apacheSetupError
				 	setupWebServer
				fi
		
				# Vérifie les permissions des fichiers et des binaires
				setPermissions
			
				# Install WiringPi (gpio)
				installWiringPi

				# Affiche un message avec l'étape sur le web
				endInstall
				securityCheck
				installDependenciesMenu
				installPiwebpoolMisc
				addCron
				echo -e "$OK Installation TERMINE!!! Il est conseillé de $ERR redémarrer $OK votre raspberry pi $NORMAL"
				echo -e "$INFO sudo reboot $NORMAL"
			fi
		fi
	fi
fi