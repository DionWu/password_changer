<?php
// ---------------------------------------------------------
 $app_name = "phpJobScheduler";
 $phpJobScheduler_version = "3.7";
// ---------------------------------------------------------
  define('TIME_WINDOW', 3600);//denomination is in seconds, so 3600 = 60 minute time frame window

  define('ERROR_LOG', TRUE);// prints successful runs and errors to log table

  define('LOCATION', dirname(__FILE__) ."/");// used to open local files

  define('PJS_TABLE','phpjobscheduler');// pjs table name
  define('LOGS_TABLE','phpjobscheduler_logs');// logs table name

  define('MAX_ERROR_LOG_LENGTH',1200);// maximum string length of output to record in error log table

?>
