<?php require_once('../Connections/PGC.php'); 
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php');  
$_SESSION['last_query'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
//echo $_SESSION[last_query];
//require_once('pgc_check_form_access.php'); 
$_SESSION['signoff_type'] = $_GET['signoff_type'];
$_SESSION['instructor'] = $_GET['instructor'];
$_SESSION['signoff_date'] = date("Y-m-d");
if (isset($_GET['signoff_date'])) {
$_SESSION['signoff_date'] = $_GET['signoff_date'];
}
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rsSignoffs = 10;
$pageNum_rsSignoffs = 0;
if (isset($_GET['pageNum_rsSignoffs'])) {
  $pageNum_rsSignoffs = $_GET['pageNum_rsSignoffs'];
}
$startRow_rsSignoffs = $pageNum_rsSignoffs * $maxRows_rsSignoffs;
$maxRows_rsSignoffs = 20;
$pageNum_rsSignoffs = 0;
if (isset($_GET['pageNum_rsSignoffs'])) {
  $pageNum_rsSignoffs = $_GET['pageNum_rsSignoffs'];
}
$startRow_rsSignoffs = $pageNum_rsSignoffs * $maxRows_rsSignoffs;

$colname_rsSignoffs = "-1";
if (isset($_SESSION['signoff_type'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_SESSION['signoff_type'] : addslashes($_SESSION['signoff_type']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs A, pgc_members B WHERE A. signoff_type = '%s' AND (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC", $colname_rsSignoffs);
$query_limit_rsSignoffs = sprintf("%s LIMIT %d, %d", $query_rsSignoffs, $startRow_rsSignoffs, $maxRows_rsSignoffs);
$rsSignoffs = mysql_query($query_limit_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);

if (isset($_GET['totalRows_rsSignoffs'])) {
  $totalRows_rsSignoffs = $_GET['totalRows_rsSignoffs'];
} else {
  $all_rsSignoffs = mysql_query($query_rsSignoffs);
  $totalRows_rsSignoffs = mysql_num_rows($all_rsSignoffs);
}
$totalPages_rsSignoffs = ceil($totalRows_rsSignoffs/$maxRows_rsSignoffs)-1;

mysql_select_db($database_PGC, $PGC);
$query_rsPilots = "SELECT description FROM pgc_signoff_types ORDER BY description ASC";
$rsPilots = mysql_query($query_rsPilots, $PGC) or die(mysql_error());
$row_rsPilots = mysql_fetch_assoc($rsPilots);
$totalRows_rsPilots = mysql_num_rows($rsPilots);

mysql_select_db($database_PGC, $PGC);
$query_rsInstructors = "SELECT Name FROM pgc_instructors WHERE rec_active = 'Y' ORDER BY Name ASC";
$rsInstructors = mysql_query($query_rsInstructors, $PGC) or die(mysql_error());
$row_rsInstructors = mysql_fetch_assoc($rsInstructors);
$totalRows_rsInstructors = mysql_num_rows($rsInstructors);

$queryString_rsSignoffs = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsSignoffs") == false && 
        stristr($param, "totalRows_rsSignoffs") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsSignoffs = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsSignoffs = sprintf("&totalRows_rsSignoffs=%d%s", $totalRows_rsSignoffs, $queryString_rsSignoffs);
?>
<?php
require_once('pgc_signoff_table_updates.php');
?>
<?php require_once('../Connections/PGC.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - PGC Pilot Signoff Status</title>
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
.style11 {font-size: 16px; font-weight: bold; }
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
a:visited {
	color: #FFCC99;
}
.style19 {color: #000000; font-weight: bold; font-style: italic; }
-->
</style></head>

<body>

<table width="860" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#666666">
  <tr>
    <td width="848"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="307"><table width="98%" height="262" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#4F5359">
      <tr>
        <td height="36" bgcolor="#AA3700"><div align="center"><span class="style11"> UPDATE PILOT SIGNOFFS - BY SIGNOFF TYPE </span></div></td>
      </tr>
      <tr>
        <td height="36" bgcolor="#4F5359"><table width="85%" border="0" align="center">
            <tr>
              <td width="66%"><strong><?php echo "DEFAULT SIGNER: ". $_SESSION[instructor]  ?></strong></td>
              <td width="34%"><strong><?php echo "DEFAULT SIGNOFF DATE: " . $_SESSION[signoff_date] ?></strong></td>
              </tr>
          </table></td>
      </tr>
      <tr>
        <td height="153" align="center" valign="top" bgcolor="#4F5359"><table width="791" cellpadding="2" cellspacing="2" bordercolor="#424775" bgcolor="#424775">
          <tr>
            <td width="20" bgcolor="#0C3E43"><div align="center"><em><strong>ID</strong></em></div></td>
            <td width="150" bgcolor="#0C3E43"><div align="center"><em><strong>Pilot Name</strong></em></div></td>
            <td width="200" bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Type </strong></em></div></td>
            <td width="80" bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Date </strong></em></div></td>
            <td width="150" bgcolor="#0C3E43"><div align="center"><em><strong>Signed By</strong></em></div></td>
            <td width="60" bgcolor="#0C3E43"><div align="center"><em><strong>Status</strong></em></div></td>
          </tr>
          <?php do { ?>
            <tr>
              <td width="30" bgcolor="#0C3E43"><a href="pgc_modify_signoff_detail_bytype.php?signoffID=<?php echo $row_rsSignoffs['signoffID']; ?>"><?php echo $row_rsSignoffs['signoffID']; ?></a></td>
              <td width="150" bgcolor="#0C3E43"><div align="left"><?php echo $row_rsSignoffs['pilot_name']; ?></div></td>
              <td width="120" bgcolor="#0C3E43"><div align="left"><?php echo $row_rsSignoffs['signoff_type']; ?></div></td>
              <td bgcolor="#0C3E43"><div align="center"><?php echo $row_rsSignoffs['signoff_date']; ?></div></td>
              <td bgcolor="#0C3E43"><div align="left"><?php echo $row_rsSignoffs['instructor']; ?></div></td>


  			  <?php
			  $expire_date = $row_rsSignoffs['expire_date'];
			  if ($row_rsSignoffs['expire_date'] == NULL) {
			  $expire_date = "N/A "; 
			  }
			  ?>

              <?php
			  $color = "#0F4E55"; 
			  if ($row_rsSignoffs['status'] == "Expired-A") {
			  $color = "#CC0000"; 
			  }
 			  if ($row_rsSignoffs['status'] == "Expired-B") {
			  $color = "#FF9933"; 
			  }
			   if ($row_rsSignoffs['status'] == "OK") {
			  $color = "#33CC00"; 
			  }

              ?>
              <td td bgcolor="<?php echo $color; ?>"><div align="center"><span class="style19"><?php echo $row_rsSignoffs['status']; ?></span></div></td>
            </tr>
            <?php } while ($row_rsSignoffs = mysql_fetch_assoc($rsSignoffs)); ?>
        </table>
          <table width="50%" border="0" align="center" bgcolor="#CCCCCC">
            <tr>
              <td width="23%" align="center"><?php if ($pageNum_rsSignoffs > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsSignoffs=%d%s", $currentPage, 0, $queryString_rsSignoffs); ?>"><img src="First.gif" border=0></a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="31%" align="center"><?php if ($pageNum_rsSignoffs > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_rsSignoffs=%d%s", $currentPage, max(0, $pageNum_rsSignoffs - 1), $queryString_rsSignoffs); ?>"><img src="Previous.gif" border=0></a>
                    <?php } // Show if not first page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsSignoffs < $totalPages_rsSignoffs) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsSignoffs=%d%s", $currentPage, min($totalPages_rsSignoffs, $pageNum_rsSignoffs + 1), $queryString_rsSignoffs); ?>"><img src="Next.gif" border=0></a>
                    <?php } // Show if not last page ?>
              </td>
              <td width="23%" align="center"><?php if ($pageNum_rsSignoffs < $totalPages_rsSignoffs) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_rsSignoffs=%d%s", $currentPage, $totalPages_rsSignoffs, $queryString_rsSignoffs); ?>"><img src="Last.gif" border=0></a>
                    <?php } // Show if not last page ?>
              </td>
            </tr>
          </table>
          <label></label>
          </p>
          <p>&nbsp;</p>
          <form id="form1" name="form1" method="get" action="pgc_list_signoffs_klaus.php">
            <table width="85%" border="0">
              <tr>
                  <td><em><strong>SELECT DEFAULT SIGNER </strong></em></td>
                  <td><strong><em>ENTER DEFAULT DATE </em></strong></td>
                  <td colspan="2"><em><strong>SELECT SIGNOFF TYPE </strong></em></td>
                </tr>
              <tr>
                <td width="28%"><select name="instructor" id="instructor">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsInstructors['Name']?>"<?php if (!(strcmp($row_rsInstructors['Name'], $_SESSION[instructor]))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsInstructors['Name']?></option>
                    <?php
} while ($row_rsInstructors = mysql_fetch_assoc($rsInstructors));
  $rows = mysql_num_rows($rsInstructors);
  if($rows > 0) {
      mysql_data_seek($rsInstructors, 0);
	  $row_rsInstructors = mysql_fetch_assoc($rsInstructors);
  }
?>
                </select></td>
                <td width="45%">
                  <label></label>
                  <label>
				  
                  <input name="signoff_date" type="text" id="signoff_date" value="<?php echo $_SESSION[signoff_date] ?>" size="15" maxlength="10" />
                  </label></td>
                <td width="16%"><select name="signoff_type" type="text" id="signoff_type">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsPilots['description']?>"<?php if (!(strcmp($row_rsPilots['description'], $_SESSION[signoff_type]))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPilots['description']?></option>
                  <?php
} while ($row_rsPilots = mysql_fetch_assoc($rsPilots));
  $rows = mysql_num_rows($rsPilots);
  if($rows > 0) {
      mysql_data_seek($rsPilots, 0);
	  $row_rsPilots = mysql_fetch_assoc($rsPilots);
  }
?>
                </select></td>
                <td width="11%"><input type="submit" name="Submit" value="Submit" /></td>
              </tr>
            </table>
          </form>          
          </td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top" bgcolor="#4F5359"><strong class="style11"><a href="../PGC_OPS/pgc_portal_menu.php" class="style16">BACK TO MAIN</a> </strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php

/* Also in pgc_modify_signoff_detail.php

///* Do Updates - Make this a function */
//mysql_select_db($database_PGC, $PGC);
//
///* Purge Deletions */
//$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
//$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());
//
///* Set both dates to 0000-00-00 */
//$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to OK */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'OK'";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Expired-C' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 90 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 90 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 90 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 730 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 365 Exact Day Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Calc 730 Month End Expiry */ 
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
// 
///* Calc 365 Month End Expiry */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Not Valid' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* Set Expired to NG */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-A' WHERE (A.expire_date < CURDATE()) AND B.expires = 'YES' AND B.group_id = 'A' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-B' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'B' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-C' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'C' AND A.signoff_type = B.description";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* NULL Non Expiring  */
//$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = NULL WHERE A.signoff_type = B.description AND B.expires ='NO'";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
///* UPDATE Pilot Ratings */
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = ''";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
//
//$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
//$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
// 


mysql_free_result($rsSignoffs);

mysql_free_result($rsPilots);

mysql_free_result($rsInstructors);
?>
