<?php

    /**
     * Example webhook format plugin.
     */
    class TestPlugin extends Plugin {
        
        public function execute($object) {
            
	    __log("Processed in textplugin.php");
            __log("Object:" . print_r($object, true));
            
            return $object;
        }
    }
