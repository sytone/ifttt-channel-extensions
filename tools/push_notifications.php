<?php

    function send_cross_platform_notification( $application, $subject, $body = "" ) {
	return
	  send_iphone_notification(  $application, $subject, $body ) &&
	  send_android_notification( $application, $subject, $body );
    }

    function send_iphone_notification( $application, $subject, $body = "" ) {
	__log("Sending iPhone ('Prowl') notification");
        return send_push_notification(
	    "https://api.prowlapp.com/publicapi/add",
	    PROWL_API_KEY,
	    $application,
	    $subject,
	    $body
	);
    }

    function send_android_notification( $application, $subject, $body = "" ) {
	__log("Sending 'Notify my Android' notification");
        return send_push_notification(
	    "https://www.notifymyandroid.com/publicapi/notify",
	    NOTIFY_MY_ANDROID_API_KEY,
	    $application,
	    $subject,
	    $body
	);
    }

    function send_push_notification( $url, $apikey, $application, $subject, $body ) {
	
	//__log("Sending push notification: '$application' | '$subject' | '$body'");
	
	// HTTP POST code copied from http://stackoverflow.com/a/6609181
	// and http://stackoverflow.com/a/11195757
	
	$data = array(
	    'apikey' => $apikey,
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
	
	$success_str = 'code="200"';
	$success = (strpos($result, $success_str) !== false);

	if ($success === false) {
	    __error("Sending message to notification server failed for some reason");
	    return false;
	} else {
	    return true;
	}
    
    }

?>