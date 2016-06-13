<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
include("configuration.php");

// base class with member properties and methods
class LuaPool {

    static $lua;
    var $script;

    function LuaPool($file){
        $script=$file;
        $lua=new Lua($file);
        $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */        
    }

   function get() 
   {
       return $this->$lua;
   }

   function run() 
   {
       return $lua->run();      
   }

} // end of class Vegetable

?>