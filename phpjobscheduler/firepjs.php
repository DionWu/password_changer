<?php
/**********************************************************
 *                phpJobScheduler                         *
 *           Author:  DWalker.co.uk                        *
 *    phpJobScheduler © Copyright 2003 DWalker.co.uk      *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Oct 2003                          *
 *     Version    Date              Comment               *
 *     1.0       14th Oct 2003      Original release      *
 *     3.0       Nov 2005       Released under GPL/GNU    *
 *     3.0       Nov 2005       Released under GPL/GNU    *
 *     3.1       June 2006       Fixed modify issues,     *
 *                               and other minor issues   *
 *     3.3       Dec 2006     removed bugs/improved code  *
 *     3.4       Nov 2007     AJAX, and improved script   *
 *                       include using CURL and fsockopen *
 *     3.5     Dec 2008    Improvements, including        *
 *   single fire, silent db connect, fire time in minutes *
 *     3.6     Oct 2009    Version check added            *
 *     3.7 Feb 2011 - DEBUG improved to aid install,
                      and new method added to ensure only one instance of the same script runs at any one time
       3.8 April 2012 - Corrected issue stopping the database updating and logs being saved when a schedule was fired.
                        Also, amended the db structure to ensure logs are saved when two or more schedules run at the same time.                         
 *  NOTES:                                                *
 *        Requires:  PHP and MySQL                        *
 **********************************************************/
 $app_name = "phpJobScheduler";
 $phpJobScheduler_version = "3.8";
// ---------------------------------------------------------
include_once("pjsfiles/functions.php");
include_once("pjsfiles/constants.inc.php");

include(LOCATION."phpjobscheduler.php");
// return image - used for html page img tag
if ( isset($_GET['return_image']) )
{
 header("Content-Type: image/gif");
 header("Content-Length: 49");
 echo pack('H*', '47494638396101000100910000000000ffffffffffff00000021f90405140002002c00000000010001000002025401003b');
}
?>
