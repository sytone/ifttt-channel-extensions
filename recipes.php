<?php
    function select_the_right_recipe_for($object) {
	
	if ( false ) {
	    // Custom handlings here
	    
	} else {
	    // Default behaviour; load plugin based on $object->plugin
	    return executePlugin( $object->plugin, $object );
	}
	  
    }
?>