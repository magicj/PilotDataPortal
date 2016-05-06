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
$currentPage = $_SERVER["PHP_SELF"];
$_SERVER['QUERY_STRING'] = '';
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pgc_access_apps SET app_name=%s, app_active=%s, app_function=%s, app_notes=%s WHERE app_key=%s",
                       GetSQLValueString($_POST['app_name'], "text"),
                       GetSQLValueString($_POST['app_active'], "text"),
                       GetSQLValueString($_POST['app_function'], "text"),
                       GetSQLValueString($_POST['app_notes'], "text"),
                       GetSQLValueString($_POST['app_key'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

  $updateGoTo = $_SESSION['last_app_list_page'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

?>
<?php
$colname_Recordset1 = "-1";
if (isset($_GET['app_key'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['app_key'] : addslashes($_GET['app_key']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_apps WHERE app_key = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT app_function FROM pgc_access_functionlist ORDER BY app_function ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$currentPage = $_SERVER["PHP_SELF"];
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
	color: #FFFFFF;
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
.style57 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
}
.style58 {color: #CCCCCC; font-weight: bold; }
.style61 {
	font-size: 14;
	color: #999999;
}
.style64 {color: #999999; font-weight: bold; font-size: 14; }
.style65 {color: #CCCCCC; font-weight: bold; font-size: 14; }
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
      <tr>
            <td align="center"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
                        <tr>
                                <td width="1562" height="26" valign="top" class="style57"><div align="center">APPLICATION EDIT </div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center" cellpadding="3" cellspacing="2" bgcolor="#666666">
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#1A2740"><div align="left">App_key:</div></td>
                                  <td bgcolor="#283D62"><div align="left"><?php echo $row_Recordset1['app_key']; ?></div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#1A2740"><div align="left">App_name:</div></td>
                                  <td bgcolor="#283D62"><div align="left">
                                    <input type="text" name="app_name" value="<?php echo $row_Recordset1['app_name']; ?>" size="32">
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#1A2740"><div align="left">App_active:</div></td>
                                  <td bgcolor="#283D62"><div align="left">
                                          <select name="app_active" id="app_active">
                                                  <option value="Y" <?php if (!(strcmp("Y", $row_Recordset1['app_active']))) {echo "selected=\"selected\"";} ?>>Y</option>
                                                  <option value="N" <?php if (!(strcmp("N", $row_Recordset1['app_active']))) {echo "selected=\"selected\"";} ?>>N</option>
                                          </select>
                                          </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap bgcolor="#1A2740"><div align="left">App_function:</div></td>
                                  <td bgcolor="#283D62"><div align="left">
                                          <select name="app_function" id="app_function">
                                                  <?php
do {  
?>
                                                  <option value="<?php echo $row_Recordset2['app_function']?>"<?php if (!(strcmp($row_Recordset2['app_function'], $row_Recordset1['app_function']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset2['app_function']?></option>
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
                                  <td align="right" nowrap bgcolor="#1A2740"><div align="left">App_notes:</div></td>
                                  <td bgcolor="#283D62"><div align="left">
                                    <textarea name="app_notes" cols="50" rows="2"><?php echo $row_Recordset1['app_notes']; ?></textarea>
                                  </div></td>
                                </tr>
                                <tr valign="baseline">
                                  <td colspan="2" align="right" nowrap bgcolor="#1A2740">
                                    <div align="center">
                                      <input type="submit" value="Update record">
                                  </div></td>
                                </tr>
                              </table>
                              <input type="hidden" name="MM_update" value="form2">
                              <input type="hidden" name="app_key" value="<?php echo $row_Recordset1['app_key']; ?>">
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
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
