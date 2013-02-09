<?php

    /**
     * Plugin superclass.
     */
    abstract class Plugin {
        
        abstract function execute($object);
    }

    /**
     * Execute a plugin
     * @param type $plugin
     * @param type $object
     * @param type $raw 
     * @return stdClass
     */
    function execute_plugin($plugin, $object) {

        //$plugin = preg_replace("/[^a-zA-Z0-9\s]/", "", $plugin);
	
	// Camel case to underscored
	$plugin = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $plugin));
	
	// Space to underscore
	$plugin = preg_replace('/\s+/', '_', $plugin);
	
        if (!file_exists(dirname(__FILE__) . "/plugins/$plugin.php")) {
            __log("Plugin file $plugin.php could not be located");
            return false;
        }
        
        require_once(dirname(__FILE__) . "/plugins/$plugin.php");
        
	// Underscored to camel case
	$class_name = str_replace(' ', '', ucwords(str_replace('_', ' ', $plugin))) . "Plugin";
	
	if (!class_exists($class_name)) {
	    __log("Plugin class '" . $class_name . "' couldn't be loaded");
	    return false;
	}
	
	$plugin_class = new $class_name();
	__log("Executing plugin " . $class_name);
        return $plugin_class->execute( $object );

    }
    