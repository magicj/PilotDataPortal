<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_access_app_groups (app_name, allowed_group) VALUES (%s, %s)",
                       GetSQLValueString($_POST['app_name'], "text"),
                       GetSQLValueString($_POST['allowed_group'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_access_app_groups.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_AppList = "SELECT app_name FROM pgc_access_apps";
$AppList = mysql_query($query_AppList, $PGC) or die(mysql_error());
$row_AppList = mysql_fetch_assoc($AppList);
$totalRows_AppList = mysql_num_rows($AppList);

mysql_select_db($database_PGC, $PGC);
$query_GroupList = "SELECT group_name FROM pgc_access_grouplist";
$GroupList = mysql_query($query_GroupList, $PGC) or die(mysql_error());
$row_GroupList = mysql_fetch_assoc($GroupList);
$totalRows_GroupList = mysql_num_rows($GroupList);

error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT WORK VIEW</title>
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
.style56 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
.style57 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
}
.style42 {	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #E2E2E2;
}
.style54 {font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style58 {color: #CCCCCC; font-weight: bold; }
.style59 {
	color: #F0F0F0;
	font-weight: bold;
}
.style60 {color: #F0F0F0}
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2"  bordercolor="#000033" bgcolor="#595E80">
      <tr>
            <td height="25" align="center"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="350" valign="top"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
                        <tr>
                                <td width="1562" height="26" valign="middle" class="style57"><div align="center">ENTER GROUPS ALLOWED TO ACCESS THIS APP </div></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><p> </p>
                                <p> 
                                </p>
                                                <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                  <table align="center">
                                          <tr valign="baseline">
                                                  <td width="85" align="right" nowrap>App_name:</td>
                                                  <td width="303"><select name="app_name" id="app_name">
                                                                  <?php
do {  
?>
                                                                  <option value="<?php echo $row_AppList['app_name']?>"<?php if (!(strcmp($row_AppList['app_name'], $row_AppList['app_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_AppList['app_name']?></option>
                                                                  <?php
} while ($row_AppList = mysql_fetch_assoc($AppList));
  $rows = mysql_num_rows($AppList);
  if($rows > 0) {
      mysql_data_seek($AppList, 0);
	  $row_AppList = mysql_fetch_assoc($AppList);
  }
?>
                                                          </select>
</td>
                                          </tr>
                                          <tr valign="baseline">
                                                  <td nowrap align="right">Allowed_group:</td>
                                                  <td><select name="allowed_group" id="allowed_group">
                                                                  <?php
do {  
?>
                                                                  <option value="<?php echo $row_GroupList['group_name']?>"<?php if (!(strcmp($row_GroupList['group_name'], $row_GroupList['group_name']))) {echo "selected=\"selected\"";} ?>><?php echo $row_GroupList['group_name']?></option>
                                                                  <?php
} while ($row_GroupList = mysql_fetch_assoc($GroupList));
  $rows = mysql_num_rows($GroupList);
  if($rows > 0) {
      mysql_data_seek($GroupList, 0);
	  $row_GroupList = mysql_fetch_assoc($GroupList);
  }
?>
                                                          </select>
</td>
                                          </tr>
                                          <tr valign="baseline">
                                                  <td nowrap align="right">&nbsp;</td>
                                                  <td><input type="submit" value="Insert record"></td>
                                          </tr>
                                  </table>
                                  <input type="hidden" name="MM_insert" value="form2">
                          </form>
                          <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" class="style16"><div align="center"><a href="pgc_access_menu.php" class="style17">BACK TO ACCESS MENU </a><a href="../07_members_only_pw.php" class="style17"></a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($AppList);

mysql_free_result($GroupList);
?>
