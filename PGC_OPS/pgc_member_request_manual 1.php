<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
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
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
.style19 {color: #CCCCCC; font-size: 14; }
.style20 {color: #CCCCCC; font-weight: bold; font-size: 14; }
.style128 {
	color: #FF0000;
	font-size: 18px;
	font-weight: bold;
	font-style: italic;
}
.style129 {color: #FFCC00; font-weight: bold; font-size: 14; }
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PDP Member Instruction Request - User Manual (v1.00) </span></div></td>
  </tr>
  <tr>
    <td height="476"><table width="92%" height="456" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#41435A">
      <tr>
          <td height="36"><blockquote>
              <p align="center" class="style128">**** DRAFT IN DEVELOPMENT **** </p>
              <p class="style19"><strong><u>I. INTRO</u></strong></p>
              <p class="style20">The PDP Member Instruction Request system was developed for the 2011 season to support member requests for CFIG instruction services. The web-based app was designed to assist the work performed by the Flight Instruction Coordinator - currently Joe Beyer.</p>
              <p class="style20">The Member Enter / Modify Request screen is the entry point for all member functions. </p>
              <blockquote>
                <p class="style20">Members can see all requests submitted by all members - and CFIG Assignments as they occur.</p>
                <p class="style20">Members can display the CFIG off-duty  calendar to see if the desired CFIG  is available on the  instruction day. </p>
                <p class="style20">Members can  enter a new request - or edit their own requests  if no CFIG has been assigned. </p>
                <p class="style20"><img src="/FligntLog Tutorial/Request Screen - Member.jpg" alt="Member" width="700" height="245" /></p>
                </blockquote>
              <p align="left" class="style20">A new  instruction request  requires   no text entry - all critical fields are  populated using drop-down menus.</p>
              <p align="left" class="style20">One optional freeform field lets the member enter a  small note  related to the requested instruction.</p>
              <p align="center" class="style20"><img src="/FligntLog Tutorial/Request New - Member.jpg" alt="New" width="700" height="401" /></p>
              <p class="style20">All saved requests are immediately stored in the PDP database - and email messages with all request information are immediately sent to the member - and requested CFIGs - if CFIGs are selected. (See sample email section at the end of this manual.) </p>
              <blockquote>
                <p class="style20">Requested CFIGs may not be available on the request date - and  selected CFIGs will show up in a red highlighted cell on the main Member Enter / Modify Request screen. </p>
                <blockquote>
                  <p class="style20"> CFIGs have to update the CFIG  calendar with their unavailable dates to support this feature. </p>
                </blockquote>
              </blockquote>
              <p class="style20">The Request Modify Screen can be used to edit all information entered in the original request - except the Request Instruction Date. </p>
              <blockquote>
                <p class="style20"><img src="/FligntLog Tutorial/Request Edit - Member.jpg" alt="Edit" width="700" height="408" /></p>
              </blockquote>
              <p class="style20">The member can change or delete the request - up until the CFIG Instruction team assigns an instructor.</p>
              <blockquote>
                <p class="style20">The system will immediately send emails to the member and requested CFIGs to advise of the member initiated change or deletion. </p>
                <p class="style129">Request dates cannot be edited - the member will have to delete the original request and enter a new request if the desired instruction date has to be changed. </p>
                <p class="style129"> The member will have to contact the CFIG assigned or Flight Instruction Coordinator to change the request if a CFIG has been assigned. i.e. the system will not allow the member to edit these records.</p>
              </blockquote>
              <p class="style20">Ongoing student members can and should discuss scheduling future training dates with their current CFIGs. The student can then enter the discussed instruction dates into the system - and the CFIG can accept the request as discussed. </p>
              <blockquote>
                <p class="style20">The system will only accept requests for scheduled flight operations days - up to a maximum of a week in advance. The request date drop-down list will only contain the next two (or three if the week contains a holiday ) available instruction days.</p>
              </blockquote>
              <p class="style20">New PGC members or  students can request CFIGs - or leave the request CFIG fields blank -  and the CFIG team will assign a CFIG for the requested date. </p>
              <p class="style20">All instruction records are listed in the request summary by date - and then by entry order.  </p>
              <p class="style20">Records are deleted from the main  display when the request date is passed. i.e. the summary shows only the current and upcoming request dates. </p>
              <p class="style20">II. E-MAIL SAMPLES </p>
              <p class="style129"> A. Member Request Email - Sent to member ... and CFIG1 and CFIG2 ... if they are selected. </p>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <p class="style20">Kochanski, Ken<br />
                        <br />
                        &nbsp;Your instruction request was entered as indicated   below.<br />
                        <br />
                        Member - New Instruction   Request<br />
                        =========================<br />
                        Request Number:&nbsp;&nbsp; 5<br />
                        Member Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Kochanski, Ken<br />
                        Date Requested:&nbsp;&nbsp; 2011-04-09<br />
                        Request Type:&nbsp;&nbsp;&nbsp;&nbsp; Annual Check   Ride<br />
                        Request Notes:&nbsp;&nbsp;&nbsp; Also need BFR<br />
                        Member Weight:&nbsp;&nbsp;&nbsp; 220<br />
                        CFIG 1   Requested: Klauder, Phil<br />
                        CFIG 2 Requested: Jones, Phil<br />
                        CFIG   Assigned:<br />
                        CFIG Notes:<br />
                        Record Deleted?:&nbsp; N<br />
                        <br />
                        This record was entered   by ... Kochanski, Ken<br />
                        <br />
                        <br />
                        Email List: <br />
                      <a href="mailto:support@pgcsoaring.org,phil.klauder@verizon.net,pjones45@mac.com,support@pgcsoaring.org">support@pgcsoaring.org,</a><a href="mailto:support@pgcsoaring.org,phil.klauder@verizon.net,pjones45@mac.com,support@pgcsoaring.org">phil.klauder@verizon.net,</a></p>
                      <p class="style20"><a href="mailto:support@pgcsoaring.org,phil.klauder@verizon.net,support@pgcsoaring.org">support@pgcsoaring.org</a></p>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
              <p class="style20"><span class="style129">B. CFIG Assigned  Email - Sent to member,  CFIG1, CFIG2 and assigned CFIG.</span></p>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <p class="style20">Salemi, Alexandre<br />
                        <br />
&nbsp;The CFIG Team assigned an instructor for your request as   indicated below.<br />
                        <br />
                        Instruction Request<br />
                        ================<br />
                        CFIG   ASSIGNED:&nbsp;&nbsp;&nbsp; Klauder, Phil&nbsp;&nbsp; <a href="mailto:phil.klauder@verizon.net">phil.klauder@verizon.net</a><br />
                        <br />
                        Request   Number:&nbsp;&nbsp; 2<br />
                        Member Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salemi, Alexandre<br />
                        Date Requested:&nbsp;&nbsp;   2011-04-03<br />
                        Request Type:&nbsp;&nbsp;&nbsp;&nbsp; Annual Check Ride<br />
                        Request Notes:<br />
                        Member   Weight:<br />
                        CFIG 1 Requested: Ingram, Ed<br />
                        CFIG 2 Requested: Klauder,   Phil<br />
                        CFIG Notes:<br />
                        Record Deleted?:&nbsp; N<br />
                        <br />
                        CFIG assigned by ...   Kochanski, Ken<br />
                        <br />
                        <br />
                        Email List: <br />
                      <a href="mailto:alexandre.salemi@gmail.com,phil.klauder@verizon.net,onetwohotel@dejazzd.com,support@pgcsoaring.org">alexandre.salemi@gmail.com, phil.klauder@verizon.net, onetwohotel@dejazzd.com, support@pgcsoaring.org</a></p>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
              <p class="style20"><span class="style129">B. Member Modified Request -  Sent to member,  CFIG1, CFIG2 and assigned CFIG.</span></p>
              <blockquote>
                <blockquote>
                  <blockquote>
                    <blockquote>
                      <p class="style20">Kochanski, Ken<br />
                        <br />
                        &nbsp;You modified your instruction request as indicated   below.<br />
                        <br />
                        &nbsp;Request CFIG 1 was changed TO ... Giannini, Matt ... FROM ... Klauder, Phil<br />
                        <br />
                        Current Instruction   Request<br />
                        ====================<br />
                        Request Number:&nbsp;&nbsp; 5<br />
                        Member Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   Kochanski, Ken<br />
                        Date Requested:&nbsp;&nbsp; 2011-04-09<br />
                        Request Type:&nbsp;&nbsp;&nbsp;&nbsp; Annual Check   Ride<br />
                        Request Notes:&nbsp;&nbsp;&nbsp; Also need BFR<br />
                        Member Weight:&nbsp;&nbsp;&nbsp; 220<br />
                        CFIG 1   Requested: Giannini, Matt<br />
                        CFIG 2 Requested: Jones, Phil<br />
                        CFIG   Assigned:<br />
                        CFIG Notes:<br />
                        Record Deleted?:&nbsp; N<br />
                        <br />
                        &nbsp;This record was updated   by ... Kochanski, Ken<br />
                        <br />
                        <br />
                        Email List: <br />
                        <a href="mailto:support@pgcsoaring.org,mattg123@verizon.net,pjones45@mac.com,support@pgcsoaring.org">support@pgcsoaring.org, mattg123@verizon.net ,pjones45@mac.com,support@pgcsoaring.org</a><br />
                        <br />
                        <br />
                      </p>
                    </blockquote>
                  </blockquote>
                </blockquote>
              </blockquote>
          </blockquote>              </td>
      </tr>
      
      <tr>
        <td height="37" align="center" valign="top"><strong class="style11"><a href="../07_members_only_pw.php" class="style16">Back to Members Page</a></strong></td>
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