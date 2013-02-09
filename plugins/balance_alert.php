<?php

    /**
     * Example webhook format plugin.
     */
    class BalanceAlertPlugin extends Plugin {
        
        public function execute($object) {
            
	    $balance = "???,??";
	    
	    preg_match('/varasi on (\d+,\d{2}) EUR/', $object->description, $matches);
	    
	    if (count($matches == 2)) {
		$balance = $matches[1];
	    }
	    
	    __log("Current balance is " . $balance . " EUR");
            
            return true;
        }
    }
