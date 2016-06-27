<?php
/*
 @nom: common
 @auteur: Idleman (idleman@idleman.fr)
 @description: Page incluse dans tous (ou presque) les fichiers du projet, inclus les entitées SQL et récupère/traite les variables de requetes
*/
session_start();
$start=microtime(true);
require_once('configuration.php');
require_once('functions.php');
error_reporting(E_ALL);
//Calage de la date
date_default_timezone_set('Europe/Paris'); 
$myUser = (isset($_SESSION['currentUser'])?unserialize($_SESSION['currentUser']):false);
//Récuperation et sécurisation de toutes les variables POST et GET
$_ = array();
foreach($_POST as $key=>$val){
	$_[$key]=secure($val);
}
foreach($_GET as $key=>$val){
	$_[$key]=secure($val);
}
?>