<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
if ( trim($session_pilotname = '') )  {   
    header("Location: ". $MM_restrictGoTo); 
  exit;
 }
/* Day of Week Code 
 $h = mktime(0, 0, 0, 10, 31, 2008);
 $d = date("F dS, Y", $h) ;
 $w= date("l", $h) ;
 Echo "$d is on a $w";
 */
?>
<?php
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

$date_limit = date('Y-m-d', strtotime("+7 days"));
$todays_date = date('Y-m-d', strtotime("0 days"));


	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	
	/*** Check to See If CFIG1 is Off Duty ***/
    $insertSQL = sprintf("SELECT * FROM pgc_cfig_dates WHERE cfig_name = %s AND duty_date = %s AND cfig_vacation = 'Y'" ,  

						  GetSQLValueString($_POST['request_cfig'], "text"),
					      GetSQLValueString($_POST['date1'], "date"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	  $row_Result1 = mysql_fetch_assoc($Result1);
	  $totalRows_Result1 = mysql_num_rows($Result1);
	  $OffDutyCFIG1 = 'Y';
	  If ($totalRows_Result1  ==  0) {
	      $OffDutyCFIG1 = 'N';
	  }
	  
	  	/*** Check to See If CFIG2 is Off Duty ***/
    $insertSQL = sprintf("SELECT * FROM pgc_cfig_dates WHERE cfig_name = %s AND duty_date = %s AND cfig_vacation = 'Y'" ,  

						  GetSQLValueString($_POST['request_cfig2'], "text"),
					      GetSQLValueString($_POST['date1'], "date"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	  $row_Result1 = mysql_fetch_assoc($Result1);
	  $totalRows_Result1 = mysql_num_rows($Result1);
	  $OffDutyCFIG2 = 'Y';
	  If ($totalRows_Result1  ==  0) {
	      $OffDutyCFIG2 = 'N';
	  }
	  
	  
If ($OffDutyCFIG1 == 'N' AND $OffDutyCFIG2 == 'N' ) {	  
  /* UPDATE~RECORD */
	$insertSQL = sprintf("INSERT INTO pgc_request (member_name, member_id, request_date, request_time, request_type, member_weight, request_cfig, request_cfig2, request_notes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_SESSION['MM_PilotName'], "text"),
						   GetSQLValueString($_SESSION['MM_Username'], "text"),
						   GetSQLValueString($_POST['date1'], "date"),
						   GetSQLValueString($_POST['request_time'], "date"),
						   GetSQLValueString($_POST['request_type'], "text"),
						   GetSQLValueString($_POST['request_weight'], "text"),						   
						   GetSQLValueString($_POST['request_cfig'], "text"),
						   GetSQLValueString($_POST['request_cfig2'], "text"),
						   GetSQLValueString($_POST['request_notes'], "text"));
	
	  mysql_select_db($database_PGC, $PGC);
	  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
	  
	  /*   Update E-Mail IDs                 */
	  /* Depends on CFIG_DATES Updates in List Member ***/
	   /*** Enter Email for CFIG1 ***/
	  $id = mysql_insert_id(); 
	  $updateSQL = sprintf( "UPDATE pgc_request A, pgc_members B SET A.cfig1_email = B.USER_ID
      WHERE A.request_cfig = B.NAME AND A.request_key=%s",        
                       GetSQLValueString($id, "int"));
       mysql_select_db($database_PGC, $PGC);
      $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	 
	  /*** Blank Email for Off Duty CFIG1 ***/
	  
	  $updateSQL = sprintf( "UPDATE pgc_request A, pgc_cfig_dates B SET A.cfig1_email = ''
      WHERE A.request_cfig = B.cfig_name AND A.request_date = B.duty_date AND B.cfig_vacation = 'Y' AND A.request_key=%s",        
                       GetSQLValueString($id, "int"));
       mysql_select_db($database_PGC, $PGC);
      $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error()); 
	  
	  /*** Enter Email for CFIG2 ***/
	  
	  $updateSQL = sprintf( "UPDATE pgc_request A, pgc_members B SET A.cfig2_email = B.USER_ID
      WHERE A.request_cfig2 = B.NAME AND A.request_key=%s",        
                       GetSQLValueString($id, "int"));
      mysql_select_db($database_PGC, $PGC);
      $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  
	  	  /*** Blank Email for Off Duty CFIG2 ***/
	  
	  $updateSQL = sprintf( "UPDATE pgc_request A, pgc_cfig_dates B SET A.cfig2_email = ''
      WHERE A.request_cfig2 = B.cfig_name AND A.request_date = B.duty_date AND B.cfig_vacation = 'Y' AND A.request_key=%s",        
                       GetSQLValueString($id, "int"));
       mysql_select_db($database_PGC, $PGC);
      $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
	  
	  /*  Save Original Values */
			  $updateSQL = sprintf("UPDATE pgc_request SET orig_request_date = request_date, orig_request_cfig =    request_cfig, orig_request_cfig2 = request_cfig2, orig_cfig1_email = cfig1_email, orig_cfig2_email = cfig2_email, orig_assign_cfig_email = assign_cfig_email, orig_accept_cfig = accept_cfig WHERE request_key=%s",
              GetSQLValueString($id, "int"));
			  mysql_select_db($database_PGC, $PGC);
              $Result2 = mysql_query($updateSQL, $PGC) or die(mysql_error());
			  $row_Result2 = mysql_fetch_assoc($Result2);
			  $totalRows_Result2 = mysql_num_rows($Result2);
  

         /*  Send Email */
	 $colname_Requests = "-1";
if (isset($_GET['request_id'])) {
  $colname_Requests = (get_magic_quotes_gpc()) ? $_GET['request_id'] : addslashes($_GET['request_id']);
}
	 
 mysql_select_db($database_PGC, $PGC);
$query_Requests9 = sprintf("SELECT * FROM pgc_request WHERE request_key = %s", $id);
$Requests9= mysql_query($query_Requests9, $PGC) or die(mysql_error());
$row_Requests9 = mysql_fetch_assoc($Requests9);
$totalRows_Requests9 = mysql_num_rows($Requests9);
  
          $message = " " . $row_Requests9[member_name] . "\n\n" . " Your instruction request was entered as indicated below." . "\n\n";
		  
		  
		    
        $made_change = 'yes';   
		   
   
		$message = $message . "Member - New Instruction Request" . "\n";
		$message = $message . "=========================" . "\n";
		$message = $message ."Request Number:   " . $row_Requests9[request_key] . "\n";
		$message = $message ."Member Name:      " . $row_Requests9[member_name] . "\n";
		$message = $message ."Date Requested:   " . $row_Requests9[request_date] . "\n";
		$message = $message ."Request Type:     " . $row_Requests9[request_type] . "\n";
		$message = $message ."Request Notes:    " . $row_Requests9[request_notes] . "\n";
		$message = $message ."Member Weight:    " . $row_Requests9[member_weight] . "\n";
		$message = $message ."CFIG 1 Requested: " . $row_Requests9[request_cfig] . "\n";
		$message = $message ."CFIG 2 Requested: " . $row_Requests9[request_cfig2] . "\n";
		$message = $message ."CFIG Assigned:    " . $row_Requests9[accept_cfig] . "\n";
		$message = $message ."CFIG Notes:       " . $row_Requests9[accept_notes] . "\n";
		$message = $message ."Record Deleted?:  " . $row_Requests9[record_deleted] . "\n\n";
		

		$message = $message . "This record was entered by ... " . $session_pilotname . "\n\n\n";
		
			$entry_ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
       $entry_ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
       $entry_ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
       $entry_ip=$_SERVER['REMOTE_ADDR'];
    }
	$message = $message . $entry_ip . "\n\n";

		
				
		/* Create Email List */
	    $ToList = $row_Requests9[member_id] ;
		
		if (trim($row_Requests9[cfig1_email]) != '') {
		$ToList = $ToList . "," . $row_Requests9[cfig1_email];
				}
		if (trim($row_Requests9[cfig2_email]) != '') {
		$ToList = $ToList . "," . $row_Requests9[cfig2_email];
						}
				
   	    $webmaster = "support@pgcsoaring.org"; 
		$ToList = $ToList . "," . $webmaster;	
		$message = $message ."Email List:  " . $ToList . "\n\n";
		
		/* End - Create Email List */
	    
		$to = $ToList;
		if ($row_System[sys_status] == 'test') {
				$to = "ventusdriver@gmail.com, support@pgcsoaring.org";
		}
		
		
		$subject = "PGC Instruction Request - New - Entered by Member";
				
	    $email = $_REQUEST['email'];
				
		$headers = "From: PGC Pilot Data Portal";
		$headers = "From: PGC-Instruction@noreply.com";
		
	   If ($made_change == 'yes') {
		  $sent = mail($to, $subject, $message, $headers) ; }

		  /*  END EMAIL */		
		
				   
					   
	  $_SESSION['MM_S_Message'] = "Record Saved - Enter Additional Or Exit";
	  
  $updateGoTo = $_SESSION[last_rm_query];
  
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
  $_SESSION['MM_S_Message'] =  "Modify record or save with no changes";
  
 } else  {
	 If ($OffDutyCFIG1 == 'Y') {
	 $_SESSION['MM_S_Message'] =  "CFIG1 is off duty for this date - select again";
	 }
 	 If ($OffDutyCFIG2 == 'Y') {
	 $_SESSION['MM_S_Message'] =  "CFIG2 is off duty for this date - select again";
	 }
	 If ($OffDutyCFIG1 == 'Y' AND $OffDutyCFIG2 == 'Y' ) {
	 $_SESSION['MM_S_Message'] =  "Both your CFIGs are off duty for this date - select again";
	 }
 
 }
 
 /* End of CFIG ON Duty */
   
	
	
} else {
	if (isset($_POST['date1'])) {
	$_SESSION['MM_S_Message'] = "Enter Training Request";
	} else {
	$_SESSION['MM_S_Message'] = "Enter Training Request";
	}
} 

$maxRows_Requests = 10;
$pageNum_Requests = 0;
if (isset($_GET['pageNum_Requests'])) {
  $pageNum_Requests = $_GET['pageNum_Requests'];
}
$startRow_Requests = $pageNum_Requests * $maxRows_Requests;

mysql_select_db($database_PGC, $PGC);
$query_Requests = "SELECT * FROM pgc_request ORDER BY request_date ASC";
$query_limit_Requests = sprintf("%s LIMIT %d, %d", $query_Requests, $startRow_Requests, $maxRows_Requests);
$Requests = mysql_query($query_limit_Requests, $PGC) or die(mysql_error());
$row_Requests = mysql_fetch_assoc($Requests);

if (isset($_GET['totalRows_Requests'])) {
  $totalRows_Requests = $_GET['totalRows_Requests'];
} else {
  $all_Requests = mysql_query($query_Requests);
  $totalRows_Requests = mysql_num_rows($all_Requests);
}
$totalPages_Requests = ceil($totalRows_Requests/$maxRows_Requests)-1;

mysql_select_db($database_PGC, $PGC);
$query_Instructors = "SELECT * FROM pgc_instructors WHERE cfig = 'Y' ORDER BY Name ASC";
$Instructors = mysql_query($query_Instructors, $PGC) or die(mysql_error());
$row_Instructors = mysql_fetch_assoc($Instructors);
$totalRows_Instructors = mysql_num_rows($Instructors);

mysql_select_db($database_PGC, $PGC);
$query_DutyDates = "SELECT date, Date_format(date,'%W, %M %e') as mydate FROM pgc_field_duty WHERE `date` >=CURDATE() AND `date` <= (CURDATE() + Interval 7 Day) ORDER BY `date` ASC LIMIT 3";
$DutyDates = mysql_query($query_DutyDates, $PGC) or die(mysql_error());
$row_DutyDates = mysql_fetch_assoc($DutyDates);
$totalRows_DutyDates = mysql_num_rows($DutyDates);

mysql_select_db($database_PGC, $PGC);
$query_System = "SELECT sys_status FROM pgc_system";
$System = mysql_query($query_System, $PGC) or die(mysql_error());
$row_System = mysql_fetch_assoc($System);
$totalRows_System = mysql_num_rows($System);

$maxRows_ServerTime = 1;
$pageNum_ServerTime = 0;
if (isset($_GET['pageNum_ServerTime'])) {
  $pageNum_ServerTime = $_GET['pageNum_ServerTime'];
}
$startRow_ServerTime = $pageNum_ServerTime * $maxRows_ServerTime;

mysql_select_db($database_PGC, $PGC);
$query_ServerTime = "SELECT DISTINCT NOW() FROM pgc_field_duty";
$query_limit_ServerTime = sprintf("%s LIMIT %d, %d", $query_ServerTime, $startRow_ServerTime, $maxRows_ServerTime);
$ServerTime = mysql_query($query_limit_ServerTime, $PGC) or die(mysql_error());
$row_ServerTime = mysql_fetch_assoc($ServerTime);

if (isset($_GET['totalRows_ServerTime'])) {
  $totalRows_ServerTime = $_GET['totalRows_ServerTime'];
} else {
  $all_ServerTime = mysql_query($query_ServerTime);
  $totalRows_ServerTime = mysql_num_rows($all_ServerTime);
}
$totalPages_ServerTime = ceil($totalRows_ServerTime/$maxRows_ServerTime)-1;
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
<title>PGC Data Portal - Instruction Request</title>
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
.style2 {
	font-size: 14px;
	font-weight: bold;
}
.style16 {color: #CCCCCC; }
a:link {
	color: #CCCCCC;
}
a:visited {
	color: #CCCCCC;
}
.style17 {
	color: #CCCCCC;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.style25 {font-weight: bold; color: #A7B5CE;}
.style31 {color: #000000}
.style32 {font-weight: bold; color: #000000; }
.style33 {font-size: 14px}
.style34 {
	color: #FFFF66;
	font-size: 16px;
}
.style36 {font-weight: bold; color: #A7B5CE; font-size: 14; }
.style37 {color: #F8BD6D}
.style38 {font-weight: bold; color: #6666FF; font-size: 14px; }
.style39 {color: #BAB3FF}
.style41 {font-size: 18px}
.style43 {font-size: 16px; }
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="900" height="481" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                              <td width="1562" height="40" bgcolor="#4F5359"><div align="center" class="style2">
                                          <table width="60%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td><div align="center" class="style33">PGC STUDENT INSTRUCTION REQUEST</div></td>
                                                </tr>
                                          </table>
                                    </div></td>
                        </tr>
                        <tr>
                              <td height="277" align="center" valign="top" bgcolor="#4F5359"><form action="<?php echo $editFormAction; ?>" method="post" name="new_flight" id="new_flight">
                                          <p><span class="style25 style34 style37"><?php echo "Requests only accepted for scheduled ops days - one week into the future."; ?>&nbsp;</span></p>
                                          <table width="380" align="center" cellpadding="5" cellspacing="2" bgcolor="#666666">
                                                <tr valign="baseline">
                                                      <td height="48" colspan="2" align="right" valign="middle" nowrap bgcolor="#6666FF" class="style25"><table width="380" border="0" cellpadding="2" cellspacing="2" bgcolor="#6666FF">
                                                                  <tr>
                                                                        <td width="214" height="30" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_PilotName']; ?></div></td>
                                                                        <td width="214" valign="middle" bgcolor="#6666FF" class="style32"><div align="center" class="style43"><?php echo $_SESSION['MM_Username']; ?></div></td>
                                                                  </tr>
                                                            </table></td>
                                                </tr>
                                                <tr valign="baseline">
                                                      <td width="140" height="1" align="right" valign="middle" nowrap bgcolor="#6666FF" class="style25"><div align="left" class="style31">INSTRUCTION DATE: </div></td>
                                                      <td width="215" height="1" valign="middle" bgcolor="#6666FF"><div align="left">
                                                                  <select name="date1" id="date1">
                                                                        <?php
do {  
?>
                                                                        <option value="<?php echo $row_DutyDates['date']?>"><?php echo $row_DutyDates['mydate']?></option>
                                                                        <?php
} while ($row_DutyDates = mysql_fetch_assoc($DutyDates));
  $rows = mysql_num_rows($DutyDates);
  if($rows > 0) {
      mysql_data_seek($DutyDates, 0);
	  $row_DutyDates = mysql_fetch_assoc($DutyDates);
  }
?>
                                                                  </select>
                                                            </div></td>
                                                </tr>
                                                <tr valign="middle" bgcolor="#6666FF">
                                                      <td height="1" align="right" nowrap="nowrap"><div align="left" class="style32">INSTRUCTION TYPE: </div></td>
                                                      <td height="1"><div align="left">
                                                                  <select name="request_type" id="request_type">
                                                                        <option value="Afternoon Thermalling">Afternoon Thermalling</option>
                                                                        <option value="Currency Check">Currency Check</option>
                                                                        <option value="First few flights">First few flights</option>
                                                                        <option value="Aerotow ">Aerotow </option>
                                                                        <option value="Slow Flight and Stalls">Slow Flight and Stalls</option>
                                                                        <option value="Box Wake">Box Wake</option>
                                                                        <option value="Landings">Landings</option>
                                                                        <option value="Slips">Slips</option>
                                                                        <option value="Spins &amp; Spiral Dives">Spins &amp; Spiral Dives</option>
                                                                        <option value="Winch">Winch</option>
                                                                        <option value="Prep for Solo">Prep for Solo</option>
                                                                        <option value="Prep for FAA Practical">Prep for FAA Practical</option>
                                                                        <option value="Annual Check Ride">Annual Check Ride</option>
                                                                        <option value="Rear Seat Check">Rear Seat Check</option>
                                                                        <option value="Biennial Flight Review">Biennial Flight Review</option>
                                                                        <option value="New Glider Pilot PGC Check Out">New Glider Pilot PGC Check Out</option>
                                                                  </select>
                                                            </div></td>
                                                </tr>
                                                <tr valign="middle" bgcolor="#6666FF">
                                                      <td height="1" align="right" nowrap="nowrap"><div align="left"><span class="style32">MEMBER WEIGHT: </span></div></td>
                                                      <td height="1"><div align="left">
                                                                  <input name="request_weight" type="text" id="request_weight" value="100" size="3" maxlength="3" />
                                                            </div></td>
                                                </tr>
                                                <tr valign="middle" bgcolor="#6666FF">
                                                      <td height="1" align="right" nowrap="nowrap"><div align="left" class="style32">REQUEST NOTES: </div></td>
                                                      <td height="1"><div align="left">
                                                                  <input type="text" name="request_notes" value="" size="32" />
                                                            </div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                      <td height="1" align="right" valign="middle" nowrap bgcolor="#6666FF" class="style25"><div align="left" class="style31">REQUESTED CFIG 1: </div></td>
                                                      <td height="1" valign="middle" bgcolor="#6666FF"><div align="left">
                                                                  <select name="request_cfig" id="request_cfig">
                                                                        <?php
do {  
?>
                                                                        <option value="<?php echo $row_Instructors['Name']?>"><?php echo $row_Instructors['Name']?></option>
                                                                        <?php
} while ($row_Instructors = mysql_fetch_assoc($Instructors));
  $rows = mysql_num_rows($Instructors);
  if($rows > 0) {
      mysql_data_seek($Instructors, 0);
	  $row_Instructors = mysql_fetch_assoc($Instructors);
  }
?>
                                                                  </select>
                                                            </div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                      <td height="1" align="right" valign="middle" nowrap="nowrap" bgcolor="#6666FF" class="style25"><div align="left" class="style31">REQUESTED CFIG 2: </div></td>
                                                      <td height="1" valign="middle" bgcolor="#6666FF"><div align="left">
                                                                  <select name="request_cfig2" id="request_cfig2">
                                                                        <?php
do {  
?>
                                                                        <option value="<?php echo $row_Instructors['Name']?>"><?php echo $row_Instructors['Name']?></option>
                                                                        <?php
} while ($row_Instructors = mysql_fetch_assoc($Instructors));
  $rows = mysql_num_rows($Instructors);
  if($rows > 0) {
      mysql_data_seek($Instructors, 0);
	  $row_Instructors = mysql_fetch_assoc($Instructors);
  }
?>
                                                                  </select>
                                                            </div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                  <td height="1" align="right" valign="middle" nowrap="nowrap" bgcolor="#6666FF" class="style25"><div align="left"><span class="style31">CONFIRMED WITH  CFIG1: </span></div></td>
                                                  <td height="1" valign="middle" bgcolor="#6666FF"><select name="select">
                                                    <option value="NO" selected="selected">NO</option>
                                                    <option value="YES">YES</option>
                                                  </select>
                                                  </td>
                                                </tr>
                                                <tr valign="baseline">
                                                      <td height="32" colspan="2" align="right" valign="middle" nowrap bgcolor="#6666FF"><div align="center">
                                                                  <input type="submit" value="SAVE">
                                                            </div></td>
                                                </tr>
                                                
                                                <tr valign="baseline">
                                                        <td height="28" colspan="2" align="right" valign="middle" nowrap bgcolor="#6666FF"><div align="center"><?php echo $row_ServerTime['NOW()']; ?></div>                                                                </td>
                                                </tr>
                                          </table>
                                          <span class="style36">
                                          <input type="hidden" name="MM_insert" value="form1" />
                                          </span>
                                    </form>
                                    <p class="style38 style39"><span class="style41"><?php echo $_SESSION['MM_S_Message']; ?></span>&nbsp;</p>
                                    </p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_request_list_member.php" class="style17">BACK TO MEMBER REQUEST LIST </a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Instructors);

mysql_free_result($DutyDates);

mysql_free_result($System);

mysql_free_result($ServerTime);

mysql_free_result($Requests);
?>
