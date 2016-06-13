<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

$lua->assign("filtration", materials["filtration"]); /** assign a PHP var to Lua named from */

?>