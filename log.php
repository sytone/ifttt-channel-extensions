<?php

    /**
     * Debug logging
     */


     function __log($message, $level = "NOTICE") {
	 
	       // open log file
               $filename = "requests.log";
	       $fh = fopen($filename, "a") or die("Could not open log file.");
	       fwrite($fh, date("d-m-Y, H:i")." - $message\n") or die("Could not write file!");
	       fclose($fh);
     }