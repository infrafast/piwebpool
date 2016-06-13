<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");




// base class with member properties and methods
class LuaPool {

   var $lua;

   function get() 
   {
       return $this->$lua
   }

   function run() 
   {
       return $this->edible;
   }

} // end of class Vegetable






function getLua($script)
    static $lua=new Lua($script);
    $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */
    return $lua;
}

function runLua()
    $func = $lua->run();
    return $func;
}

?>