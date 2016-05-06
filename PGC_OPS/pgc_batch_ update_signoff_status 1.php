<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<?php
/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Set Expired to Blank for Non-Expires */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = '' WHERE B.expires = 'NO'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 365 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 730 Month End Expiry */ 
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 365 Month End Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Everyone to OK */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'OK'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'NG' WHERE A.expire_date < CURDATE() AND B.expires = 'YES'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set No Signoff Date to NG */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'NG' WHERE A.signoff_date = '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = signoff_date WHERE signoff_date = '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Non Expires to OK */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'OK' WHERE A.signoff_date <> '0000-00-00' AND B.expires = 'NO'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
?>


<body>
</body>
</html>
