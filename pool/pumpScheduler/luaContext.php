<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file,$materials,$pins){
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    foreach ($materials as $material){
        $lua->assign("filtration", $pins[$materials["Filtration"]]);    
    }
    
    
    
    $lua->registerCallback("set", 'setPinState');
    return $lua;
}


?>