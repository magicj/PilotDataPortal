<?php require_once('../Connections/PGC.php');?>
<?php
error_reporting(0);
if (!isset($_SESSION)) {
  session_start();
}
//require_once('pgc_check_login.php'); 
$query = "SELECT fd_key, fd_date, member_id, member_name, fd_role, `session` FROM pgc_field_duty_selections_detail";
$result = mysql_query($query);

$num = mysql_num_rows($results);
if ($num > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        // You have $row['ID'], $row['Category'], $row['Summary'], $row['Text']
	   
    }
}

/*
rows = select * from table where ID=x order by time desc;
n=0;
foreach rows{
    if(n > 3){
       update table set valid = -1 where rows[n]; 
    }
    n++
}

Assuming that (id,time) has a UNIQUE constraint, i.e. no two rows have the same id and same time:
UPDATE 
    tableX AS tu
  JOIN
    ( SELECT time
      FROM tableX
      WHERE id = @X                      -- the given ID
      ORDER BY time DESC
      LIMIT 1 OFFSET 2
    ) AS t3
    ON  tu.id = @X                       -- given ID again
    AND tu.time < t3.time 
SET
    tu.valid = -1 ;
*/