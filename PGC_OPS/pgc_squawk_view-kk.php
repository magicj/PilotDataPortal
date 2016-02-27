<?php require_once('../Connections/PGC.php'); ?><?php require_once('../Connections/PGC.php');
error_reporting(0); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
} 
if (!isset($_SESSION['sq_status'])) {
  $_SESSION['sq_status'] = 'ALL';
}
$_SESSION['sq_status'] = $_POST[select1]; $_SESSION['sq_xxx'] = $_POST[select]; 
/* $_SESSION['sq_status'] = 'OPEN'; */
$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_SESSION['sq_status'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['sq_status'] : addslashes($_SESSION['sq_status']);
}

if ($_SESSION['sq_status'] <> 'ALL') {
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_squawk WHERE sq_status = '%s' ORDER BY date_entered DESC", $colname_Recordset1);
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
}
if ($_SESSION['sq_status'] == 'ALL') {
mysql_select_db($database_PGC, $PGC);
$query_Recordset1 = sprintf("SELECT * FROM pgc_squawk ORDER BY date_entered DESC");
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $PGC) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
}
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

  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PGC EQUIPMENT SQUAWK VIEW</title>
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
.style42 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #E2E2E2;
}
.style49 {color: #FFFFFF}
.style54 {	font-size: 14px;
	font-weight: bold;
	color: #FF6600;
}
.style56 {font-size: 14px; font-weight: bold; font-style: italic; color: #E2E2E2; }
.style57 {color: #9BA3D2}
-->
</style>
</head>
<body>
<table width="1200" height="95%" align="center" cellpadding="2" cellspacing="2" bordercolor="#000033" bgcolor="#000033">
      <tr>
            <td align="center" bgcolor="#666666"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
      </tr>
      <tr>
            <td height="521" bgcolor="#666666"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#003648">
                        <tr>
                              <td width="1562" height="26" valign="middle" bgcolor="#005B5B"><div align="center">
                                <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="52%" class="style54"><div align="center"><a href="pgc_maintenance_menu.php"><img src="Graphics/TestMenu copy.png" alt="TestMenu" width="130" height="30" border="0" /></a></div></td>
                                          <td width="5%">&nbsp;</td>
                                          <td width="43%">&nbsp;</td>
                                        </tr>
                                    </table></td>
                                    <td width="30%"><div align="center"><span class="style42">SQUAWK  LIST</span></div></td>
                                    <td width="35%"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="52%" class="style54"><div align="center"></div></td>
                                          <td width="5%">&nbsp;</td>
                                          <td width="43%">&nbsp;</td>
                                        </tr>
                                    </table></td>
                                  </tr>
                                </table>
                              </div></td>
                        </tr>
                        <tr>
                          <td height="464" align="center" valign="top" bgcolor="#005B5B"><p><span class="style54 style58 style57">Select SQUAWK ID to Add Work Tasks and Hardware needed to remedy issue</span><span class="style57">&nbsp;</span></p>
                            <form id="form1" name="form1" method="post" action="">
                              <p>&nbsp;</p>
                              <table width="462" border="0" cellspacing="0" cellpadding="0">
                                
                                <tr>
                                  <td width="244"><select name="select" size="1">
                                    <option value="AAAAAAAAAAAAA" selected="selected">AAAAAAAAAAAA</option>
                                    <option value="BBBBBBBBBBBBbB">BBBBBBBBBBB</option>
                                  </select>                                  </td>
                                  <td width="32">&nbsp;</td>
                                  <td width="167"><select name="select1">
								   <option value="ALL"   <?php if ($_SESSION['sq_status'] == 'ALL') {echo "selected=\"selected\"";} ?>>ALL</option>
                                    <option value="OPEN"   <?php if ($_SESSION['sq_status'] == 'OPEN') {echo "selected=\"selected\"";} ?>>OPEN</option>
                                    <option value="CLOSED" <?php if ($_SESSION['sq_status'] == 'CLOSED') {echo "selected=\"selected\"";} ?>>CLOSED</option>
                                    </select>
                                    <input type="submit" name="Submit" value="Submit" />                                    </td>
                                  <td width="19">&nbsp;</td>
                                </tr>
                              </table>
                              <p>&nbsp;  </p>
                              <table width="400" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="176"><?php echo $_SESSION['sq_status'] ?>&nbsp;</td>
                                <td width="168"><?php echo $_SESSION['sq_xxx'] ?>&nbsp;</td>
                                <td width="27">&nbsp;</td>
                                <td width="29">&nbsp;</td>
                              </tr>
                            </table>
                            </form>
                            <table width="95%" cellpadding="4" cellspacing="3" bgcolor="#A2B3B3">
                              <tr>
                                <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>SQUAWK ID </strong></em></div></td>
                                <td width="120" bgcolor="#35415B"><div align="center" class="style16"><em><strong>ENTERED</strong></em></div></td>
                                <td width="100" bgcolor="#35415B"><div align="center" class="style16"><em><strong>MEMBER</strong></em></div></td>
                                <td width="80" bgcolor="#35415B"><div align="center" class="style16"><em><strong>OCCURED</strong></em></div></td>
                                <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>EQUIPMENT</strong></em></div></td>
                                <td bgcolor="#35415B"><div align="center" class="style16"><em><strong>PROBLEM</strong></em></div></td>
                                <td width="50" bgcolor="#35415B"><div align="center" class="style16"><em><strong>STATUS</strong></em></div></td>
                              </tr>
                              <?php do { ?>
                              <tr>
                                <td bgcolor="#48597B"><div align="center"><span class="style49"><a href="pgc_squawk_work.php?sq_id=<?php echo $row_Recordset1['sq_key'];?>"><?php echo $row_Recordset1['sq_key']; ?></a></span></div></td>
                                <td bgcolor="#48597B"><span class="style49"><?php echo $row_Recordset1['date_entered']; ?></span></td>
                                <td bgcolor="#48597B"><span class="style49"><?php echo $row_Recordset1['id_name']; ?></span></td>
                                <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Recordset1['sq_date']; ?></span></div></td>
                                <td width="130" bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Recordset1['sq_equipment']; ?></span></div></td>
                                <td bgcolor="#48597B"><div align="left"><span class="style49"><?php echo $row_Recordset1['sq_issue']; ?></span></div></td>
                                <td bgcolor="#48597B"><div align="center"><span class="style49"><?php echo $row_Recordset1['sq_status']; ?></span></div></td>
                              </tr>
                              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                            </table>
                            <table border="0" width="50%" align="center">
                              <tr>
                                <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                                <?php } // Show if not first page ?>                                </td>
                                <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                                <?php } // Show if not first page ?>                                </td>
                                <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                                <?php } // Show if not last page ?>                                </td>
                                <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                                <?php } // Show if not last page ?>                                </td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="24" bgcolor="#005B5B" class="style16"><div align="center"><a href="../07_members_only_pw.php" class="style17">BACK TO MEMBER'S PAGE </a></div></td>
                        </tr>
        </table></td>
      </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>