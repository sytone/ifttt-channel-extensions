<?php
    function select_the_right_recipe_for($object) {
	
	if ( $object->plugin == "email" && $object->title == "Saldohlytys S-Pankista" ) {
	    // Custom handlings here
	    return execute_plugin( "balance_alert", $object  );
	    
	} else {
	    // Default behaviour; load plugin based on $object->plugin
	    return execute_plugin( $object->plugin, $object );
	}
	  
    }
?>