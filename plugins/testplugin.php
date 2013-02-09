<?php

    /**
     * Example webhook format plugin.
     */
    class TestPlugin extends Plugin {
        
        public function execute($plugin, $object) {
            
	    __log("Processed in textplugin.php");
            __log("Plugin: " . $plugin);
            __log("Object:" . print_r($object, true));
            
            return $object;
        }
    }
