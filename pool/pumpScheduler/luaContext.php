<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

$lua->assign("filtration", [$materials["Filtration"]); /** assign a PHP var to Lua named from */

?>