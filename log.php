<?php

    /**
     * Debug logging
     */


     function __log($message) {
         $filename = "requests.log";
	 $fh = fopen($filename, "a") or die("Could not open log file.");
	 fwrite($fh, date("d-m-Y, H:i")." - $message\n") or die("Could not write file!");
	 fclose($fh);
     }

     function __error($message) {
	 __log("ERROR - $message");
     }

     function __errorAndDie($message) {
	 __error($message);
	 die("ERROR - $message");
     }

?>