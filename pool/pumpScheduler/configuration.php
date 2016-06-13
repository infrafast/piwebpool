<?php

//Tableau de correspondant PIN physiques/PIN Logiques (de la librairie wiringPI)
$pins = array();
$pins[3] = 8;
$pins[5] = 9;
$pins[7] = 7;
$pins[11] = 0;
$pins[13] = 2;
$pins[15] = 3;
$pins[19] = 12;
$pins[21] = 13;
$pins[23] = 14;
$pins[8] = 15;
$pins[10] = 16;
$pins[12] = 1;
$pins[16] = 4;
$pins[18] = 5;
$pins[22] = 6;
$pins[24] = 10;
$pins[26] = 11;

$materials = array(
			"filtration"=>11,
			"traitement"=>12,
		    );
		    
		    
$options = array();
$options["database"] = array();		    


// Database host: if omitted defaults to localhost.
$options["database"]["host"]        = "localhost";

// Basic database information. These are required.
$options["database"]["name"]        = "pool";
$options["database"]["username"]    = "root";
$options["database"]["password"]    = "Quintal74605";

?>