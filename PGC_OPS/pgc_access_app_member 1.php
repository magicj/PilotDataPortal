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
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
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
	
   // Clean Up Deletions 
  $deleteSQL = "DELETE FROM pgc_access_member_groups WHERE rec_active = 'D'";
  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
  
    // Then Perform Updates  
 /* $insertSQL = sprintf("INSERT IGNORE INTO pgc_access_member_groups (member_id, member_name, assigned_group, rec_active) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['member_id'], "text"),
                       GetSQLValueString($_POST['member_name'], "text"),
                       GetSQLValueString($_POST['assigned_group'], "text"),
                       GetSQLValueString($_POST['rec_active'], "text")); */
					   
  
  // Then Perform Updates  
  $insertSQL = sprintf("INSERT IGNORE INTO pgc_access_member_groups (member_name, assigned_group, rec_active) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['member_name'], "text"),
                       GetSQLValueString($_POST['assigned_group'], "text"),
                       GetSQLValueString($_POST['rec_active'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());



  $insertGoTo = "pgc_access_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_members ORDER BY NAME ASC";
$Recordset1 = mysql_query($query_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_PGC, $PGC);
$query_Recordset2 = "SELECT group_name FROM pgc_access_grouplist";
$Recordset2 = mysql_query($query_Recordset2, $PGC) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
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
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
      <tr>
            <td height="25" align="center"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="350" valign="top"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
                        <tr>
                                <td width="1562" height="26" valign="middle" class="style57"><div align="center">ADD  MEMBER  TO GROUP</div></td>
                        </tr>
                        <tr>
                          <td align="center" valign="top"><p> 
                          </p>
                                                
                                                                <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                                          <table align="center">
                                                  
                                                  <tr valign="baseline">
                                                          <td width="94" align="right" nowrap>Member_name:</td>
                                                          <td width="292"><select name="member_name" id="member_name">
                                                                          <?php
do {  
?>
                                                                          <option value="<?php echo $row_Recordset1['NAME']?>"<?php if (!(strcmp($row_Recordset1['NAME'], $row_Recordset1['NAME']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['NAME']?></option>
                                                                          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                                                                  </select></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td nowrap align="right">Assigned_group:</td>
                                                          <td><select name="assigned_group" id="assigned_group">
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
                                                                  </select></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td nowrap align="right">Rec_active:</td>
                                                          <td><select name="rec_active" id="rec_active">
                                                              <option value="Y" selected="selected">Y</option>
                                                                  <option value="N">N</option>
                                                                  <option value="D">D</option>
                                                          </select></td>
                                                  </tr>
                                                  <tr valign="baseline">
                                                          <td nowrap align="right">&nbsp;</td>
                                                          <td><input type="submit" value="Insert record"></td>
                                                  </tr>
                                          </table>
                                          <input type="hidden" name="MM_insert" value="form1">
                                  </form>
                                  <p>&nbsp;</p>
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