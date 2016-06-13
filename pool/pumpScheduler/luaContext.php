<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file,$materials,$pins){
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    
    for ($i = 0; $i < count($materials); ++$i) {
        echo "material: ".$material[$i];
        $lua->assign("filtration", $pins[$materials["Filtration"]]);    
        print $array[$i];
    }
    
    $lua->registerCallback("set", 'setPinState');
    return $lua;
}


?>