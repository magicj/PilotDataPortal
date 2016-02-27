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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pgc_signoff_types SET description=%s, target_group=%s, expires=%s, duration_days=%s, eom_expiry=%s, member_updates=%s, yearly_reset=%s, group_id=%s, default_signoff_date=%s, default_expire_date=%s, calc_expire_date=%s, active=%s, last_update_date=%s, last_update_id=%s, delete_record=%s, sort_order=%s WHERE signoffID=%s",
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['target_group'], "text"),
                       GetSQLValueString($_POST['expires'], "text"),
                       GetSQLValueString($_POST['duration_days'], "int"),
                       GetSQLValueString($_POST['eom_expiry'], "text"),
                       GetSQLValueString($_POST['member_updates'], "text"),
                       GetSQLValueString($_POST['yearly_reset'], "text"),
                       GetSQLValueString($_POST['group_id'], "text"),
                       GetSQLValueString($_POST['default_signoff_date'], "date"),
                       GetSQLValueString($_POST['default_expire_date'], "date"),
                       GetSQLValueString($_POST['calc_expire_date'], "text"),
                       GetSQLValueString($_POST['active'], "text"),
                       GetSQLValueString($_POST['last_update_date'], "date"),
                       GetSQLValueString($_POST['last_update_id'], "text"),
                       GetSQLValueString($_POST['delete_record'], "text"),
                       GetSQLValueString($_POST['sort_order'], "int"),
                       GetSQLValueString($_POST['signoffID'], "int"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($updateSQL, $PGC) or die(mysql_error());

//  $updateGoTo = "pgc_list_signoff_types.php";
    $updateGoTo = 'http://' . $_SERVER['HTTP_HOST']  .$_SESSION[last_signoff_query];
  if (isset($_SERVER['xQUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSignoffTypes = "-1";
if (isset($_GET['signoffID'])) {
  $colname_rsSignoffTypes = (get_magic_quotes_gpc()) ? $_GET['signoffID'] : addslashes($_GET['signoffID']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffTypes = sprintf("SELECT * FROM pgc_signoff_types WHERE signoffID = %s ORDER BY target_group ASC", $colname_rsSignoffTypes);
$rsSignoffTypes = mysql_query($query_rsSignoffTypes, $PGC) or die(mysql_error());
$row_rsSignoffTypes = mysql_fetch_assoc($rsSignoffTypes);
$totalRows_rsSignoffTypes = mysql_num_rows($rsSignoffTypes);

mysql_select_db($database_PGC, $PGC);
$query_rsTargetGroups = "SELECT group_desc FROM pgc_group_types ORDER BY group_desc ASC";
$rsTargetGroups = mysql_query($query_rsTargetGroups, $PGC) or die(mysql_error());
$row_rsTargetGroups = mysql_fetch_assoc($rsTargetGroups);
$totalRows_rsTargetGroups = mysql_num_rows($rsTargetGroups);

mysql_select_db($database_PGC, $PGC);
$query_rsRatings = "SELECT rating_name FROM pgc_ratings_list ORDER BY rating_name ASC";
$rsRatings = mysql_query($query_rsRatings, $PGC) or die(mysql_error());
$row_rsRatings = mysql_fetch_assoc($rsRatings);
$totalRows_rsRatings = mysql_num_rows($rsRatings);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pilot Data Portal - Pilot Signoff Status</title>
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
a:visited {
	color: #FFCC99;
}
.style18 {color: #CCCCCC; font-weight: bold; font-style: italic; }
-->
</style></head>

<body>

<table width="900" align="center" cellpadding="2" cellspacing="3" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td><div align="center"><span class="style1">PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="494"><table width="92%" height="488" align="center" cellpadding="2" cellspacing="3" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#2C364E"><div align="center"><span class="style11"> SIGNOFF TYPE UPDATE </span></div></td>
      </tr>
      
      <tr>
        <td height="417" align="center" valign="top" bgcolor="#2C364E"><p>&nbsp;</p>
          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
            <table width="623" height="278" align="center" cellpadding="2" cellspacing="1" bordercolor="#333333" bgcolor="#666666">
              <tr valign="middle" bgcolor="#0C3E43">
                <td width="117" align="right" nowrap class="style16"><div align="left"><em><strong>SignoffID:</strong></em></div></td>
                <td colspan="3"><?php echo $row_rsSignoffTypes['signoffID']; ?>                        <div align="left"></div></td>
                </tr>
              <tr valign="middle" bgcolor="#0C3E43">
                <td align="right" nowrap class="style16"><div align="left"><em><strong>Description:</strong></em></div></td>
                <td colspan="3"><div align="left">
                  <input name="description" type="text" value="<?php echo $row_rsSignoffTypes['description']; ?>" size="35" maxlength="30">
                </div>                        <div align="left"></div></td>
                </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Target_group:</strong></em></div></td>
                <td width="261" valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="target_group">
                    <?php
do {  
?>
                    <option value="<?php echo $row_rsRatings['rating_name']?>"<?php if (!(strcmp($row_rsRatings['rating_name'], $row_rsSignoffTypes['target_group']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsRatings['rating_name']?></option>
                    <?php
} while ($row_rsRatings = mysql_fetch_assoc($rsRatings));
  $rows = mysql_num_rows($rsRatings);
  if($rows > 0) {
      mysql_data_seek($rsRatings, 0);
	  $row_rsRatings = mysql_fetch_assoc($rsRatings);
  }
?>
                  </select>
                </div></td>
                <td width="123" align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Fly/NoFly Level </div></td>
                <td width="91" bgcolor="#0C3E43"><div align="left">
                  <select name="group_id">
                    <option value="A" <?php if (!(strcmp("A", $row_rsSignoffTypes['group_id']))) {echo "selected=\"selected\"";} ?>>A</option>
                    <option value="B" <?php if (!(strcmp("B", $row_rsSignoffTypes['group_id']))) {echo "selected=\"selected\"";} ?>>B</option>
                    <option value="C" <?php if (!(strcmp("C", $row_rsSignoffTypes['group_id']))) {echo "selected=\"selected\"";} ?>>C</option>
                  </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Expires:</strong></em></div></td>
                <td valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="expires">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['expires']))) {echo "selected=\"selected\"";} ?>>YES</option>
                    <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['expires']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Default Signoff Date:</div></td>
                <td bgcolor="#0C3E43"><div align="left">
                  <input name="default_signoff_date" type="text" value="<?php echo $row_rsSignoffTypes['default_signoff_date']; ?>" size="10" maxlength="10" />
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Duration_days:</strong></em></div></td>
                <td valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="duration_days">
                    <option value="0" <?php if (!(strcmp(0, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>0</option>
                    <option value="1" <?php if (!(strcmp(1, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>1</option>
                    <option value="7" <?php if (!(strcmp(7, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>7</option>
                    <option value="14" <?php if (!(strcmp(14, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>14</option>
                    <option value="30" <?php if (!(strcmp(30, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>30</option>
                    <option value="45" <?php if (!(strcmp(45, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>45</option>
                    <option value="60" <?php if (!(strcmp(60, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>60</option>
                    <option value="90" <?php if (!(strcmp(90, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>90</option>
                    <option value="365" selected="selected" <?php if (!(strcmp(365, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>365</option>
                    <option value="730" <?php if (!(strcmp(730, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>730</option>
					<option value="1825" <?php if (!(strcmp(1825, $row_rsSignoffTypes['duration_days']))) {echo "selected=\"selected\"";} ?>>1825</option>
                  </select>
                </div></td>
                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Default Expire Date:</div></td>
                <td bgcolor="#0C3E43"><div align="left">
                  <input name="default_expire_date" type="text" value="<?php echo $row_rsSignoffTypes['default_expire_date']; ?>" size="10" maxlength="10" />
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Eom_expiry:</strong></em></div></td>
                <td valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="eom_expiry">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['eom_expiry']))) {echo "selected=\"selected\"";} ?>>YES</option>
                      <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['eom_expiry']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Calc Expire Date:</div></td>
                <td bgcolor="#0C3E43"><div align="left">
                  <select name="calc_expire_date">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['calc_expire_date']))) {echo "selected=\"selected\"";} ?>>YES</option>
                      <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['calc_expire_date']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Member Updates:</strong></em></div></td>
                <td valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="member_updates">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['member_updates']))) {echo "selected=\"selected\"";} ?>>YES</option>
                      <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['member_updates']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Active:</div></td>
                <td bgcolor="#0C3E43"><div align="left">
                  <select name="active">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['active']))) {echo "selected=\"selected\"";} ?>>YES</option>
                      <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['active']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style16"><div align="left"><em><strong>Yearly Reset:</strong></em></div></td>
                <td valign="middle" bgcolor="#0C3E43"><div align="left">
                  <select name="yearly_reset">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['yearly_reset']))) {echo "selected=\"selected\"";} ?>>YES</option>
                      <option value="NO" <?php if (!(strcmp("NO", $row_rsSignoffTypes['yearly_reset']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
                <td align="right" valign="middle" nowrap="nowrap" bgcolor="#0C3E43" class="style18"><div align="left">Delete Rrecord:</div></td>
                <td bgcolor="#0C3E43"><div align="left">
                  <select name="delete_record">
                    <option value="YES" <?php if (!(strcmp("YES", $row_rsSignoffTypes['delete_record']))) {echo "selected=\"selected\"";} ?>>YES</option>
                        <option value="NO" selected="selected" <?php if (!(strcmp("NO", $row_rsSignoffTypes['delete_record']))) {echo "selected=\"selected\"";} ?>>NO</option>
                  </select>
                </div></td>
              </tr>
              <tr valign="baseline">
                <td align="right" valign="middle" nowrap bgcolor="#0C3E43" class="style18"><div align="left">DD List Order </div></td>
                <td colspan="3" valign="middle" bgcolor="#0C3E43"><select name="sort_order">
                    <option value="1" <?php if (!(strcmp(1, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>1</option><option value="2" <?php if (!(strcmp(2, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>2</option>
                    <option value="3" <?php if (!(strcmp(3, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>3</option>
                    <option value="4" <?php if (!(strcmp(4, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>4</option>
                    <option value="5" <?php if (!(strcmp(5, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>5</option>
                    <option value="6" <?php if (!(strcmp(6, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>6</option>
                    <option value="7" <?php if (!(strcmp(7, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>7</option><option value="8" <?php if (!(strcmp(8, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>8</option>
                    <option value="9" <?php if (!(strcmp(9, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>9</option>
                    <option value="10" <?php if (!(strcmp(10, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>10</option>
                    <option value="11" <?php if (!(strcmp(11, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>11</option>
                    <option value="12" <?php if (!(strcmp(12, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>12</option>
                    <option value="13" <?php if (!(strcmp(13, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>13</option>
                    <option value="14" <?php if (!(strcmp(14, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>14</option>
                    <option value="15" <?php if (!(strcmp(15, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>15</option>
                    <option value="16" <?php if (!(strcmp(16, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>16</option><option value="17" <?php if (!(strcmp(17, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>17</option>
                    <option value="18" <?php if (!(strcmp(18, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>18</option>
                    <option value="19" <?php if (!(strcmp(19, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>19</option>
                    <option value="20" <?php if (!(strcmp(20, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>20</option>
                    <option value="21" <?php if (!(strcmp(21, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>21</option>
                    <option value="22" <?php if (!(strcmp(22, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>22</option><option value="23" <?php if (!(strcmp(23, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>23</option>
                    <option value="24" <?php if (!(strcmp(24, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>24</option>
                    <option value="25" <?php if (!(strcmp(25, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>25</option>
                    <option value="26" <?php if (!(strcmp(26, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>26</option><option value="27" <?php if (!(strcmp(27, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>27</option>
                    <option value="28" <?php if (!(strcmp(28, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>28</option>
                    <option value="29" <?php if (!(strcmp(29, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>29</option>
                    <option value="30" <?php if (!(strcmp(30, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>30</option>
                    <option value="31" <?php if (!(strcmp(31, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>31</option>
                    <option value="32" <?php if (!(strcmp(32, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>32</option>
                    <option value="33" <?php if (!(strcmp(33, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>33</option>
                    <option value="34" <?php if (!(strcmp(34, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>34</option>
                    <option value="35" <?php if (!(strcmp(35, $row_rsSignoffTypes['sort_order']))) {echo "selected=\"selected\"";} ?>>35</option>
                                </select></td>
                </tr>
            </table>
            <p>
              <input name="submit" type="submit" value="Update record" />
</p>
            <p>
              <input type="hidden" name="MM_update" value="form1">
              <input type="hidden" name="signoffID" value="<?php echo $row_rsSignoffTypes['signoffID']; ?>">
              </p>
          </form>
          <label></label></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php

/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_signoff_types WHERE delete_record = 'YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

mysql_free_result($rsSignoffTypes);

mysql_free_result($rsTargetGroups);

mysql_free_result($rsRatings);
?>