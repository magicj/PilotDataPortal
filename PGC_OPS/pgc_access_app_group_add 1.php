<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
/* ==========================================================*/
require_once('pgc_access_save_appname.php'); 
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
/*require_once('pgc_access_check.php');
/* END - PAGE ACCESS CHECKING LOGIC - END */
/* ==========================================================*/
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
$_POST['app_name'] = $_GET['app_name'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {

  $insertSQL = sprintf("INSERT IGNORE INTO pgc_access_app_groups (app_name, allowed_group, rec_active) VALUES (%s, %s, %s)",                       
                       GetSQLValueString($_POST['app_name'], "text"),
                       GetSQLValueString($_POST['allowed_group'], "text"),
                       GetSQLValueString($_POST['rec_active'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = $_SESSION['last_app_group_list_page'];
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?>
<?php
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_GET['app_name'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_GET['app_name'] : addslashes($_GET['app_name']);
}
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_app_groups WHERE app_name = '%s' ORDER BY allowed_group ASC", $colname_Recordset1);
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

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT group_name FROM pgc_access_grouplist ORDER BY group_name ASC";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ENTER APP ALLOWED ACCESS GROUP</title>
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
.style56 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
.style57 {color: #FFFFFF; font-weight: bold; }
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
.style61 {	color: #999999;
	font-weight: bold;
	font-style: italic;
	font-size: 14px;
}
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                                <td width="1562" height="26" valign="middle" bgcolor="#005B5B" class="style57"><div align="center"><span class="style61">ENTER GROUP ALLOWED TO ACCESS APP </span></div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p> 
                          </p>
                                                
                                  
                                                                    <form id="form1" name="form1" method="post" action="">
                                                                            <table cellpadding="5" cellspacing="4" bgcolor="#666666">
                                                                                    <tr>
                                                                                            <td bgcolor="#404573" class="style17">rec_key</td>
                                                                                            <td bgcolor="#404573" class="style17">app_name</td>
                                                                                            <td bgcolor="#404573" class="style17">allowed_group</td>
                                                                                            <td bgcolor="#404573" class="style17">rec_active</td>
                                                                                    </tr>
                                                                                    <?php do { ?>
                                                                                            <tr>
                                                                                                    <td bgcolor="#404573" class="style17"><?php echo $row_Recordset1['rec_key']; ?></td>
                                                                                                    <td bgcolor="#404573" class="style17"><?php echo $row_Recordset1['app_name']; ?></td>
                                                                                                    <td bgcolor="#404573" class="style17"><?php echo $row_Recordset1['allowed_group']; ?></td>
                                                                                                    <td bgcolor="#404573" class="style17"><?php echo $row_Recordset1['rec_active']; ?></td>
                                                                                            </tr>
                                                                                            <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                                                                            </table>
                                                                            <p>&nbsp;</p>
                                                </form>
                                  
                                                                    <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                                                                            <table align="center" bgcolor="#666666">
                                                                                    
                                                                                    <tr valign="baseline">
                                                                                            <td align="right" nowrap bgcolor="#404573" class="style17"><div align="left">App_name:</div></td>
                                                                                            <td bgcolor="#404573" class="style17"><div align="left">
                                                                                                    <?php echo $_GET['app_name'] ?>
                                                                                            </div></td>
                                                                                    </tr>
                                                                                    <tr valign="baseline">
                                                                                            <td align="right" nowrap bgcolor="#404573" class="style17"><div align="left">Allowed_group:</div></td>
                                                                                            <td bgcolor="#404573" class="style17"><div align="left">
                                                                                                    <select name="allowed_group" id="allowed_group">
                                                                                                            <?php
do {  
?>
                                                                                                            <option value="<?php echo $row_Recordset2['group_name']?>"><?php echo $row_Recordset2['group_name']?></option>
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
                                                                                            <td align="right" nowrap bgcolor="#404573" class="style17"><div align="left">Rec_active:</div></td>
                                                                                            <td bgcolor="#404573" class="style17"><div align="left">
                                                                                                    <select name="rec_active" id="rec_active">
                                                                                                            <option value="Y" selected="selected">Y</option>
                                                                                                            <option value="N">N</option>
                                                                                                    </select>
                                                                                            </div></td>
                                                                                    </tr>
                                                                                    <tr valign="baseline">
                                                                                            <td align="right" nowrap bgcolor="#404573" class="style17"><div align="left"></div></td>
                                                                                            <td bgcolor="#404573" class="style17"><div align="left">
                                                                                                    <input type="submit" value="Insert record">
                                                                                            </div></td>
                                                                                    </tr>
                                                                            </table>
                                                                            <input type="hidden" name="MM_insert" value="form2">
                                                                    </form>
                                        <p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="pgc_access_menu.php" class="style17">BACK TO ACCESS MENU </a><a href="../07_members_only_pw.php" class="style17"></a></div></td>
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
