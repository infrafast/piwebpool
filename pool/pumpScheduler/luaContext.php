<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file,$materials,$pins){
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    
    // record names of the command as variable
    // since the setPinState function gets the logical pin number, we have to get it from the table
    foreach($materials as $material=>$pin){
        $lua->assign($material, $pins[$pin]);    
        //echo "{material: ".$material." pin:".$pins[$pin]."}";
    }
    
    $lua->registerCallback("set", 'setPinState');
    $lua->registerCallback("get", 'getPinState');
    return $lua;
}


?>