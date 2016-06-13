<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");




// base class with member properties and methods
class LuaPool {

    var $lua;
    var $script;

    function LuaPool($file){
        this->$script=$file;
        $lua=new Lua($file);
    }

   function get() 
   {
       return $this->$lua
   }

   function run() 
   {
       return $lua->run();      
   }

} // end of class Vegetable






function getLua($script)
    static $lua=new Lua($script);
    $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */
    return $lua;
}


?>