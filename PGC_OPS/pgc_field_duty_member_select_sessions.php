<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
$session_duty_role = $_SESSION['MM_duty_role'];
 
If ($_SESSION['MM_duty_role'] == 'AFM1' || $_SESSION['MM_duty_role'] == 'AFM2' || $_SESSION['MM_duty_role'] == 'FM1' || $_SESSION['MM_duty_role'] == 'FM2' ) {
} ELSE {
  $updateGoTo = "pgc_field_duty_not_AFM_msg.php";
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<?php

mysql_select_db($database_PGC, $PGC);
$query_ActiveSession = "SELECT fd_session, session_active, session_start_date, session_end_date FROM pgc_field_duty_control WHERE session_active = 'Y'";
$ActiveSession = mysql_query($query_ActiveSession, $PGC) or die(mysql_error());
$row_ActiveSession = mysql_fetch_assoc($ActiveSession);
$totalRows_ActiveSession = mysql_num_rows($ActiveSession);

$_SESSION['fd_active_session'] = $row_ActiveSession['fd_session'];
$session_start = $row_ActiveSession['session_start_date'];
$session_end = $row_ActiveSession['session_end_date'];
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


// Save Update For Session 1
$FD_change_1 = 'NO';
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") ) {
  
  if ($_SESSION['S1active'] =='Y') {
	if ($_SESSION['$s1d1'] <> GetSQLValueString($_POST['choice1-1'], "date") OR $_SESSION['$s1d2'] <> GetSQLValueString($_POST['choice1-2'], "date") OR $_SESSION['$s1d3'] <> GetSQLValueString($_POST['choice1-3'], "date")) {

  $FD_change_1 = 'YES';
				
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET modified_date = now(), modified_by = %s, choice1=%s, choice2=%s, choice3=%s WHERE session='1' AND member_id=%s",
                       GetSQLValueString($session_pilotname, "text"),
			     GetSQLValueString($_POST['choice1-1'], "date"),
                       GetSQLValueString($_POST['choice1-2'], "date"),
                       GetSQLValueString($_POST['choice1-3'], "date"),
			     GetSQLValueString($_SESSION['MM_Username'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  
	//Save Copy of Record in Audit TableRecord
	$updateSQL = sprintf("INSERT INTO pgc_field_duty_selections_audit (key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count) SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count from pgc_field_duty_selections WHERE session='1' AND member_id=%s",
								     GetSQLValueString($_SESSION['MM_Username'], "text"));
	
	mysql_select_db($database_PGC, $PGC);
	$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
   }
  }
  
  // Save Update For Session 2
  $FD_change_2 = 'NO';
  if ($_SESSION['S2active'] =='Y') {
	  if ($_SESSION['$s2d1'] <> GetSQLValueString($_POST['choice2-1'], "date") OR $_SESSION['$s2d2'] <> GetSQLValueString($_POST['choice2-2'], "date") OR $_SESSION['$s2d3'] <> GetSQLValueString($_POST['choice2-3'], "date")) {
		  
  $FD_change_2 = 'YES';
		  
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET modified_date = now(), modified_by = %s, choice1=%s, choice2=%s, choice3=%s WHERE session='2' AND member_id=%s",
                       GetSQLValueString($session_pilotname, "text"),
			     GetSQLValueString($_POST['choice2-1'], "date"),
                       GetSQLValueString($_POST['choice2-2'], "date"),
                       GetSQLValueString($_POST['choice2-3'], "date"),
			     GetSQLValueString($_SESSION['MM_Username'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  
  	//Save Copy of Record in Audit TableRecord
	$updateSQL = sprintf("INSERT INTO pgc_field_duty_selections_audit (key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count) SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count from pgc_field_duty_selections WHERE session='2' AND member_id=%s",
								     GetSQLValueString($_SESSION['MM_Username'], "text"));
	
	mysql_select_db($database_PGC, $PGC);
	$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  }
   }
  
    // Save Update For Session 3
  $FD_change_3 = 'NO';
  if ($_SESSION['S3active'] =='Y') {
	  if ($_SESSION['$s3d1'] <> GetSQLValueString($_POST['choice3-1'], "date") OR $_SESSION['$s3d2'] <> GetSQLValueString($_POST['choice3-2'], "date") OR $_SESSION['$s3d3'] <> GetSQLValueString($_POST['choice3-3'], "date")) {
		  
  $FD_change_3 = 'YES';
  $updateSQL = sprintf("UPDATE pgc_field_duty_selections SET modified_date = now(), modified_by = %s, choice1=%s, choice2=%s, choice3=%s WHERE session='3' AND member_id=%s",
                       GetSQLValueString($session_pilotname, "text"),
			     GetSQLValueString($_POST['choice3-1'], "date"),
                       GetSQLValueString($_POST['choice3-2'], "date"),
                       GetSQLValueString($_POST['choice3-3'], "date"),
			     GetSQLValueString($_SESSION['MM_Username'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  
  	//Save Copy of Record in Audit TableRecord
	$updateSQL = sprintf("INSERT INTO pgc_field_duty_selections_audit (key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count) SELECT key_check, member_id, member_name, fd_role, `session`, choice1, choice2, choice3, choice_status, date_selected, modified_by,      modified_date, modify_ip, delete_record, selected_count from pgc_field_duty_selections WHERE session='3' AND member_id=%s",
								     GetSQLValueString($_SESSION['MM_Username'], "text"));
	
	mysql_select_db($database_PGC, $PGC);
	$Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  }
  }
   
   
 $member_email = $session_email;
 $emaillog =  $session_email   . "\n"; 
 $emaillog .= $session_pilotname . "\n";
 $emaillog .= "\n";  
 $emaillog .= "====================================" . "\n"; 
 $emaillog .= "       YOUR CURRENT FIELD DUTY SELECTIONS         " . "\n"; 
 $emaillog .= "====================================" . "\n\n"; 
 if ($_SESSION['S1active'] =='Y') {
 $emaillog .= "          Session 1 - Choice 1:  " . $_POST['choice1-1'] . "\n";
 $emaillog .= "          Session 1 - Choice 2:  " . $_POST['choice1-2'] . "\n";
 $emaillog .= "          Session 1 - Choice 3:  " . $_POST['choice1-3'] . "\n";
 $emaillog .= "\n";
 }
 if ($_SESSION['S2active'] =='Y') {
 $emaillog .= "          Session 2 - Choice 1:  " . $_POST['choice2-1'] . "\n";
 $emaillog .= "          Session 2 - Choice 2:  " . $_POST['choice2-2'] . "\n";
 $emaillog .= "          Session 2 - Choice 3:  " . $_POST['choice2-3'] . "\n";
 $emaillog .= "\n";
 }
 if ($_SESSION['S3active'] =='Y') {
 $emaillog .= "          Session 3 - Choice 1:  " . $_POST['choice3-1'] . "\n";
 $emaillog .= "          Session 3 - Choice 2:  " . $_POST['choice3-2'] . "\n";
 $emaillog .= "          Session 3 - Choice 3:  " . $_POST['choice3-3'] . "\n";
 $emaillog .= "\n";
 }
 $emaillog .= "====================================". "\n"; 
 $emaillog .= "\n";
 $emaillog .= "  Contact Ken Kochanski (kilokilo@verizon.net)". "\n"; 
 $emaillog .= "       if you did not make these selections.      ". "\n"; 
   
/* echo $emaillog;  */
 
 $to = $member_email . ", kilokilo@verizon.net, slsnite@comcast.net";
 $subject = "PGC Field Duty Selections";
 // Always set content-type when sending HTML email
 /*$headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n"; */
 $from = "PGC-DataPortal@noreply.com";
 $from = "kilokilo@verizon.net";
 $headers = "From: $from";
 mail($to,$subject,$emaillog,$headers); 

  $updateGoTo = "../07_members_only_pw.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_MemberSelections = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_MemberSelections = $_SESSION['MM_Username'];
}


mysql_select_db($database_PGC, $PGC);
$query_MemberSelections = sprintf("SELECT * FROM pgc_field_duty_selections WHERE member_id = %s AND session = 1", GetSQLValueString($colname_MemberSelections, "text") );
$MemberSelections = mysql_query($query_MemberSelections, $PGC) or die(mysql_error());
$row_MemberSelections = mysql_fetch_assoc($MemberSelections);
$totalRows_MemberSelections = mysql_num_rows($MemberSelections);
// Save Database Date Selections
$_SESSION['$s1d1'] = GetSQLValueString($row_MemberSelections['choice1'], "date");
$_SESSION['$s1d2'] = GetSQLValueString($row_MemberSelections['choice2'], "date");
$_SESSION['$s1d3'] = GetSQLValueString($row_MemberSelections['choice3'], "date");
 

mysql_select_db($database_PGC, $PGC);
$query_MemberSelections2 = sprintf("SELECT * FROM pgc_field_duty_selections WHERE member_id = %s AND session = 2", GetSQLValueString($colname_MemberSelections, "text") );
$MemberSelections2 = mysql_query($query_MemberSelections2, $PGC) or die(mysql_error());
$row_MemberSelections2 = mysql_fetch_assoc($MemberSelections2);
$totalRows_MemberSelections2 = mysql_num_rows($MemberSelections2); 
// Save Database Date Selections
$_SESSION['$s2d1'] = GetSQLValueString($row_MemberSelections2['choice1'], "date");
$_SESSION['$s2d2'] = GetSQLValueString($row_MemberSelections2['choice2'], "date");
$_SESSION['$s2d3'] = GetSQLValueString($row_MemberSelections2['choice3'], "date");

mysql_select_db($database_PGC, $PGC);
$query_MemberSelections3 = sprintf("SELECT * FROM pgc_field_duty_selections WHERE member_id = %s AND session = 3", GetSQLValueString($colname_MemberSelections, "text") );
$MemberSelections3 = mysql_query($query_MemberSelections3, $PGC) or die(mysql_error());
$row_MemberSelections3 = mysql_fetch_assoc($MemberSelections3);
$totalRows_MemberSelections3 = mysql_num_rows($MemberSelections3); 
// Save Database Date Selections
$_SESSION['$s3d1'] = GetSQLValueString($row_MemberSelections3['choice1'], "date");
$_SESSION['$s3d2'] = GetSQLValueString($row_MemberSelections3['choice2'], "date");
$_SESSION['$s3d3'] = GetSQLValueString($row_MemberSelections3['choice3'], "date");

mysql_select_db($database_PGC, $PGC);
$query_FDsession1 = "SELECT session_active FROM pgc_field_duty_control WHERE fd_session = '1'";
$FDsession1 = mysql_query($query_FDsession1, $PGC) or die(mysql_error());
$row_FDsession1 = mysql_fetch_assoc($FDsession1);
$_SESSION['S1active'] = $row_FDsession1['session_active'];

mysql_select_db($database_PGC, $PGC);
$query_FDsession2 = "SELECT session_active FROM pgc_field_duty_control WHERE fd_session = '2'";
$FDsession2 = mysql_query($query_FDsession2, $PGC) or die(mysql_error());
$row_FDsession2 = mysql_fetch_assoc($FDsession2);
$_SESSION['S2active'] = $row_FDsession2['session_active'];

mysql_select_db($database_PGC, $PGC);
$query_FDsession3 = "SELECT session_active FROM pgc_field_duty_control WHERE fd_session = '3'";
$FDsession3 = mysql_query($query_FDsession3, $PGC) or die(mysql_error());
$row_FDsession3 = mysql_fetch_assoc($FDsession3);
$_SESSION['S3active'] = $row_FDsession3['session_active'];
 
// Flag Wednesdays as not selectable 

mysql_select_db($database_PGC, $PGC);
$query_FD = "UPDATE pgc_field_duty SET fd_type = 'weekend'";
$FD = mysql_query($query_FD, $PGC) or die(mysql_error());
 
mysql_select_db($database_PGC, $PGC);
$query_FD = "UPDATE pgc_field_duty SET fd_type = 'midweek' WHERE date_format(date,'%W') = 'Wednesday'";
$FD = mysql_query($query_FD, $PGC) or die(mysql_error());

// Select Available Field Duty Dates 
$query_fd_datesforsession1 = ("SELECT `date` FROM pgc_field_duty WHERE fd_type <> 'midweek' AND `session` = 99"); 
mysql_select_db($database_PGC, $PGC);
if ($_SESSION['S1active'] =='Y') { 

   $query_fd_datesforsession1 = sprintf("SELECT `date` FROM pgc_field_duty WHERE fd_type <> 'midweek' AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('1', "text"));

   If ($_SESSION['MM_duty_role'] == 'FM1' || $_SESSION['MM_duty_role'] == 'FM2' ) {
      $query_fd_datesforsession1 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND fm_count IS NULL OR fm_count < 1) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('1', "text")); 
   }
   If ($_SESSION['MM_duty_role'] == 'AFM1' || $_SESSION['MM_duty_role'] == 'AFM2' ) {
      $query_fd_datesforsession1 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND afm_count IS NULL OR afm_count < 3 ) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('1', "text")); 
   }

}

$fd_datesforsession1 = mysql_query($query_fd_datesforsession1, $PGC) or die(mysql_error());
$row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1);
$totalRows_fd_datesforsession1 = mysql_num_rows($fd_datesforsession1);

 
$query_fd_datesforsession2 = ("SELECT `date` FROM pgc_field_duty WHERE fd_type <> 'midweek' AND `session` = 99");
mysql_select_db($database_PGC, $PGC);
if ($_SESSION['S2active'] =='Y') {
	
$query_fd_datesforsession2 = sprintf("SELECT `date` FROM pgc_field_duty WHERE fd_type <> 'midweek' AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('2', "text"));

   If ($_SESSION['MM_duty_role'] == 'FM1' || $_SESSION['MM_duty_role'] == 'FM2' ) {
      $query_fd_datesforsession2 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND fm_count IS NULL OR fm_count < 1) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('2', "text")); 
   }
   If ($_SESSION['MM_duty_role'] == 'AFM1' || $_SESSION['MM_duty_role'] == 'AFM2' ) {
      $query_fd_datesforsession2 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND afm_count IS NULL OR afm_count < 3 ) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('2', "text")); 
   }

}
$fd_datesforsession2 = mysql_query($query_fd_datesforsession2, $PGC) or die(mysql_error());
$row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2);
$totalRows_fd_datesforsession2 = mysql_num_rows($fd_datesforsession2);

$query_fd_datesforsession3 = ("SELECT `date` FROM pgc_field_duty WHERE fd_type <> 'midweek' AND `session` = 99");
mysql_select_db($database_PGC, $PGC);
if ($_SESSION['S3active'] =='Y') { 

$query_fd_datesforsession3 = sprintf("SELECT `date` FROM pgc_field_duty WHERE  fd_type <> 'midweek' AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('3', "text"));

   If ($_SESSION['MM_duty_role'] == 'FM1' || $_SESSION['MM_duty_role'] == 'FM2' ) {
      $query_fd_datesforsession3 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND fm_count IS NULL OR fm_count < 1) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('3', "text")); 
   }
   If ($_SESSION['MM_duty_role'] == 'AFM1' || $_SESSION['MM_duty_role'] == 'AFM2' ) {
      $query_fd_datesforsession3 = sprintf("SELECT `date` FROM pgc_field_duty WHERE (fd_type <> 'midweek' AND afm_count IS NULL OR afm_count < 3 ) AND `session` = %s ORDER BY `date` ASC", GetSQLValueString('3', "text")); 
   }

}
$fd_datesforsession3 = mysql_query($query_fd_datesforsession3, $PGC) or die(mysql_error());
$row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3);
$totalRows_fd_datesforsession3 = mysql_num_rows($fd_datesforsession3);

mysql_select_db($database_PGC, $PGC);
$query_FDsessions = "SELECT fd_session, session_start_date, session_end_date, session_active, modified_by, modified_date FROM pgc_field_duty_control ORDER BY fd_session ASC";
$FDsessions = mysql_query($query_FDsessions, $PGC) or die(mysql_error());
$row_FDsessions = mysql_fetch_assoc($FDsessions);
$totalRows_FDsessions = mysql_num_rows($FDsessions);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script src="../java/javascripts.js" type="text/javascript"></script>
<script src="../java/CalendarPopup.js" type="text/javascript"></script>
<script src="../java/zxml.js" type="text/javascript"></script>
<script src="../java/workingjs.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" ID="js1">
		var cal = new CalendarPopup();
</SCRIPT>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #283664;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {
	color: #EFEFEF;
	font-size: 14px;
}
a:link {	color: #E6E3DF;
}
a:visited {
	color: #E6E3DF;}
a:active {
	color: #FFFFCC;
}
.style19 {
	color: #D6D6D6;
	font-weight: bold;
}
.style20 {	font-size: 16px;
	font-weight: bold;
	color: #FFCCCC;
}
.style24 {font-size: 16px; font-weight: bold; color: #CCCCCC; }
.style28 {font-size: 12px}
.style23 {font-size: 16px; font-weight: bold; color: #FFCCCC; font-style: italic; }
.style44 {color: #999999;
	font-weight: bold;
}
.style32 {font-weight: bold; color: #000000; }
.style43 {font-size: 16px; }
#form1 table tr .style20
{
	color: #FFF;
}
.SessionTitles
{
	color: #000000;
	font-size: 14px;
}
.FDtext
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #000;
}
.style11 {font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
.style17 {	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
-->
</style></head>

<body>
<p>&nbsp;</p>
<table width="900" border="0" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="968"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="674" bgcolor="#3E3E5E"><table width="99%" height="670" border="0" align="center" cellpadding="5" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="25" bgcolor="#424A66"><div align="center">
            <table width="99%" border="0" cellspacing="2" cellpadding="2">
                <tr>
                      <td bgcolor="#333366"><div align="center"><span class="style24">FIELD DUTY - SELECT SESSION DUTY DAYS</span> (V2)</div></td>
                </tr>
                </table>
            </div></td>
      </tr>
      
      <tr>
        <td height="412" align="center" valign="middle" bgcolor="#424A66"><table width="800" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
              <tr>
                          <td width="291" height="30" align="center" valign="middle" bgcolor="#858CE9" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                          <td width="196" align="center" valign="middle" bgcolor="#858CE9" class="style32"><span class="style43"><?php echo $_SESSION['MM_duty_role']; ?></span>&nbsp;</td>
                          <td width="291" align="center" valign="middle" bgcolor="#858CE9" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                    </tr>
        </table>
              <table width="800" align="center" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                    <tr>
                          <td width="694" height="184" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43">
                                <table width="95%" cellspacing="5" cellpadding="5">
                                      <tr>
                                            <td align="center" bgcolor="#9CA3ED"><p class="FDtext">For each open session, please select three dates we can use to assign PGC field duty  ... only one choice for each session be used. You will receive an  e-mail documenting your selections.</p></td>
                                      </tr>
                                      <tr>
                                            <td height="29" align="center" bgcolor="#9CA3ED"><span class="FDtext">Please make your selections ASAP when the sessions are open to get your desired dates.  Although we can work with you to make the schedule work - member field duty choices are initially assigned on a first come basis based on when you enter or change your selections for a session.</span></td>
                                      </tr>
                                      <tr>
                                            <td height="61" align="center" bgcolor="#9CA3ED"><p class="FDtext">If you don't make a selection - we will make a choice  for you at the end of the session selection period.</p>
                                                  <p class="FDtext">Send an e-mail to Ken Kochanski (kilokilo@verizon.net)  if you have issues or questions.</p></td>
                                      </tr>
                                </table>
                                <table width="80%" border="0" cellpadding="2" cellspacing="2">
                                      <tr class="style43">
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><span class="style43"><span class="style43"><span class="SessionTitles">Session</span></span></span></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><span class="SessionTitles">Session Starts</span></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><span class="SessionTitles">Session Ends</span></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="SessionTitles">Session Selection Open</span></td>
                                      </tr>
                                      <?php do { ?>
                                      <tr>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><?php echo $row_FDsessions['fd_session']; ?></a></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><?php echo $row_FDsessions['session_start_date']; ?></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><?php echo $row_FDsessions['session_end_date']; ?></span></td>
                                            <td align="center" valign="middle" bgcolor="#5060EB"><span class="style16"><?php echo $row_FDsessions['session_active']; ?></span></td>
                                      </tr>
                                      <?php } while ($row_FDsessions = mysql_fetch_assoc($FDsessions)); ?>
                          </table>
                                <p class="style20"><span class="style16"><span class="FDtext">* Contact the Field Duty Manager via e-mail to make or change session selections - if the session is closed</span></span><span class="FDtext">.</span>                                
                                <p class="style20"><span class="FDtext">Go to the <a href="pgc_field_duty_list_only.php">Field Duty Schedule</a> to see available dates for FMs and AFMs </span>                                                                
                          </div></td>
                    </tr>
              </table>
              <p></p>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                    <table width="800" cellpadding="2" cellspacing="2">
                          <tr>
                                <td width="33%" height="37" align="center"><table width="260" cellpadding="2" cellspacing="2">
                                      <tr>
                                            <td colspan="2" align="center" bgcolor="#767EE7"><span class="FDtext">Session 1 Field Duty Selections</span></td>
                                      </tr>
                                      <tr>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16"> <span class="style19">Choice 1</span></span></td>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice1-1" id="choice1-1">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession1['date']?>"<?php if (!(strcmp($row_fd_datesforsession1['date'], $row_MemberSelections['choice1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession1['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1));
  $rows = mysql_num_rows($fd_datesforsession1);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession1, 0);
	  $row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 2</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice1-2" id="choice1-2">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession1['date']?>"<?php if (!(strcmp($row_fd_datesforsession1['date'], $row_MemberSelections['choice2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession1['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1));
  $rows = mysql_num_rows($fd_datesforsession1);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession1, 0);
	  $row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 3</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice1-3" id="choice1-3">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession1['date']?>"<?php if (!(strcmp($row_fd_datesforsession1['date'], $row_MemberSelections['choice3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession1['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1));
  $rows = mysql_num_rows($fd_datesforsession1);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession1, 0);
	  $row_fd_datesforsession1 = mysql_fetch_assoc($fd_datesforsession1);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                </table></td>
                                <td width="34%" align="center"><table width="260" cellpadding="2" cellspacing="2">
                                      <tr>
                                            <td colspan="2" align="center" bgcolor="#767EE7"><span class="FDtext">Session 2 Field Duty Selections</span></td>
                                      </tr>
                                      <tr>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 1:</span></span></td>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice2-1" id="choice2-1">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession2['date']?>"<?php if (!(strcmp($row_fd_datesforsession2['date'], $row_MemberSelections2['choice1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession2['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2));
  $rows = mysql_num_rows($fd_datesforsession2);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession2, 0);
	  $row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"> <span class="style19">Choice 2</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice2-2" id="choice2-2">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession2['date']?>"<?php if (!(strcmp($row_fd_datesforsession2['date'], $row_MemberSelections2['choice2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession2['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2));
  $rows = mysql_num_rows($fd_datesforsession2);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession2, 0);
	  $row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 3</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice2-3" id="choice6">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession2['date']?>"<?php if (!(strcmp($row_fd_datesforsession2['date'], $row_MemberSelections2['choice3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession2['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2));
  $rows = mysql_num_rows($fd_datesforsession2);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession2, 0);
	  $row_fd_datesforsession2 = mysql_fetch_assoc($fd_datesforsession2);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                </table></td>
                                <td width="33%" align="center"><table width="260" cellpadding="2" cellspacing="2">
                                      <tr>
                                            <td colspan="2" align="center" bgcolor="#767EE7"><span class="FDtext">Session 3 Field Duty Selections</span></td>
                                      </tr>
                                      <tr>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 1:</span></span></td>
                                            <td width="50%" bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice3-1" id="choice2-5">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession3['date']?>"<?php if (!(strcmp($row_fd_datesforsession3['date'], $row_MemberSelections3['choice1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession3['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3));
  $rows = mysql_num_rows($fd_datesforsession3);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession3, 0);
	  $row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"> <span class="style19">Choice 2</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice3-2" id="choice3-2">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession3['date']?>"<?php if (!(strcmp($row_fd_datesforsession3['date'], $row_MemberSelections3['choice2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession3['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3));
  $rows = mysql_num_rows($fd_datesforsession3);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession3, 0);
	  $row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                      <tr>
                                            <td bgcolor="#767EE7"><span class="style16"><span class="style19">Choice 3</span></span></td>
                                            <td bgcolor="#767EE7"><span class="style16">
                                                  <select name="choice3-3" id="choice2-3">
                                                        <?php
do {  
?>
                                                        <option value="<?php echo $row_fd_datesforsession3['date']?>"<?php if (!(strcmp($row_fd_datesforsession3['date'], $row_MemberSelections3['choice3']))) {echo "selected=\"selected\"";} ?>><?php echo $row_fd_datesforsession3['date']?></option>
                                                        <?php
} while ($row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3));
  $rows = mysql_num_rows($fd_datesforsession3);
  if($rows > 0) {
      mysql_data_seek($fd_datesforsession3, 0);
	  $row_fd_datesforsession3 = mysql_fetch_assoc($fd_datesforsession3);
  }
?>
                                                  </select>
                                            </span></td>
                                      </tr>
                                </table></td>
                          </tr>
                          <tr>
                                <td height="46">&nbsp;</td>
                                <td align="center"><input type="submit" value="Save Choices" /></td>
                                <td>&nbsp;</td>
                          </tr>
                    </table>
                    <p>
                          <input type="hidden" name="MM_update" value="form1" />
                          <input type="hidden" name="member_id" value="<?php echo $row_MemberSelections['member_id']; ?>" />
  </p>
              </form>
        
      </td>
      </tr>
      <tr>
            <td align="center" bgcolor="#424A66"><a href="../07_members_only_pw.php" class="style17"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></td>
      </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($MemberSelections);

mysql_free_result($ActiveSession);
?>
