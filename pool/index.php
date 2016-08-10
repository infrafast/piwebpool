<?php

require_once('configuration.php');
require_once('functions.php');
include("include/TableGear1.6.1.php");

$options["database"]["table"]  = "pumpSchedule";
$options["pagination"] = array();
$options["title"] = "Planificateur";
$options["allowDelete"] = false;
$options["sortable"]  = ""; 
$options["selects"] = array(
	"below0" => array("on" => 1, "off" => 0),
	"0to2" => array("on" => 1, "off" => 0),
	"2to4" => array("on" => 1, "off" => 0),
	"4to6" => array("on" => 1, "off" => 0),
	"6to8" => array("on" => 1, "off" => 0),
	"8to10" => array("on" => 1, "off" => 0),
	"10to12" => array("on" => 1, "off" => 0),
	"12to14" => array("on" => 1, "off" => 0),
	"14to16" => array("on" => 1, "off" => 0),
	"16to18" => array("on" => 1, "off" => 0),
	"18to20" => array("on" => 1, "off" => 0),
	"20to22" => array("on" => 1, "off" => 0),
	"22to24" => array("on" => 1, "off" => 0),
	"24to26" => array("on" => 1, "off" => 0),
	"26to28" => array("on" => 1, "off" => 0),
	"above28" => array("on" => 1, "off" => 0)
); 
$options["transform"]["below0"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["0to2"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["2to4"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["4to6"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["6to8"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["8to10"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["10to12"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["12to14"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["14to16"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["16to18"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["18to20"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["20to22"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["22to24"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["24to26"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["26to28"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$options["transform"]["above28"] = array("tag" => "img","attrib" => array("src" => "images/{DATA}.png"));
$table = new TableGear($options);

$optionsSet = array();
$optionsSet["database"] = array();		    
$optionsSet["database"]["host"]        = $options["database"]["host"];
$optionsSet["database"]["name"]        = $optio