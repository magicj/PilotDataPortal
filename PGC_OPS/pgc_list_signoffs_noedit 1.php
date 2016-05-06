<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php'; ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
require_once('pgc_check_login.php'); 
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
if (isset($_SESSION['MM_PilotName'])) {
  $colname_rsSignoffs = (get_magic_quotes_gpc()) ? $_SESSION['MM_PilotName'] : addslashes($_SESSION['MM_PilotName']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsSignoffs = sprintf("SELECT * FROM pgc_pilot_signoffs WHERE pilot_name = '%s' ORDER BY status ASC", $colname_rsSignoffs);
$rsSignoffs = mysql_query($query_rsSignoffs, $PGC) or die(mysql_error());
$row_rsSignoffs = mysql_fetch_assoc($rsSignoffs);
$totalRows_rsSignoffs = mysql_num_rows($rsSignoffs);

$colname_rsPgcFlyStstus = "-1";
if (isset($_SESSION['MM_PilotName'])) {
  $colname_rsPgcFlyStstus = (get_magic_quotes_gpc()) ? $_SESSION['MM_PilotName'] : addslashes($_SESSION['MM_PilotName']);
}
mysql_select_db($database_PGC, $PGC);
$query_rsPgcFlyStstus = sprintf("SELECT pilot_name, fly_status, pgc_ratings FROM pgc_pilots WHERE pilot_name = '%s'", $colname_rsPgcFlyStstus);
$rsPgcFlyStstus = mysql_query($query_rsPgcFlyStstus, $PGC) or die(mysql_error());
$row_rsPgcFlyStstus = mysql_fetch_assoc($rsPgcFlyStstus);
$totalRows_rsPgcFlyStstus = mysql_num_rows($rsPgcFlyStstus);
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
.style11 {
	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
.style16 {color: #CCCCCC; }
a:link {
	color: #FFFF99;
}
a:visited {
	color: #F7F7F7;
}
.style17 {
	color: #000000;
	font-weight: bold;
}
.style19 {
	color: #000000;
	font-weight: bold;
	font-style: italic;
	font-size: 14px;
}
.box-header
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #E8E8E8;
}
.signoff-row
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	font-weight: normal;
	color: #F8F8F8;
}
.signoff-header
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #CCC;
}
-->
</style></head>

<body>

<table width="950" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  
  <tr>
    <td height="515" align="center"><table width="98%" height="558" align="center" cellpadding="2" cellspacing="2" bordercolor="#005B5B" bgcolor="#5C6167">
      <tr>
          <td height="36" bgcolor="#383F58"><div align="center"><span class="style11">PILOT DATA PORTAL </span></div></td>
      </tr>
      <tr>
        <td height="24" bgcolor="#353C53"><div align="center"><span class="style11">SIGNOFF STATUS </span></div></td>
      </tr>
      <tr>
        <td height="43" align="center" bgcolor="#3E4560"><table width="786" border="0" cellpadding="4" cellspacing="1" bgcolor="#525252">
          <tr>
            <td width="277" bgcolor="#363D54" class="style11"><?php echo $row_rsSignoffs['pilot_name']; ?></td>
            <td width="386" bgcolor="#363D54" class="style11"><?php echo $row_rsPgcFlyStstus['pgc_ratings']; ?></td>
            <td width="103" bgcolor="#363D54" class="style11"><?php echo $row_rsPgcFlyStstus['fly_status']; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="418" align="center" valign="top" bgcolor="#424A66"><table width="890" cellpadding="3" cellspacing="2" bgcolor="#47567A">
          <tr class="box-header">
            <td height="26" bgcolor="#0C3E43"><div align="center" class="signoff-header"><em><strong>SIGNOFF TYPE </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center" class="signoff-header"><em><strong>SIGNOFF DATE</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center" class="signoff-header"><em><strong>SIGNOFF BY</strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center" class="signoff-header"><em><strong>EXPIRE DATE </strong></em></div></td>
            <td bgcolor="#0C3E43"><div align="center" class="signoff-header"><em><strong>STATUS</strong></em></div></td>
          </tr>
          <?php do { ?>
            <tr>
              <td width="200" bgcolor="#0F4E55"><div align="left" class="signoff-row"><?php echo $row_rsSignoffs['signoff_type']; ?></div></td>
              <td width="80" bgcolor="#0F4E55"><div align="center" class="signoff-row"><?php echo $row_rsSignoffs['signoff_date']; ?></div></td>
              <td width="150" bgcolor="#0F4E55"><div align="left" class="signoff-row"><?php echo $row_rsSignoffs['instructor']; ?></div></td>
			  
			  	<?php 			  
				$expire_date = $row_rsSignoffs['expire_date'];
				If ($expire_date == Null) {
					$expire_date = "N/A";
				}
				?>
			  
              <td width="80" bgcolor="#0F4E55"><div align="center" class="signoff-row"><?php echo $expire_date; ?></div></td>
			  
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
              <td width="60" td bgcolor="<?php echo $color; ?>"><div align="center"><span class="style19"><?php echo $row_rsSignoffs['status']; ?></span></div></td>
            </tr>
            <?php } while ($row_rsSignoffs = mysql_fetch_assoc($rsSignoffs)); ?>
        </table>
          <p>&nbsp;</p>
          <form id="form1" name="form1" method="get" action="pgc_list_signoffs_select.php">
            <label></label>
            <label></label>
          </form>          
          <p>&nbsp;</p></td>
      </tr>
      <tr>
        <td height="23" align="center" valign="top" bgcolor="#424A66"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php


/* Also in pgc_modify_signoff_detail.php */


mysql_free_result($rsSignoffs);

mysql_free_result($rsPgcFlyStstus);
?>
