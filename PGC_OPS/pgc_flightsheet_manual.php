<?php require_once('../Connections/PGC.php'); ?>
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
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
.style18 {color: #CCCCCC; font-weight: bold; }
.style19 {color: #CCCCCC; font-size: 14; }
.style20 {color: #CCCCCC; font-weight: bold; font-size: 14; }
.style21 {
	color: #FFFF99;
	font-weight: bold;
	font-style: italic;
}
.style22 {color: #6699FF}
.style23 {color: #C4CDE3; font-weight: bold; font-style: italic; }
.style25 {color: #FFFF66; font-weight: bold; font-size: 14; }
.style26 {color: #FFFF66; font-weight: bold; font-style: italic; }
.style27 {color: #FF9900}
.style28 {
	color: #0066FF;
	font-weight: bold;
}
.style29 {
	color: #00CC00;
	font-weight: bold;
}
.style30 {
	color: #FF0000;
	font-weight: bold;
}
.style31 {color: #00CC33}
.style32 {color: #FF0000}
.style33 {color: #FFCC33}
.style34 {color: #FF6600}
.style35 {
	color: #FFFF66;
	font-style: italic;
}
.style36 {color: #FFFF66}
.style106 {font-family: Arial, Helvetica, sans-serif;
	color: #FFFF99;
	font-size: 10px;
}
.style122 {font-size: 12pt;
	font-weight: bold;
	color: #FFFFCC;
}
.style123 {color: #FFCCFF}
.style125 {color: #FBFACE; font-weight: bold; font-style: italic; }
.style126 {color: #FBFACE}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PDP Flight Sheet - User Manual (v1.00) </span></div></td>
  </tr>
  <tr>
    <td height="476"><table width="92%" height="456" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#41435A">
      <tr>
          <td height="36"><blockquote>
              <p class="style19"><strong><u>I. INTRO</u></strong></p>
              <p class="style20">The PDP Flight Sheet is a  web-based application developed to support PGC Flight Desk operations. The  application was developed using HTML/PHP and employs a MYSQL database to store  all information.&nbsp; </p>
              <p class="style20">The system requires  virtually no text entry - most fields are populated using drop-down menus;  real-time takeoff and landing times are auto-entered with a single mouse click;  a notes field has been provided to accept a small amount of freeform text information  about the flight, if required.<br />
                  &nbsp;<br />
                  All flight information flows  into the billing system and other reporting and control applications needed to  support ongoing PGC operations.&nbsp; Since  information integrity is vital, the system provides three levels of data redundency.</p>
              <blockquote>
                  <p class="style20"> 1/ All entered data is immediately stored  in a database on the host server.  </p>
                  <p class="style20">2/ The system supports semi-automatic creation of local flight records  (Excel worksheets populated with all flight activity up to that point in time) on the flight desk computer.</p>
                  <p class="style20"> 3/  Real-time receipt  emails for  each individual flight  are send to the PGC Member Charged,  Webmaster, and Treasurer.&nbsp;</p>
              </blockquote>
              <p class="style20"> These three levels of data storage provide excellent protection  and should  prevent information  loss even in the most extreme failure situations. </p>
              <p class="style20"><strong><u>STARTUP</u></strong></p>
              <p class="style20">The Flight Sheet application  is accessed through the PGC Members Page: an active ID and password is  required to start the program. Simply click on the following button to bring up  the main flight sheet page. </p>
          </blockquote>
              <table width="331" height="44" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#666666" bgcolor="#FFFF99">
                  <tr>
                      <td width="325" height="40" bgcolor="#009966"><div align="center" class="style122"><span class="style106"><a class="style122"><u>FLIGHT SHEET (FOR FLIGHT DESK USE ONLY)</u></a></span></div></td>
                  </tr>
              </table>
              <p align="center">&nbsp;</p>
              <blockquote>
                  <p align="left"><strong><u>II. Q<span class="style18">UICK START</span></u></strong></p>
                  <p class="style18">Experienced computer users  can typically jump in and immediately use the system as function is simple and any input mistakes or omissions are easily fixed.&nbsp; A typical example of anticipated use  follows:<br />
                      <span class="style22">&nbsp;</span></p>
                  <ol>
                      <li class="style23">
                          <p>The <span class="style27"><strong><u>ADD ROW</u></strong></span> button is hit on the main screen to create a new  blank row on the main flightlog screen.</p>
                      </li>
                      <li class="style23">
                          <p>The new record is edited in the Detail Screen:  Glider, Member Charged and Instructor are added  to the record using the appropriate  dropdowns. The record is typically saved (updated) at this time.</p>
                      </li>
                      <li class="style23">
                          <p>Tow Pilot and Tow Plane can be added at any time  using the appropriate drop-downs. The last Tow Pilot and Plane selected are  also saved by the system and are used as the default for future entries.</p>
                      </li>
                      <li class="style23">
                          <p>&nbsp;The <span class="style31">GREEN</span>  Takeoff button on the main page is selected to auto-enter the takeoff time for  that flight as it occurs.</p>
                      </li>
                      <li class="style23">
                          <p>The <span class="style32">RED</span> Landing button on the main page is selected to auto-enter the  landing time as it occurs. </p>
                      </li>
                      <li class="style23">
                          <p class="style35">A landing  time entry recorded  using the <span class="style32">RED</span> Landing Button is interpreted by the system as  the end of a valid flight.&nbsp; The system  will auto-generate and  immediately send an email receipt of flight details to the  Member Charged, Webmaster, and Treasurer.</p>
                      </li>
                      <li class="style23">
                          <p><em>&nbsp; </em> The actual tow altitude is typically updated at some  later time when the pilot reports to the flight desk. (Although they may not - which is why the flight receipt  email is sent when the landing time is entered by the flight desk.) </p>
                      </li>
                      <li class="style23">
                          <p><em>Tow altitude entry, and any other updates  made in the detail screen after the landing time is entered,  <span class="style36">will auto-generate</span> a follow up email of  flight details for the Member, Webmaster, and Treasurer.</em></p>
                          <ol>
                              <li> A PGC Flight Sheet record is considered 'official' by  the system when a Charged Member and/or Instructor is entered - and Takeoff and  Landing times are recorded.&nbsp; A record on  the main page that does not have a Member Charged or Instructor entry is not  considered a valid record for any billing or reporting process. i.e. putting blanks in the Member  Charged and Instructor fields acts as a logical delete.</li>
                          </ol>
                      </li>
                      </ol>
                  <blockquote>
                      <p class="style23">9. AOF Entries </p>
                      <ul>
                          <li class="style23">If the PGC AOF Pilot is not a CFIG, put their name in the Member column.</li>
                          <li class="style23">If the PGC AOF Pilot is a CFIG, put their name in the Instructor Column - and put AOF in the member column. (The system will do this automatically if you forget.) </li>
                      </ul>
                      
                      <p align="center" class="style23"><img src="../FligntLog Tutorial/AOF Entries.jpg" width="504" height="79" /></p>
                  </blockquote>
                  <p>&nbsp;</p>
                  <p><strong><u>III. DETAILED USER  PROCEDURES</u></strong></p>
                  <p class="style18"><strong><u>MAIN PAGE&nbsp; </u></strong></p>
                  <p class="style18">The  main page will be blank at the start of each day. The date defaults to the  current day - no date selection is possible or required.</p>
              </blockquote>
              <p align="center">&nbsp;</p>
              <p align="center" class="style18"><img src="../FlightSheet/FlightSheetMain.jpg" alt="FS" width="504" height="258" /></p>
              <blockquote>
                  <p class="style18">The  main page gives the flight desk an overview of all flight activity in a format  like a spreadsheet - the most recent flights will be listed at the top of the  sheet, as they typically require additional processing to complete. </p>
                  <p class="style18">The  main page displays flights and supports a number of additional  controls/functions. </p>
                  <p class="style20"><span class="style27"><strong><u>ADD ROW</u></strong>&nbsp;</span> - pops a new row onto the       top of the main sheet.&nbsp; This system       will initialize the record Key, Tow Altitude will default to 5000', Tow       Pilot and Tow Plane will default to the last tow resources used on a       flight record. The remaining fields will be blank, but can be updated in       the Detail Screen by clicking on the Key (left column) in the row. </p>
                  <p class="style20"><span class="style28"><u>XLS</u></span> - This button creates an Excel worksheet of all flights up to that point       in time on the Flight Desk Computer.&nbsp;       T<span class="style20">his 'backup' sheet should be generated approximately every five       flights five by flight desk.</span> This is a manually initiated process we let you run  when you have a lull in the operation  - just hit the XLS button when you have a minute to let the process complete. 'Save' the file when the File Download box appears. </p>
                  <p align="center" class="style20"><img src="../FlightSheet/Download.jpg" alt="Download" width="216" height="142" /></p>
              </blockquote>
              <ul type="disc">
                  <ul type="circle">
                      <li class="style18"><span class="style20">The last saved Excel worksheet can be        used to continue flight logging  activity if internet access is permenantly       lost. </span>(The system and network appear to  be very reliable, but  please create this Excel worksheet ~ every 5 flights minimum - you <u>will</u>  need it some day.) </li>
                      <li class="style18"><span class="style20">The sheets are stored in the        default download directory on the flight desk computer.</span></li>
                      <li class="style18"><span class="style20">Each  sheet saved  will        have a unique name constructed using the current date and time as follows:  YYYY-MM-DD(HHMM)<strong>-PGC-Flightsheet.xls</strong>. <strong></strong></span></li>
                  </ul>
              
                  <p><span class="style20"><span class="style29"><u>Takeoff Button</u></span> - The Green Meatball  puts the current time       (non-military) in the Takeoff column of the selected record on the main       flight sheet page.</span></p>
                  </ul>
              <blockquote>
                  <p><span class="style20"><span class="style30"><u>Landing Button</u></span>&nbsp; -The       Red Meatball puts the current time (non-military) in the Landing column of       the selected record on the main flight sheet page. </span></p>
              </blockquote>
              <ul type="disc">
                  <ul type="circle">
                      <li class="style21"><span class="style25">The Landing Button  immediately sends        out a receipt email of flight details to the PGC Member Charged, Webmaster and Treasurer, showing the flight information entered up to that point.</span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <ul type="square">
                          <li class="style18"><span class="style20">The e-mail is</span> sent at this point because the         member may not return to the flight desk to update tow altitude.</li>
                          <li class="style18">The e-mail is automatically sent out using  a backgroud process - no message or other indication is displayed on the system.</li>
                      </ul>
                      <blockquote>
                          <p><span class="style123"><span class="style126"><strong><em><u>Sample receipt email sent  when Landing Button records landing time.</u></em></strong><br />
                              <em><strong>&nbsp; <br />
                                  From:  PGC Pilot Data Portal [mailto:PGC Pilot Data Portal]<br />
                                  Sent:  Sunday, May 23, 2010 12:25 AM<br />
                                  To:  mattg123@verizon.net; kilokilo@comcast.net; JoeMember@comcast.net<br />
                                  Subject:  PGC Flightlog - Landing Time Updated for Flight: 406 Updated<br />
                                  By:  <span class="style125">77.99.777.444</span></strong></em></span></span></p>
                          <p class="style125">This  message was generated by the PDP when your landing time was updated by the  flight desk.</p>
                          <p class="style125">You  may receive additional updates when your tow altitude is updated ... or if  additional changes are made to this log record.</p>
                          <p class="style125">Please  contact the Treasurer or a BOD member if this data is not accurate.</p>
                          <p class="style125">Source  IP: 77.99.777.444<br />
                              Key:  406<br />
                              Date:  2010-05-23<br />
                              Glider:  8G<br />
                              Member Charged:  Grasshopper, Joe<br />
                              Instructor:  Po, Master<br />
                              Takeoff:  07:06:27<br />
                              Landing:  07:25:07<br />
                              Duration:  0.31<br />
                              Tow  Altitude: 5000<br />
                              Tow  Plane: 305A<br />
                              Tow  Pilot: Towpilot, Joe<br />
                              Notes: PGC Yearly Checkout</p>
                      </blockquote>
                  </ul>
              </ul>
              <blockquote>
                  <p class="style18"><strong><u>FLIGHT SHEET DETAIL  SCREEN</u></strong></p>
                  <p class="style18">Individual flight records  can be edited using the detail screen by clicking on the record key in  the leftmost column of the flight sheet main page.<br />
                      <br />
                      This screen allows the  flight desk to incrementally capture/change information about a flight.&nbsp; You will typically go to this screen 2 - 3  times per flight to enter or change data.&nbsp; </p>
                  <p class="style18"><span class="style18">Make as many updates  required to capture the correct information.</span></p>
              </blockquote>
              <p align="center">&nbsp;</p>
              <p align="center"><span class="style18"><img src="../FlightSheet/FlightSheetDetail.jpg" alt="FS" width="504" height="422" /> </span></p>
              <p>&nbsp;</p>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Date</u></strong> - Initialized by the system ... no change possible via this       screen.</span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Glider</u></strong> - A list of all PGC Gliders will be displayed in alpha order.</span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Flight Type</u></strong> - Dropdown options include TRN for Training ... REG for       Regular ... AOF for Aeronautical Orientation Flight. </span></li>
                  </ul>
              <ul type="disc">
                  <ul>
                      <li class="style18">If the PGC AOF Pilot is not a CFIG, put their name in the Member column.                          </li>
                      <li class="style18">If the PGC AOF Pilot is a CFIG, put their name in the Instructor Column - and put AOF in the member column. (The system will do this automatically if you forget.) </li>
                  </ul>
              </ul>
              <p align="center" class="style23"><img src="../FligntLog Tutorial/AOF Entries.jpg" alt="AOF" width="504" height="79" /></p>
              <p>&nbsp;</p>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Member Charged</u></strong> - A list of all Active PGC members will be       displayed - last name first.</span></li>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">This list can be searched by entering the first        character of the lat name ... entering 'K' for example, will bring up the        first member who has a last name beginning with 'K' ... enter 'K'        repeatedly to quickly step through the list. </span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">A blank row shows at the top of the member        drop-down ... this can be selected to remove an entered name. A blank  is        also  selected for an AOF ... the flight type is AOF ... and an optional entry can be  made in the notes        section.&nbsp;</span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">Member Charged and/or Instructor has to be        initialized before the record is considered official.</span></li>
                      </ul>
                  </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Instructor</u></strong> - A list of current PGC instructors is displayed in alpha order.</span></li>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">A blank row shows at the top of the instructor        drop-down ... this can be selected to remove an entered instructor - if the pilot is flying as PIC. </span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">Member Charged and/or Instructor has to be        initialized before the record is considered official.&nbsp;</span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Takeoff </u></strong>- Manually entered time  has to be entered in HH:MM format like: &quot;11:45&quot;       ... &quot;14:37&quot;. Typically, manual entry is not required if the main       page Takeoff Time meatball is used to capture the actual event.</span></li>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li><span class="style18">The entered time can be in civilian or military        format. &nbsp; </span></li>
                  </ul>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Landing </u></strong>- Same rules as takeoff time entry.&nbsp; Entering a landing time <span class="style33">manually</span> will not immediately auto-generate a receipt  email. (See Update Record.)</span> </li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Hours</u></strong> - Flight duration in decimal hours is auto calculated by the system when Update Record is       selected. This format is required by the billing system. &nbsp; </span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Tow Altitude</u></strong> A drop-down list of allowed values is displayed       ... from SRB (Simulated Rope Break) ... 1000' - 5000' Tows ... and AERO       for Aero Tow time on x-country retrieves or ferry operations.</span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Tow Plane</u></strong> - Available tow planes are displayed. The system will default to       the last selected Tow Plane used in a flight record. </span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Tow Pilot</u></strong> - Available Tow Pilots will be displayed.&nbsp; The system will default to the last       selected Tow Pilot used in a flight record. </span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Tow Charge </u></strong>- System calculated tow fees based on current       rates.&nbsp; AERO changes will be based       on $60 per hour. </span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>Notes</u></strong> - Free form notes field.</span></li>
              </ul>
              <ul type="disc">
                  <li><span class="style18"><strong><u>UPDATE RECORD</u></strong> - writes the information to the database and returns to the main page.</span></li>
              </ul>
              <ul type="disc">
                  <ul type="circle">
                      <li class="style26"><u>If Takeoff and Landing times are entered</u>, the Update Record button  <span class="style34">will auto-generate</span>        an updated  receipt  email advising the Member Charged, Webmaster, and Treasurer that changes were        made to the flight record. </li>
                  </ul>
              </ul>
              <p>&nbsp;</p></td>
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