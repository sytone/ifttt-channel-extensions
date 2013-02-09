<?php

    function send_prowl_notification( $application, $subject, $body = "" ) {
	
	__log("Sending prowl notification");
	
	// HTTP POST code copied from http://stackoverflow.com/a/6609181
	// and http://stackoverflow.com/a/11195757
	
	$url = 'https://api.prowlapp.com/publicapi/add';
	$data = array(
	    'apikey' => PROWL_API_KEY,
	    'application' => $application,
	    'event' => $subject,
	    'description' => $body
	);
	
	$content = http_build_query($data);
	$options = array('http' => array(
	    'method'  => 'POST',
	    'header' => "Connection: close\r\n".
			"Content-type: application/x-www-form-urlencoded\r\n".
			"Content-Length: " . strlen($content) . "\r\n",
	    'content' => $content
	));
	$context  = stream_context_create($options);
	$result = @file_get_contents($url, false, $context);

	if ($result === false) {
	    __error("Sending message to prowl failed for some reason");
	    return false;
	} else {
	    return true;
	}
    
    }

?>