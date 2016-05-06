<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
session_start();
}
require_once('pgc_access_check.php');
require_once('pgc_access_save_appname.php'); 
require_once('pgc_access_app_check.php');  
/* START - PAGE ACCESS CHECKING LOGIC - ADD TO ALL APPS - START */
?>
<?php

// Clean Up Deletions 
$deleteSQL = "DELETE FROM pgc_access_member_groups WHERE rec_active = 'D'";
mysql_select_db($database_PGC, $PGC);
$Result1 = mysql_query($deleteSQL, $PGC) or die(mysql_error());


if (isset($_POST[select])) {
$_SESSION['member_name'] = $_POST[select];
}
if (isset($_POST[select2])) {
$_SESSION['member_groups'] = $_POST[select2];
}
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 20;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
$pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
if (isset($_SESSION['member_name'])) {
$colname1_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['member_name'] : addslashes($_SESSION['member_name']);
}
if (isset($_SESSION['member_groups'])) {
$colname2_Recordset1 = (get_magic_quotes_gpc()) ? $_SESSION['member_groups'] : addslashes($_SESSION['member_groups']);
}
mysql_select_db($database_PGC, $PGC);
if ($_SESSION['member_groups'] == 'ALL' and $_SESSION['member_name'] == 'ALL' ) {     
$query_Recordset1 = "SELECT * FROM pgc_access_member_groups ORDER BY member_name ASC";
}
if ($_SESSION['member_groups'] <> 'ALL' and $_SESSION['member_name'] <> 'ALL' ) {     
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_member_groups WHERE member_name = '%s' and assigned_group = '%s' ORDER BY member_name ASC", $colname1_Recordset1, $colname2_Recordset1);
}
if ($_SESSION['member_groups'] == 'ALL' and $_SESSION['member_name'] <> 'ALL' ) {     
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_member_groups WHERE member_name = '%s' ORDER BY member_name ASC", $colname1_Recordset1);
}
if ($_SESSION['member_groups'] <> 'ALL' and $_SESSION['member_name'] == 'ALL' ) {     
$query_Recordset1 = sprintf("SELECT * FROM pgc_access_member_groups WHERE assigned_group = '%s' ORDER BY member_name ASC", $colname2_Recordset1);
}
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
$query_Members = "SELECT 'ALL' AS MNAME UNION SELECT NAME AS MNAME FROM pgc_members WHERE NAME <> '' ORDER BY MNAME ASC";
$Members = mysql_query($query_Members, $PGC) or die(mysql_error());
$row_Members = mysql_fetch_assoc($Members);
$totalRows_Members = mysql_num_rows($Members);

mysql_select_db($database_PGC, $PGC);
$query_Groups = "SELECT 'ALL'  AS MGROUP  UNION SELECT group_name AS MGROUP FROM pgc_access_grouplist WHERE group_name <> '' ORDER BY MGROUP ASC";
$Groups = mysql_query($query_Groups, $PGC) or die(mysql_error());
$row_Groups = mysql_fetch_assoc($Groups);
$totalRows_Groups = mysql_num_rows($Groups);

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
<title>Access Control System</title>
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
.style57 {color: #FFFFFF; font-weight: bold; }
.style59 {
	color: #FFFFFF;
	font-weight: bold;
	font-style: italic;
	font-size: 16px;
}
-->
</style>
</head>
<body>
<table width="900" height="95%" align="center" cellpadding="2" cellspacing="2"  bordercolor="#000033" bgcolor="#595E80">
<tr>
<td height="25" align="center"><div align="center"><span class="style1">PGC PILOT DATA PORTAL</span></div></td>
</tr>
<tr>
<td valign="top"><table width="95%" height="95%" align="center" cellpadding="4" cellspacing="3" bordercolor="#005B5B" bgcolor="#414967">
    <tr>
        <td width="1562" height="26" valign="middle" class="style57"><div align="center" class="style59"> SEE MEMBER ASSIGNED ACCESS GROUPS</div></td>
    </tr>
    <tr>
        <td align="center" valign="top"><form id="form1" name="form1" method="post" action="">
            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="12%" height="44">&nbsp;</td>
                    <td width="40%">&nbsp;</td>
                    <td width="24%"><div align="center">
                        <select name="select">
                            <?php
do {  
?>
                            <option value="<?php echo $row_Members['MNAME']?>"<?php if (!(strcmp($row_Members['MNAME'], "$_SESSION[member_name]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_Members['MNAME']?></option>
                            <?php
} while ($row_Members = mysql_fetch_assoc($Members));
$rows = mysql_num_rows($Members);
if($rows > 0) {
mysql_data_seek($Members, 0);
$row_Members = mysql_fetch_assoc($Members);
}
?>
                        </select>
                    </div></td>
                    <td width="15%"><div align="center">
                        <select name="select2">
                            <?php
do {  
?>
                            <option value="<?php echo $row_Groups['MGROUP']?>"<?php if (!(strcmp($row_Groups['MGROUP'], "$_SESSION[member_groups]"))) {echo "selected=\"selected\"";} ?>><?php echo $row_Groups['MGROUP']?></option>
                            <?php
} while ($row_Groups = mysql_fetch_assoc($Groups));
$rows = mysql_num_rows($Groups);
if($rows > 0) {
mysql_data_seek($Groups, 0);
$row_Groups = mysql_fetch_assoc($Groups);
}
?>
                        </select>
                    </div></td>
                    <td width="9%"><div align="right">
                        <input type="submit" name="Submit" value="Submit" />
                    </div></td>
                </tr>
            </table>
            <table width="90%" cellpadding="4" cellspacing="2" bgcolor="#333333">
                <tr>
                    <td bgcolor="#173144" class="style59"><div align="center" class="style16">Rec Key</div></td>
                    <td bgcolor="#173144" class="style59"><div align="center" class="style16">Member Name</div></td>
                    <td bgcolor="#173144" class="style59"><div align="center" class="style16">Assigned Group</div></td>
                    <td bgcolor="#173144" class="style59"><div align="center" class="style16">Active</div></td>
                </tr>
                <?php do { ?>
                <tr>
                    <td bgcolor="#244468" class="style17"><div align="center"><a href="pgc_access_member_group_edit.php?rec_key=<?php echo $row_Recordset1['rec_key']; ?>"><?php echo $row_Recordset1['rec_key']; ?></a></div></td>
                    <td width="250" bgcolor="#244468" class="style17"><?php echo $row_Recordset1['member_name']; ?></td>
                    <td bgcolor="#244468" class="style17"><?php echo $row_Recordset1['assigned_group']; ?></td>
                    <td bgcolor="#244468" class="style17"><div align="center"><?php echo $row_Recordset1['rec_active']; ?></div></td>
                </tr>
                <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
            </table>
            <table border="0" width="50%" align="center">
                <tr>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">First</a>
                        <?php } // Show if not first page ?></td>
                    <td width="31%" align="center"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">Previous</a>
                        <?php } // Show if not first page ?></td>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">Next</a>
                        <?php } // Show if not last page ?></td>
                    <td width="23%" align="center"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">Last</a>
                        <?php } // Show if not last page ?></td>
                </tr>
            </table>
            </p>
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

mysql_free_result($Members);

mysql_free_result($Groups);
?>
