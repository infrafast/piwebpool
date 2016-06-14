<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function goLua($file,$materials,$pins,&$status){
    $ret = true;
    try{
        $lua=new Lua($file);
        
        // record names of the command as variable and manipulate them directly phyisically in lua using set and get functions
        // since the setPinState function gets the logical pin number, we have to get it from the table
    
        foreach($materials as $material=>$pin){
            $luaVariables[$pin]=getPin($pins[$pin]);
            $lua->assign($material, $pins[$pin]);     // option 1;
            //echo "{material: ".$material." pin:".$pins[$pin]."}";
        }
        $lua->registerCallback("set", 'setPinState'); // option 1
        $lua->registerCallback("get", 'getPin'); // option 1
        
        // execute the script
        $lua->run();
    } catch (LuaException $e) {
         $status= $e->getMessage();
         $ret = false;
    }
    return $ret;
}


?>