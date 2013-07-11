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
 *     3.61     Dec 2009    Patched for PHP v5.3           *
       3.8 April 2012 - Corrected issue stopping the database updating and logs being saved when a schedule was fired.
                        Also, amended the db structure to ensure logs are saved when two or more schedules run at the same time.                         
 *  NOTES:                                                *
 *        Requires:  PHP and MySQL                        *
 **********************************************************/
 $phpJobScheduler_version = "3.61";
// ---------------------------------------------------------
include("functions.php");
$id=clean_input($_POST['id']);
db_connect();
$query="select * from phpjobscheduler where id=$id";
$result = mysql_query($query);
if (!$result) js_msg("There has been an error: ".mysql_error() );
else $row = mysql_fetch_array($result);
db_close();
// check if its hours
$interval_array = time_unit($row["time_interval"]);

if (preg_match("/minute/",$interval_array[1])>0) $minutes=$interval_array[0];
else $minutes=-1;
if (preg_match("/hour/",$interval_array[1])>0) $hours=$interval_array[0];
else $hours=-1;
if (preg_match("/day/",$interval_array[1])>0) $days=$interval_array[0];
else $days=-1;
if (preg_match("/week/",$interval_array[1])>0) $weeks=$interval_array[0];
else $weeks=-1;
include("header.html");
include("add-modify.html");
include("footer.html");
?>
<script language="JavaScript"><!--
with (document.I_F)
{
 id.value="<?php echo $row["id"]; ?>";
 name.value="<?php echo $row["name"]; ?>";
 scriptpath.value="<?php echo $row["scriptpath"]; ?>";
 minutes.value=<?php echo $minutes; ?>;
 hours.value=<?php echo $hours; ?>;
 days.value=<?php echo $days; ?>;
 weeks.value=<?php echo $weeks; ?>;
 time_last_fired.value=<?php echo $row['time_last_fired']; ?>;
 button.value="Modify Job";
 original_minutes=<?php echo $minutes; ?>;
 original_hours=<?php echo $hours; ?>;
 original_days=<?php echo $days; ?>;
 original_weeks=<?php echo $weeks; ?>;
 run_only_once.value=<?php echo $row['run_only_once']; ?>;
}
// --></script>