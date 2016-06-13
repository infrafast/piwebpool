<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
include ("configuration.php");

function getLua($file){
    $script=$file;
    $lua=new Lua($file);
    $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */        
    return $lua;
}


?>