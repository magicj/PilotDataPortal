<?php require_once('../Connections/PGC.php'); ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require_once('pgc_check_login.php'); ?>
<?php
/* Batch Updates */
mysql_select_db($database_PGC, $PGC);
/* Sync roster table up with member table - i.e. add new members  */
$insertSQL = "INSERT IGNORE INTO pgc_member_roster(customer)Select NAME FROM pgc_members";
$ResultA = mysql_query($insertSQL, $PGC) or die(mysql_error());
/* Refresh E-mail address in roster table */   
$updateSQL = "UPDATE pgc_member_roster A, pgc_members B SET A.email = B.USER_ID, A.active = B.active WHERE A.customer = B.NAME";
$ResultB = mysql_query($updateSQL, $PGC) or die(mysql_error());
?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = "SELECT customer, phone, alt_phone, street, city, `state`, zip, email, customer_type, cell_number FROM pgc_member_roster WHERE active = 'YES' ORDER BY customer ASC";
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

session_start();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC Data Portal - Member Roster</title>
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
.style2 {
	font-size: 14px;
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
.style25 {font-weight: bold; color: #A7B5CE;}
.style27 {
	font-size: 10;
	color: #FBFBFB;
}
.style30 {
	font-size: 13px
}
.rosterHead
{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #F2F2F2;
}
.style11 {	font-size: 15px;
	font-weight: bold;
	color: #EFEFEF;
}
-->
</style></head>

<body>
<div align="center"></div>
<table width="1342" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#595E80">
  <tr>
    <td width="1332" align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
  </tr>
  <tr>
    <td height="440" bgcolor="#666666"><table width="100%" height="576" align="center" cellpadding="4" cellspacing="3" >
        <tr>
            <td height="67" bgcolor="#424A66"><div align="center" class="style2">
                <table width="90%" border="0" cellspacing="5" cellpadding="0">
                    <tr>
                          <td width="13%" height="17" align="left"><a href="pgc_active_members_xls.php">EXCEL WORKSHEET</a></td>
                        <td width="74%"><div align="center" class="rosterHead">PGC ACTIVE MEMBER ROSTER</div></td>
                        <td width="13%">&nbsp; </td>
                    </tr>
                    <tr>
                          <td height="28" colspan="3"><div align="center"><span class="style30">Use the PDP Roster Update function to enter or change your information - the PDP will send an e-mail of the changes to the PGC Treasurer </span></div></td>
                        </tr>
                </table>
            </div></td>
        </tr>
        <tr>
            <td height="465" align="center" valign="top" bgcolor="#424A66"><table width="26%" border="0" align="center" cellspacing="2">
                <tr>
                    <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" alt="a" border="0" /></a>
                            <?php } // Show if not first page ?>
                    </td>
                    <td width="31%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" alt="a" border="0" /></a>
                            <?php } // Show if not first page ?>
                    </td>
                    <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" alt="a" border="0" /></a>
                            <?php } // Show if not last page ?>
                    </td>
                    <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                            <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" alt="a" border="0" /></a>
                            <?php } // Show if not last page ?>
                    </td>
                </tr>
            </table>
                <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#36373A">
                        <tr>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">MEMBER</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">HOME</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">WORK</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">CELL</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">EMAIL</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">STREET</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">CITY</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">ST</span></div></td>
                            <td bgcolor="#35425B" class="style17"><div align="center"><span class="style25">ZIP</span></div></td>
                            </tr>
                        <?php do { ?>
                        <tr>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['customer']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['phone']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['alt_phone']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['cell_number']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['email']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['street']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['city']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['state']; ?></span></td>
                            <td bgcolor="#35425B"><span class="style27"><?php echo $row_Recordset1['zip']; ?></span></td>
                            </tr>
                        <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                    </table>
                    <table width="26%" border="0" align="center" cellspacing="2">
                        <tr>
                            <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>"><img src="First.gif" border=0></a>
                                        <?php } // Show if not first page ?>
                            </td>
                            <td width="31%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>"><img src="Previous.gif" border=0></a>
                                        <?php } // Show if not first page ?>
                            </td>
                            <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>"><img src="Next.gif" border=0></a>
                                        <?php } // Show if not last page ?>
                            </td>
                            <td width="23%" align="center" bgcolor="#656A72"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>"><img src="Last.gif" border=0></a>
                                        <?php } // Show if not last page ?>
                            </td>
                        </tr>
                    </table>
                    </p></td>
        </tr>
        <tr>
            <td height="30" bgcolor="#4F5359" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17"><strong class="style11"><a href="../07_members_only_pw.php"><img src="../images/Buttons/GoMembers.jpg" width="133" height="24" alt="Members" /></a></strong></a></div></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
 