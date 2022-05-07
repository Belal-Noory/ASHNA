<?php
    require 'app/Helpers/config.php';
    spl_autoload_register("autoLoad");
    // Auto Load all important libraries
    function autoLoad($class)
    {
        if(file_exists(APPROOT."/Helpers/". $class .".php"))
        {
            require(APPROOT."/Helpers/". $class .".php");
        }
        else if(file_exists(APPROOT."/Models/". $class .".php"))
        {
            require(APPROOT."/Models/". $class .".php");
        }
        else if(file_exists(APPROOT."/Controllers/". $class .".php"))
        {
            require(APPROOT."/Controllers/". $class .".php");
        }
    }
?>