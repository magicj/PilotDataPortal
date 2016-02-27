<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
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

define('EST_OFFSET',4*3600);
$TOtime = date("h:i:s",TIME()-EST_OFFSET);
$updateSQL = sprintf("UPDATE pgc_flightsheet SET Takeoff=%s WHERE `Key`=%s",
                       GetSQLValueString($TOtime, "date"),
                       GetSQLValueString($_GET['recordID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());
   
 	  
  $insertGoTo = "pgc_flightlog_list_edit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];

  header(sprintf("Location: %s", $insertGoTo));

 }

 mysql_free_result($Result1);
 
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Flightlog</title>
<style type="text/css">
<!--
.style1 {	font-size: 18px;
	font-weight: bold;
}
body {
	background-color: #333333;
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
.style3 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
.style17 {color: #330033}
.style23 {color: #330033; font-size: 10; font-weight: bold; }
.style25 {font-size: 18px; font-weight: bold; color: #000000; }
-->
</style>
</head>

<script language="javascript" src="../calendar/calendar.js"></script>




<body>
<p>&nbsp;</p>
<table width="800" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="481"><table width="92%" height="447" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      
      <tr>
        <td height="373"><p><?php print  date("h:i:s A"); ?>&nbsp;</p>
          <p>
            <!--<form action="somewhere.php" method="post">
*/</form>

<p>&nbsp;</p>
--></p>
          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
            <input type="hidden" name="MM_update" value="form2">
            <input type="hidden" name="Key" value="<?php echo $row_Flightlog['Key']; ?>">
          </form>
          <p>
              <label></label>
              <label></label>
          </p></td>
      </tr>
      <tr>
 

        <td height="28"><div align="center"><strong class="style3"><a href="pgc_flightlog_list_edit.php" class="style16">BACK TO FLIGHT SHEET</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Flightlog);

 
?>



