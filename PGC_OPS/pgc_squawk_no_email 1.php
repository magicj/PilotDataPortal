<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
if ( !(isset($_SESSION['last_sq_date'])))  {
$_SESSION['last_sq_date'] = date("Y-m-d");
} 

$session_pilotname = $_SESSION['MM_PilotName'];
$session_email = $_SESSION['MM_Username']; 
 
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pgc_squawk (id_entered, id_name, sq_date, sq_equipment, sq_status, sq_issue) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString($_POST['sq_member'], "text"),
                       GetSQLValueString($_POST['sq_date'], "date"),
                       GetSQLValueString($_POST['sq_equipment'], "text"),
					   GetSQLValueString('NEW', "text"),
                       GetSQLValueString($_POST['sq_issue'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
  
  $_SESSION['last_sq_date'] = $_POST['sq_date'];
  
  /*  Send Email  */
/*	$message = " Equipment: " . $_POST[sq_equipment] . "\n\n Reported By: ". $_SESSION['MM_PilotName'] . "\n\n Date: " . $_POST[sq_date] .  "\n\n Problem Description: " . $_POST[sq_issue];
	
	$to = "kilokilo@comcast.net, kilokilo@comcast.net" ;
	$to = "Jack@nni.com, michaelclittle@gmail.com, kilokilo@comcast.net, " . $_SESSION['MM_Username'] ;
	
	
	$subject = "PGC SQUAWK (V2)";
	$email = $_REQUEST['email'] ;
	$headers = "From: PGC-Squawk@noreply.com";
	$sent = mail($to, $subject, $message, $headers) ;*/
		
    /*  Send Email End  */

  $insertGoTo = "pgc_squawk_no_email.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT equip_name FROM pgc_equipment ORDER BY equip_type ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT * FROM pgc_members";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
<title>PGC EQUIPMENT SQUAWK</title>
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
.style35 {color: #FFFFFF; font-size: 14px; font-weight: bold; font-style: italic; }
.style37 {color: #EBEBEB; font-size: 14px; font-weight: bold; font-style: italic; }
.style38 {color: #EBEBEB; }
.style40 {
	color: #FFCC00;
	font-weight: bold;
	font-size: 14px;
}
.style41 {
	font-size: 12px;
	color: #CCCCCC;
}
.style42 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
}
.style43 {font-size: 12px; }
.style44 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="398" bgcolor="#666666"><table width="900" height="501" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#005B5B">
                        <tr>
                              <td width="1562" height="57" valign="top" bgcolor="#0A335C"><div align="center">
                                      <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                      <td height="16" valign="top"><div align="center"><span class="style42">ADMIN  SQUAWK HISTORY ENTRY</span></div></td>
                                              </tr>
                                              <tr>
                                                      <td height="16" valign="top"><p align="center" class="style43">&nbsp;</p></td>
                                              </tr>
                                              <tr>
                                                      <td><div align="center"></div></td>
                                              </tr>
                                      </table>
                              </div></td>
                        </tr>
                        <tr>
                                <td height="277" align="center" valign="top" bgcolor="#0A335C"><form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                        <p>&nbsp;</p>
                                        <table width="575" align="center" bgcolor="#999999">
                                                <tr valign="baseline">
                                                        <td width="117" height="33" align="right" valign="middle" nowrap class="style35"><div align="left" class="style38"></div></td>
                                                        <td width="446" valign="middle"><div align="left"><span class="style40"><?php echo $_SESSION['MM_PilotName']; ?></span>&nbsp;</div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                  <td height="33" align="right" valign="middle" nowrap class="style35"><div align="left"><span class="style38">Reported By:</span></div></td>
                                                  <td valign="middle"><div align="left">
                                                    <select name="sq_member" id="sq_member">
                                                      <?php
do {  
?>
                                                      <option value="<?php echo $row_Recordset2['NAME']?>"><?php echo $row_Recordset2['NAME']?></option>
                                                      <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                                                    </select>
                                                  </div></td>
                                                </tr>
                                                
                                                <tr valign="baseline">
                                                        <td align="right" valign="middle" nowrap class="style35"><div align="left" class="style38">Squawk Date </div></td>
                                                  <td valign="middle"><div align="left">
                                                    <input name="sq_date" type="text" size="10" value=<?php echo $_SESSION['last_sq_date']?>>
                                                          <a href="#"
					   name="anchor2" class="style44" id="anchor2" onclick="cal.select(document.forms['form1'].sq_date,'anchor2','yyyy-MM-dd'); return false">Select From Calendar</a></div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                        <td align="right" valign="middle" nowrap class="style17"><div align="left" class="style38">Equipment</div></td>
                                                        <td valign="middle"><div align="left">
                                                          <select name="sq_equipment">
                                                            <?php
do {  
?>
                                                            <option value="<?php echo $row_Recordset1['equip_name']?>"><?php echo $row_Recordset1['equip_name']?></option>
                                                            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                                          </select>
                                                        </div></td>
                                                </tr>
                                                <tr valign="baseline">
                                                        <td align="right" valign="middle" nowrap><div align="left" class="style37">Problem</div></td>
                                                        <td><textarea name="sq_issue" cols="70" rows="10"></textarea></td>
                                                </tr>
                                                <tr valign="baseline">
                                                        <td nowrap align="right">&nbsp;</td>
                                                        <td><div align="left">
                                                          <input type="submit" value="Submit Squawk">
                                                        </div></td>
                                                </tr>
                                        </table>
                                        <input type="hidden" name="MM_insert" value="form1">
                                </form>
                                        <p>&nbsp;</p>
                                        </p></td>
                        </tr>
                        <tr>
                              <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="pgc_squawk_view.php" class="style17">BACK TO SQUAWK VIEW PAGE</a></div></td>
                        </tr>
                  </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>

