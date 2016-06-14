<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function goLua($file,$materials,$pins){
    // local copy the variable names
    $luaVariables = $materials;
    // add error caught
    $script=$file;
    $lua=new Lua($file);
    
    
    // option 1
    // record names of the command as variable and manipulate them directly phyisically in lua using set and get functions
    // since the setPinState function gets the logical pin number, we have to get it from the table
    // option 2 : PREFERRED
    // register variable and manipulate them logically in lua, then resync physically here

    foreach($materials as $material=>$pin){
        $luaVariables[$pin]=getPin($pins[$pin]);
        //$lua->assign($material, $pins[$pin]);     // option 1;
        $lua->assign($material,$luaVariables[$pin]);      // option 2
        //echo "{material: ".$material." pin:".$pins[$pin]."}";
    }
    //$lua->registerCallback("set", 'setPinState'); // option 1
    //$lua->registerCallback("get", 'getPin'); // option 1
    

    // execute the script
    $lua->run();
    // option 2 
    // get back the variable modified by script to update command
    foreach ($luaVariables as $luaVariable=>$value){
        echo "{FROM PHP luaVariable: ".$luaVariable."=".$value." pin:".$pins[material$[$luaVariable]].""}";
        //setPinState($pins[$pin],$value);      // option 2
    }
    
    
    return $lua;
}


?>