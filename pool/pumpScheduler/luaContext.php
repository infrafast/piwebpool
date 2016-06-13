<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file,$materials){
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    $lua->assign("filtration", $pins[$materials["Filtration"]]); /** assign a PHP var to Lua named from */        
    $lua->registerCallback("set", 'setPinState');
    return $lua;
}


?>