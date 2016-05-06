<?php
/* Update Sort Order */
mysql_select_db($database_PGC, $PGC);
$runSQL = "UPDATE pgc_jobs SET sort_order = (SELECT sort_order FROM pgc_job_status WHERE pgc_jobs.job_status =  pgc_job_status.job_status)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Freshen email addreesses */
 
$runSQL = "UPDATE pgc_jobs SET job_sponsor_email = (SELECT USER_ID FROM pgc_members WHERE pgc_jobs.job_sponsor = pgc_members.NAME)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
$runSQL = "UPDATE pgc_jobs SET job_leader_email = (SELECT USER_ID FROM pgc_members WHERE pgc_jobs.job_leader = pgc_members.NAME)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
$runSQL = "UPDATE pgc_job_volunteers SET job_volunteer_id = (SELECT USER_ID FROM pgc_members WHERE pgc_job_volunteers.job_volunteer_name = pgc_members.NAME)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
/* Populate Volunteers */
 
$runSQL = "UPDATE pgc_jobs SET job_volunteers = (SELECT GROUP_CONCAT(DISTINCT job_volunteer_name SEPARATOR '\n') FROM pgc_job_volunteers WHERE pgc_job_volunteers.rec_deleted <> 'YES' AND pgc_jobs.job_key = pgc_job_volunteers.job_id GROUP BY job_id)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
$runSQL = "UPDATE pgc_jobs SET job_volunteers_email = (SELECT GROUP_CONCAT(DISTINCT job_volunteer_id SEPARATOR ';') FROM pgc_job_volunteers WHERE pgc_jobs.job_key = pgc_job_volunteers.job_id GROUP BY job_id)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
?>
