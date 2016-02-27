<?php require_once('../Connections/PGC.php');
error_reporting(0); ?>
<?php
require_once('pgc_check_login_admin.php'); 
 
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
  $insertSQL = sprintf("INSERT INTO pgc_signoff_types (signoffID, description, target_group, target_group_id, active) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['signoffID'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['target_group'], "text"),
                       GetSQLValueString($_POST['target_group_id'], "int"),
                       GetSQLValueString($_POST['active'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());

  $insertGoTo = "pgc_insert_signoff_type.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

	
$signdesc = check_input($_POST['description']);
echo $signdesc;


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO pgc_signoff_types (signoffID, description, target_group, expires, duration_days, eom_expiry, active) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['signoffID'], "int"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['target_group'], "text"),
                       GetSQLValueString($_POST['expires'], "text"),
                       GetSQLValueString($_POST['duration_days'], "int"),
                       GetSQLValueString($_POST['eom_expiry'], "text"),
                       GetSQLValueString($_POST['active'], "text"));

  mysql_select_db($database_PGC, $PGC);
  $Result1 = mysql_query($insertSQL, $PGC) or die(mysql_error());
}

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT * FROM pgc_signoff_types";
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
$query_rsRatingList = "SELECT rating_name FROM pgc_ratings_list ORDER BY rating_name ASC";
$rsRatingList = mysql_query($query_rsRatingList, $PGC) or die(mysql_error());
$row_rsRatingList = mysql_fetch_assoc($rsRatingList);
$totalRows_rsRatingList = mysql_num_rows($rsRatingList);

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

$currentPage = $_SERVER["PHP_SELF"];

$queryString_Signoff_Types = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Signoff_Types") == false && 
        stristr($param, "totalRows_Signoff_Types") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Signoff_Types = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Signoff_Types = sprintf("&totalRows_Signoff_Types=%d%s", $totalRows_Signoff_Types, $queryString_Signoff_Types);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Add Signoff Type</title>
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
.style3 {font-size: 16px; font-weight: bold; }
a:link {
	color: #FFFF99;
}
a:visited {
	color: #FFCC66;
}
.style17 {font-size: 14; font-weight: bold; }
.style18 {font-size: 14px}
-->
</style></head>

<body>
<div align="center"></div>
<table width="997" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="987"><div align="center"><span class="style1"> PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="510"><table width="92%" height="475" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="46" bgcolor="#3A3C5A"><div align="center" class="style2">CURRENT SIGNOFF TYPES </div></td>
      </tr>
      <tr>
        <td height="398" bgcolor="#3A3C5A"><table width="97%" align="center" cellpadding="2" cellspacing="2" bgcolor="#0F4E55">
          <tr>
            <td width="15" bgcolor="#0C3E43"><div align="center">Signoff ID</div></td>
            <td width="150" bgcolor="#0C3E43"><div align="center">Description</div></td>
            <td width="80" bgcolor="#0C3E43"><div align="center">Target Group</div></td>
            <td width="20" bgcolor="#0C3E43"><div align="center">Expires </div></td>
            <td width="20" bgcolor="#0C3E43"><div align="center">Duration (Days) </div></td>
            <td width="20" bgcolor="#0C3E43"><div align="center">EOM Expiry </div></td>
            <td width="13" bgcolor="#0C3E43"><div align="center">Active</div></td>
          </tr>
          <?php do { ?>
          <tr>
            <td bgcolor="#115860"><div align="center"><?php echo $row_Recordset1['signoffID']; ?></div></td>
            <td bgcolor="#115860"><?php echo $row_Recordset1['description']; ?></td>
            <td width="145" bgcolor="#115860"><?php echo $row_Recordset1['target_group']; ?></td>
            <td width="13" bgcolor="#115860"><div align="center"><?php echo $row_Recordset1['expires']; ?></div></td>
            <td width="13" bgcolor="#115860"><div align="center"><?php echo $row_Recordset1['duration_days']; ?></div></td>
            <td width="80" bgcolor="#115860"><div align="center"><?php echo $row_Recordset1['eom_expiry']; ?></div></td>
            <td width="13" bgcolor="#115860"><div align="center"><?php echo $row_Recordset1['active']; ?></div></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </table>
          
          <table border="0" width="50%" align="center">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                    <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                    <?php } // Show if not last page ?>
              </td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <table width="512" align="center" cellpadding="2" cellspacing="2" bordercolor="#002F17" bgcolor="#0C3E43">
            <tr>
              <td height="248" valign="top" bgcolor="#3E435E"><p align="center"><span class="style2">ADD NEW SIGNOFF TYPE </span></p>
                <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                  <table align="center" cellpadding="2" cellspacing="1" bgcolor="#666666">

                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">
                              <div align="left">DESCRIPTION</div>
                      </div></td>
                      <td valign="middle" bgcolor="#292C4B"><input type="text" name="description" value="" size="32"></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">TARGET GROUP </div></td>
                      <td valign="middle" bgcolor="#292C4B"><select name="target_group">
                        <?php
do {  
?>
                        <option value="<?php echo $row_rsRatingList['rating_name']?>"><?php echo $row_rsRatingList['rating_name']?></option>
                        <?php
} while ($row_rsRatingList = mysql_fetch_assoc($rsRatingList));
  $rows = mysql_num_rows($rsRatingList);
  if($rows > 0) {
      mysql_data_seek($rsRatingList, 0);
	  $row_rsRatingList = mysql_fetch_assoc($rsRatingList);
  }
?>
                      </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">
                              <div align="left">EXPIRES</div>
                      </div></td>
                      <td valign="middle" bgcolor="#292C4B"><select name="expires">
                        <option value="NO">NO</option>
                        <option value="YES" selected="selected">YES</option>
                                            </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">
                              <div align="left">DURATION DAYS </div>
                      </div></td>
                      <td valign="middle" bgcolor="#292C4B"><select name="duration_days">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="7">7</option>
                        <option value="14">14</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                        <option value="60">60</option>
                        <option value="90">90</option>
                        <option value="365">365</option>
                        <option value="730">730</option>
                                                                                        </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">
                              <div align="left">EOM EXPIRY </div>
                      </div></td>
                      <td valign="middle" bgcolor="#292C4B"><select name="eom_expiry">
                        <option value="NO" selected="selected">NO</option>
                        <option value="YES">YES</option>
                                            </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td align="right" valign="middle" nowrap bgcolor="#292C4B" class="style17"><div align="left" class="style18">ACTIVE</div></td>
                      <td valign="middle" bgcolor="#292C4B"><select name="active">
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                                            </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td colspan="2" align="right" valign="middle" nowrap bgcolor="#292C4B"><div align="left"></div>                              
                              <div align="center">
                                      <input type="submit" value="Insert record">
                              </div></td>
                      </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form2">
                </form>
                </td>
            </tr>
          </table>
          <p>&nbsp;</p>
          </td>
      </tr>
      <tr>
        <td height="21"><div align="center"><strong class="style3"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a></strong></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsRatingList);
?>
<?php
function check_input($data, $problem='')
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if ($problem && strlen($data) == 0)
    {
        show_error($problem);
    }
    return $data;
}

function show_error($myError)
{
?>
    <html>
    <body>

    <b>Please correct the following error:</b><br />
    <?php echo $myError; ?>

    </body>
    </html>
<?php
exit();
}
?>