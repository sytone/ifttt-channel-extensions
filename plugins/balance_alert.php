<?php

    require_once(dirname(__FILE__) . '/../tools/prowl.php');

    /**
     * Example webhook format plugin.
     */
    class BalanceAlertPlugin extends Plugin {
        
        public function execute($object) {
            
	    preg_match('/varasi on (\d+,\d{2}) EUR/', $object->description, $matches);
	    
	    if (count($matches) == 2) {
		$balance = $matches[1];
		send_prowl_notification( "Ruokarahatilin saldo", $balance . " EUR" );
	    } else {
		send_prowl_notification( "Ruokarahatili", "Tarkista saldo" );
	    }
	    
	    return true;
	    
        }
    }
