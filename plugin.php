<?php

    /**
     * Plugin superclass.
     */
    abstract class Plugin {
        
        abstract function execute($plugin, $object);
    }

    /**
     * Execute a plugin
     * @param type $plugin
     * @param type $object
     * @param type $raw 
     * @return stdClass
     */
    function executePlugin($plugin, $object) {

        $plugin = preg_replace("/[^a-zA-Z0-9\s]/", "", $plugin);        
        $file = strtolower($plugin);
        
        if (!file_exists(dirname(__FILE__) . "/plugins/$file.php")) {
            __log("Plugin file $file.php could not be located");
            return false;
        }
        
        require_once(dirname(__FILE__) . "/plugins/$file.php");
        
	if (!class_exists($plugin)) {
	    __log("Plugin class '".$plugin."' couldn't be loaded");
	    return false;
	}
	
	$plugin_class = new $plugin();
	__log("Executing plugin " . $plugin);
        return $plugin_class->execute( $plugin, $object );

    }
    