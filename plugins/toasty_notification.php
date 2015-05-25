<?php

    require_once(dirname(__FILE__) . '/../tools/push_notifications.php');

    /**
     * Plugin to send a notification to toasty.
     */
    class ToastyNotificationPlugin extends Plugin {
        
        public function execute($object) {
            
            send_toasty_notification( "BasicTest",  $object->description);

	    return true;
	    
        }
    }

