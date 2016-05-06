<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
session_start();
//require_once('pgc_check_login_admin.php'); 
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$date = date("Y-m-d H:i:s");
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE IGNORE pgc_pilot_signoffs SET signoff_type=%s, signoff_date=%s, instructor=%s, delete_record=%s, modified_by=%s, modified_date=%s WHERE signoffID=%s",
                       GetSQLValueString($_POST['signoff_type'], "text"),
                       GetSQLValueString($_POST['signoff_date'], "date"),
                       GetSQLValueString($_POST['instructor'], "text"),
                       GetSQLValueString($_POST['delete_record'], "text"),
					   GetSQLValueString($_SESSION['MM_PilotName'], "text"),
					   GetSQLValueString($date, "date"),
                       GetSQLValueString($_POST['signoffID'], "int"));
					  					  

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
  //$updateGoTo = 'http://www.pgcsoaring.org'.$_SESSION[last_query];
  $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSignoffs = "-1";
if (isset($_GET['signoffID'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_GET['signoffID'] : addslashes($_GET['signoffID']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs WHERE signoffID = %s", $colname_rsSignoffs);
$rsSignoffs = mysql_query($query_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);
$totalRows_rsSignoffs = mysql_num_rows($rsSignoffs);

mysql_select_db($database_PGC, $PGC);
$query_rsSignoffType = "SELECT description FROM pgc_signoff_types ORDER BY sort_order ASC";
$rsSignoffType = mysql_query($query_rsSignoffType, $PGC) or die(mysql_error());
$row_rsSignoffType = mysql_fetch_assoc($rsSignoffType);
$totalRows_rsSignoffType = mysql_num_rows($rsSignoffType);

mysql_select_db($database_PGC, $PGC);
$query_rsInstructors = "SELECT Name FROM pgc_instructors";
$rsInstructors = mysql_query($query_rsInstructors, $PGC) or die(mysql_error());
$row_rsInstructors = mysql_fetch_assoc($rsInstructors);
$totalRows_rsInstructors = mysql_num_rows($rsInstructors);
?>
<?php 
// echo $_SESSION[last_query]; 
// $updateGoTo = "pgc_list_signoffs_select.php";
?>

<?php
require_once('pgc_signoff_table_updates.php')
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Flight Sheet User Manual</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #333333;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style16 {
	color: #CCCCCC;
	font-size: 18px;
}
a:link {
	color: #FFFF99;
}
.style19 {color: #CCCCCC; font-size: 14; }
.style23 {color: #C4CDE3; font-weight: bold; font-style: italic; }
.style31 {color: #00CC33}
.style32 {color: #FF0000}
.style36 {color: #FFFF66}
.style127 {font-size: 16}
.style130 {font-size: 18px; }
.style131 {color: #C4CDE3; font-weight: bold; font-style: italic; font-size: 18px; }
.style133 {font-size: 18px; color: #FFFFFF; }
.style134 {
	color: #FF9900;
	font-weight: bold;
}
.style135 {color: #FFFFFF; font-weight: bold; font-style: italic; font-size: 18px; }
.style136 {color: #FFFFFF; font-weight: bold; font-style: italic; }
.style137 {color: #FFFFFF}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PDP Flight Sheet - HELP</span></div></td>
  </tr>
  <tr>
    <td height="1364"><table width="92%" height="456" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#41435A">
      <tr>
          <td height="36"><blockquote>
              <p class="style19">&nbsp;</p>
              </blockquote>
              <blockquote>
                  <p align="left" class="style130"><strong><u><span class="style137">Q<strong>UICK START HELP </strong></span></u></strong></p>
                  <ol class="style127"><li class="style23"><p class="style133">The <span class="style134"><u>ADD ROW</u></span> button is hit on the main screen to create a new  blank row on the main flightlog screen.</p>
                      </li>
                      <li class="style23">
                          <p class="style133">The new record is edited in the Detail Screen:  Glider, Member Charged and Instructor are added  to the record using the appropriate  dropdowns. The record is typically saved (updated) at this time.</p>
                      </li>
                      <li class="style23">
                          <p class="style133">  A PGC Flight Sheet record is considered 'official' by  the system when a Charged Member and/or Instructor is entered - and Takeoff and  Landing times are recorded.&nbsp; A record on  the main page that does not have a Member Charged or Instructor entry is not  considered a valid record for any billing or reporting process.</p>
                      </li>
                      <li class="style23">
                          <p class="style133">Put blanks in the Member  Charged and Instructor fields to logically delete a record. </p>
                      </li>
                      <li class="style23">
                          <p class="style135"> AOF TYPE </p>
                          <ul class="style130">
                              <li class="style136">If the PGC AOF Pilot is not a CFIG, put their name in the Member column. (Example - Bob Lacovara) </li>
                              <li class="style136">If the PGC AOF Pilot is a CFIG, put their name in the Instructor Column - and put AOF in the member column. (Example - Jack Goritski)</li>
                              <li class="style136">A note is not required as the type indicates it is an AOF. </li>
                          </ul>
                          <p align="center" class="style23"><span class="style130"><img src="../FligntLog Tutorial/AOF Entries.jpg" alt="LOG" width="504" height="79" /></span></p>
                      </li>
                      <li class="style23">
                          <p class="style133">A NEW MEMBER  - Some very new members may not be in the PDP. Select 'A New Member' as the member name. We will update to the proper member name later in the week.</p>
                      </li>
                      <li class="style23">
                          <p class="style133"> A DEMO FLIGHT - Use this as the member name for any other flight that should not be charged to a member. We will research and update later in the week. Enter a note with details. </p>
                      </li>
                      <li class="style23">
                          <p class="style133">Tow Pilot and Tow Plane can be added at any time  using the appropriate drop-downs. The last Tow Pilot and Plane selected are  also saved by the system and are used as the default for future entries.</p>
                      </li>
                      <li class="style23">
                          <p class="style133">The <span class="style31">GREEN</span> Takeoff button on the main page is selected to auto-enter the takeoff time for  that flight as it occurs.</p>
                      </li>
                      <li class="style23">
                          <p class="style133">The <span class="style32">RED</span> Landing button on the main page is selected to auto-enter the  landing time as it occurs. This will auto-generate a flight receipt  email to the member. </p>
                      </li>
                      <li class="style23">
                          <p class="style133">The  tow altitude is typically updated at some  later time when the pilot reports to the flight desk. (Although they may not - which is why the flight receipt  email is sent when the landing time is entered by the flight desk.)</p>
                      </li>
                      <li class="style23">
                          <p class="style133">T<em>ow altitude entry, and any other updates  made in the detail screen after the landing time is entered,  <span class="style36">will auto-generate</span> a follow up email of  flight details for the Member, Webmaster, and Treasurer.</em></p>
                      </li>
                  </ol>
                  <blockquote>
                      <p class="style131">&nbsp;</p>
                      </blockquote>
                  <p>&nbsp;</p>
                  </blockquote>              </td>
      </tr>
      
      <tr>
        <td height="37" align="center" valign="top"><a href="pgc_flightlog_list_edit.php" class="style16">Back to Flightsheet</a></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>

<?php
//
///* Also in pgc_modify_signoff_detail.php
//
///* Do Updates - Make this a function */
//mysql_select_db($database_PGC, $PGC);
//
///* Purge Deletions */
//$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
//$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
//
///* Set both dates to 0000-00-00 */
//$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to OK */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'OK'";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Expired-C' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//
///* Calc 90 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 90 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 90 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 730 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 365 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Month End Expiry */ 
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 365 Month End Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Not Valid' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-A' WHERE (A.expire_date < CURDATE()) AND B.expires = 'YES' AND B.group_id = 'A' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-B' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'B' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-C' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'C' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* NULL Non Expiring  */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = NULL WHERE A.signoff_type = B.description AND B.expires ='NO'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* UPDATE Pilot Ratings */
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = ''";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());


mysql_free_result($rsSignoffs);

mysql_free_result($rsSignoffType);

mysql_free_result($rsInstructors);
?>