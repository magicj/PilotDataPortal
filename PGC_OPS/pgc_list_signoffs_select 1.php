<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
?>
<?php
session_start();
//require_once('pgc_check_login_admin.php'); 
$_SESSION[last_pilot] = $_GET['pgc_pilot'];
$_SESSION[last_signoff_pilot] = $_GET['pgc_pilot'];
$_SESSION[last_query] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
$_SESSION['last_signoff_select'] = $_SERVER["PHP_SELF"] . "?" . $_SERVER['QUERY_STRING'];
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_rsSignoffs = 10;
$pageNum_rsSignoffs = 0;
if (isset($_GET['pageNum_rsSignoffs'])) {
  $pageNum_rsSignoffs = $_GET['pageNum_rsSignoffs'];
}
$startRow_rsSignoffs = $pageNum_rsSignoffs * $maxRows_rsSignoffs;
$colname_rsSignoffs = "-1";
if (isset($_GET['pgc_pilot'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_GET['pgc_pilot'] : addslashes($_GET['pgc_pilot']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs WHERE pilot_name = '%s' ORDER BY status ASC", $colname_rsSignoffs);
$rsSignoffs = mysql_query($query_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);
$totalRows_rsSignoffs = mysql_num_rows($rsSignoffs);

mysql_select_db($database_PGC, $PGC);
$query_rsPilots = "SELECT A.pilot_name, A.fly_status FROM pgc_pilots A, pgc_members B WHERE (A.pilot_name = B.NAME) AND (B.active = 'YES') ORDER BY A.pilot_name ASC";
$rsPilots = mysql_query($query_rsPilots, $PGC) or die(mysql_error());
$row_rsPilots = mysql_fetch_assoc($rsPilots);
$totalRows_rsPilots = mysql_num_rows($rsPilots);

$colname_rsPgcFlyStstus = "-1";
if (isset($_GET['pgc_pilot'])) {
  $colname_rsPgcFlyStstus = (get_magic_quotes_gpc()) ? $_GET['pgc_pilot'] : addslashes($_GET['pgc_pilot']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsPgcFlyStstus = sprintf("SELECT pilot_name, fly_status, pgc_ratings FROM pgc_pilots WHERE pilot_name = '%s'", $colname_rsPgcFlyStstus);
$rsPgcFlyStstus = mysql_query($query_rsPgcFlyStstus, $PGC) or die(mysql_error());
$row_rsPgcFlyStstus = mysql_fetch_assoc($rsPgcFlyStstus);
$totalRows_rsPgcFlyStstus = mysql_num_rows($rsPgcFlyStstus);
?>
<?php
//require_once('../pgc_signoff_table_updates.php')
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
.style20 {color: #525252}
-->
</style></head>

<body>

<table width="900" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="515"><table width="92%" height="527" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#464762">
      <tr>
        <td height="36" bgcolor="#4F5359"><div align="center"><span class="style11">LIST / MODIFY  PILOT SIGNOFFS </span></div></td>
      </tr>
      <tr>
        <td height="36"><table width="782" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
            <td width="225" bgcolor="#525252" class="style11"><?php echo $row_rsSignoffs['pilot_name']; ?></td>
            <td width="469" bgcolor="#525252" class="style11"><?php echo $row_rsPgcFlyStstus['pgc_ratings']; ?></td>
            <td width="37" bgcolor="#525252" class="style11"> <span class="style11 style20">1<?php echo rand(1,999999); ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="418" align="center" valign="top" bgcolor="#424A66"><table width="786" cellpadding="2" cellspacing="2" bgcolor="#47567A">
          <tr>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>ID</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Type </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Signoff Date </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Signoff By</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Expire Date </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center"><em><strong>Status</strong></em></div></td>
          </tr>
          <?php do { ?>
            <tr>
              <td width="20" bgcolor="#0F4E55"><a href="pgc_modify_signoff_detail.php?signoffID=<?php echo $row_rsSignoffs['signoffID']; ?>"><?php echo $row_rsSignoffs['signoffID']; ?></a></td>
              <td width="200" bgcolor="#0F4E55"><div align="left"><?php echo $row_rsSignoffs['signoff_type']; ?></div></td>
              <td width="80" bgcolor="#0F4E55"><div align="center"><?php echo $row_rsSignoffs['signoff_date']; ?></div></td>
              <td width="150" bgcolor="#0F4E55"><div align="left"><?php echo $row_rsSignoffs['instructor']; ?></div></td>
			  
				<?php 			  
				$expire_date = $row_rsSignoffs['expire_date'];
				If ($expire_date == Null) {
					$expire_date = "N/A";
				}
				?>
				  			  
              <td width="80" bgcolor="#0F4E55"><div align="center"><?php echo $expire_date; ?></div></td><?php
			  
			  
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
              <td width="60" td bgcolor="<?php echo $color; ?>"><div align="center"><span class="style19"><?php echo $row_rsSignoffs['status']; ?></span></div></td>
            </tr>
            <?php } while ($row_rsSignoffs = mysql_fetch_assoc($rsSignoffs)); ?>
        </table>
          <p>&nbsp;</p>
          <form id="form1" name="form1" method="get" action="pgc_list_signoffs_select.php">
            <label>
              <select name="pgc_pilot" type="text" id="pgc_pilot">
                  <?php
do {  
?><option value="<?php echo $row_rsPilots['pilot_name']?>"<?php if (!(strcmp($row_rsPilots['pilot_name'], $_SESSION[last_pilot]))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsPilots['pilot_name']?></option>
                  <?php
} while ($row_rsPilots = mysql_fetch_assoc($rsPilots));
  $rows = mysql_num_rows($rsPilots);
  if($rows > 0) {
      mysql_data_seek($rsPilots, 0);
	  $row_rsPilots = mysql_fetch_assoc($rsPilots);
  }
?>
              </select>
              </label>
            <label>
            <input type="submit" name="Submit" value="Submit" />
            </label>
          </form>          
          <p><em><strong>Click on ID to Edit or Delete a signoff record. </strong></em></p></td>
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
//
/* Do Updates - Make this a function */
mysql_select_db($database_PGC, $PGC);

/* Purge Deletions */
$deleteSQL = "DELETE FROM pgc_pilot_signoffs WHERE delete_record = 'YES'";
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());

/* Set both dates to 0000-00-00 */
$runSQL = "UPDATE pgc_pilot_signoffs SET expire_date = '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to OK */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'OK'";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Expired-C' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 90 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 90 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 90 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 730 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 730 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 1825 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 1825 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 1825 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 365 Exact Day Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = DATE_ADD(A.signoff_date, INTERVAL 365 DAY)WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES'AND B.eom_expiry = 'NO' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 730 Month End Expiry */ 
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 730 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 730 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Calc 1825 Month End Expiry */ 
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 1825 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 1825 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

 
/* Calc 365 Month End Expiry */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = LAST_DAY(DATE_ADD(A.signoff_date, INTERVAL 365 DAY)) WHERE A.signoff_type = B.description AND B.duration_days = 365 AND B.expires = 'YES' AND B.eom_expiry = 'YES' AND A.signoff_date <> '0000-00-00'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs SET status = 'Not Valid' WHERE signoff_date ='0000-00-00' OR signoff_date = NULL";  
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* Set Expired to NG */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-A' WHERE (A.expire_date < CURDATE()) AND B.expires = 'YES' AND B.group_id = 'A' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-B' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'B' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.status = 'Expired-C' WHERE A.expire_date < CURDATE() AND B.expires = 'YES' AND B.group_id = 'C' AND A.signoff_type = B.description";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* NULL Non Expiring  */
$runSQL = "UPDATE pgc_pilot_signoffs A, pgc_signoff_types B SET A.expire_date = NULL WHERE A.signoff_type = B.description AND B.expires ='NO'";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

/* UPDATE Pilot Ratings */
$runSQL = "UPDATE pgc_pilots SET pgc_ratings = ''";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());

$runSQL = "UPDATE pgc_pilots SET pgc_ratings = (SELECT GROUP_CONCAT(DISTINCT pgc_rating SEPARATOR ', ') FROM pgc_pilot_ratings WHERE pgc_pilots.pilot_name = pgc_pilot_ratings.pilot_name GROUP BY pilot_name)";
$Result1 = mysql_query($runSQL, $PGC) or die(mysql_error());
 

mysql_free_result($rsSignoffs);

mysql_free_result($rsPilots);

mysql_free_result($rsPgcFlyStstus);
?>
