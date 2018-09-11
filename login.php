<?php
$serverName = "Assessor";
$uid = "zhdllwyc";
$pwd = 'A$$essortrain123';
$databaseName = "homeowner_test";

$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>$databaseName);

/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);

$tsql = "SELECT id, username, password FROM temp_table";

/* Execute the query. */

$stmt = sqlsrv_query( $conn, $tsql);

if ( $stmt )
{
     echo "Statement executed.<br>\n";
     header("Location: " . "home.php");
}
else
{
     echo "Error in statement execution.\n";
     die( print_r( sqlsrv_errors(), true));
}
?>
