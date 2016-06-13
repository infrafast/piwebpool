<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file,$materials,$pins){
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    
    foreach($materials as $material=>$pin){
        $lua->assign($material, $pins[$pin]);    
        echo "{material: ".$material." pin:".$pins[$pin]."}";
    }
    
    $lua->registerCallback("set", 'setPinState');
    return $lua;
}


?>