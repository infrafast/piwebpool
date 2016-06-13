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
        echo "material: ".$material." pin:".$pin;
        $lua->assign("filtration", $pins[$pin]);    
    }
    
    $lua->registerCallback("set", 'setPinState');
    return $lua;
}


?>