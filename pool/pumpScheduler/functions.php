<?php

function getPinState($pin,$pins){
	$commands = array();
	exec("gpio read ".$pins[$pin],$commands,$return);
	return (trim($commands[0])=="1"?'on':'off');


}

function secure($string){
	return htmlentities(stripslashes($string),NULL,'UTF-8');
}

function getCurrentTimeWindow(){
    // get the current hours and force multiple to 2
    $tw=date("H");
    //$tw=9; // force value for testing
    if ($tw/2 <> intval($tw/2)) $tw-=1;
    // format to 2 digit (prefix 0) 
    $prefixDigit="";
    if ($tw<10) $prefixDigit="0";
    // convert to text with hour so it match the row name in table
    $tw=$prefixDigit.$tw."h";
    return $tw;
}

/*
wiringPi
Pin 	BCM
GPIO 	Name 	Header 	Name 	BCM
GPIO 	wiringPi
Pin
– 	– 	3.3v 	1 | 2 	5v 	– 	–
8 	0 	SDA0 	3 | 4 	DNC 	– 	–
9 	1 	SCL0 	5 | 6 	0v 	– 	–
7 	4 	GPIO 7 	7 | 8 	TxD 	14 	15
– 	– 	DNC 	9 | 10 	RxD 	15 	16
0 	17 	GPIO 0 	11 | 12 	GPIO 1 	18 	1
2 	21 	GPIO 2 	13 | 14 	DNC 	– 	–
3 	22 	GPIO 3 	15 | 16 	GPIO 4 	23 	4
– 	– 	DNC 	17 | 18 	GPIO 5 	24 	5
12 	10 	MOSI 	19 | 20 	DNC 	– 	–
13 	9 	MISO 	21 | 22 	GPIO 6 	25 	6
14 	11 	SCLK 	23 | 24 	CE0 	8 	10
– 	– 	DNC 	25 | 26 	CE1 	7 	11
*/


?>