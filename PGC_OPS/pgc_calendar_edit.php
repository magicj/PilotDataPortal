<?php require_once('../Connections/PGC.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_calendar SET EventDate=%s, EventTitle=%s, EventOrder=%s WHERE EventID=%s",
                       GetSQLValueString($_POST['EventDate'], "date"),
                       GetSQLValueString($_POST['EventTitle'], "text"),
                       GetSQLValueString($_POST['EventOrder'], "int"),
                       GetSQLValueString($_POST['EventID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = "pgc_calendar_edit_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['recordID'] : addslashes($_GET['recordID']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT EventID, EventDate, EventTitle, EventOrder FROM pgc_calendar WHERE EventID = %s ORDER BY EventDate DESC", GetSQLValueString($colname_Recordset1, "int"));
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
 if (!isset($_SESSION)) {
  session_start();
}
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
<title>PGC Data Portal - Calendar Edit</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #CCCCCC;
}
body {
	background-color: #304078;
	background-image: url(../images/Buttons/PGC%20copy.png);
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
.style18 {
	color: #FFFFCC;
	font-weight: bold;
	font-style: italic;
}
a:link {
	color: #FFCC00;
}
a:visited {
	color: #33CC33;
}
.style23 {color: #FFFFFF}
.style24 {color: #FFFFFF; font-weight: bold; }
.style25 {
	color: #8CA6D8;
	font-weight: bold;
}
.style26 {color: #8CA6D8}
-->
</style></head>

<body>
<table width="800" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#51547B">
  <tr>
    <td><div align="center"><span class="style1">PGC DATA PORTAL </span></div></td>
  </tr>
  <tr>
    <td height="514" bgcolor="#666666"><table width="92%" height="440" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#414567">
      <tr>
        <td height="36"><div align="center"><span class="style11">PGC Calendar Edit </span></div></td>
      </tr>
      <tr>
        <td height="373" bgcolor="#4F5359"><p align="center" class="style18">

            <form action="<?php echo $editFormAction; ?>" method="post" name="new_flight" id="new_flight">
                <table align="center" bgcolor="#CCCCCC">
                    <tr valign="baseline">
                        <td width="67" align="right" nowrap bgcolor="#3D4461"><div align="left">Key:</div></td>
                        <td width="525" bgcolor="#3D4461"><div align="left"><?php echo $row_Recordset1['EventID']; ?></div></td>
                    </tr>
                    <tr valign="baseline">
                        <td align="right" nowrap bgcolor="#3D4461"><div align="left">Event Date:</div></td>
                      <td bgcolor="#3D4461"><div align="left">
                        <input name="EventDate" type="text" id="EventDate" value="<?php echo $row_Recordset1['EventDate']; ?>" size="10" />
                      <a href="#" onclick="cal.select(document.forms['new_flight'].EventDate,'anchor2','yyyy-MM-dd'); return false"
					   name="anchor2" id="anchor2">Select From Calendar</a> </div></td>
                    </tr>
                    <tr valign="baseline">
                        <td align="right" nowrap bgcolor="#3D4461"><div align="left">Event Title </div></td>
                        <td bgcolor="#3D4461"><textarea name="EventTitle" cols="80" rows="5"><?php echo $row_Recordset1['EventTitle']; ?></textarea></td>
                    </tr>
                    <tr valign="baseline">
                        <td align="right" nowrap bgcolor="#3D4461">Event Order:</td>
                        <td bgcolor="#3D4461"><div align="left">
                          <input name="EventOrder" type="text" value="<?php echo $row_Recordset1['EventOrder']; ?>" size="1" maxlength="1">
                        </div></td>
                    </tr>
                    <tr valign="baseline">
                        <td colspan="2" align="right" nowrap bgcolor="#3D4461"><div align="center">
                            <input type="submit" value="Update record">
                        </div></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form1">
                <input type="hidden" name="EventID" value="<?php echo $row_Recordset1['EventID']; ?>">
            </form>
            <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style11"><a href="pgc_calendar_edit_list.php" class="style16">BACK TO LIST</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
 