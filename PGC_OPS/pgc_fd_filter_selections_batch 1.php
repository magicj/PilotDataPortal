<?php require_once $_SERVER['DOCUMENT_ROOT'].'../../Connections/PGC.php' ?>
<?php
 
//$query_Recordset3 = "INSERT INTO pgc_field_duty_selections_detail(member_name, fd_role, `session`, fd_date) values SELECT member_name, fd_role, `session`, choice1 FROM pgc_field_duty_selections";

 
mysql_select_db($database_PGC, $PGC);
$query_Recordset3 = "INSERT INTO pgc_field_duty_selections_detail_2(member_name, fd_role, `session`, fd_date) 
(SELECT member_name, fd_role, `session`, fd_date FROM pgc_field_duty_selections_detail WHERE (pgc_field_duty_selections_detail.member_name <> 
member_name))";
$Recordset3 = mysql_query($query_Recordset3, $PGC) or die(mysql_error());
//$row_Recordset3 = mysql_fetch_assoc($Recordset3);
//$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>
<?php

 

/*
SELECT image_id
FROM list
WHERE (style_id, style_value) IN ((24,'red'),(25,'big'),(27,'round'))
GROUP BY image_id
HAVING count(distinct style_id, style_value)=3

*/

?>