<?php

    /**
     * Example webhook format plugin.
     */
    class BalanceAlertPlugin extends Plugin {
        
        public function execute($object) {
            
	    __log("Processed in balance alert");
            __log("Object:" . print_r($object->description, true));
            
            return $object;
        }
    }
