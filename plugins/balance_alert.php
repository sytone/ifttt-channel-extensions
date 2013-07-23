<?php

    require_once(dirname(__FILE__) . '/../tools/push_notifications.php');

    /**
     * Example webhook format plugin.
     */
    class BalanceAlertPlugin extends Plugin {
        
        public function execute($object) {
            
	    preg_match('/varasi on (\d+,\d{2}) EUR/', $object->description, $matches);
	    	    
	    if (count($matches) == 2) {
		$balance = $matches[1];
		send_cross_platform_notification( "Ruokarahatilin saldo", $balance . " EUR" );
	    } else {
		send_cross_platform_notification( "Ruokarahatili", "Tarkista saldo" );
	    }
	    
	    return true;
	    
        }
    }
