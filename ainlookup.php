<?php
	$serverName = "Assessor";
	$uid = "zhdllwyc";
	$pwd = 'A$$essortrain123';
	$databaseName = "HOX_USC";
	$connectionInfo = array("UID"=>$uid,
		"PWD"=>$pwd,
		"Database"=>$databaseName);

	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if($conn === false) {
		echo "Could not connect.\n";
		die(print_r( sqlsrv_errors(), true));
	}

	//There's a cleaner way to write this code, and it involves a pretty array, but I needed to write this in a few hours. *I'll go back and fix it later*

	$sql = "SELECT AIN FROM dbo.LegalDescription WHERE";

	$ainValue = $_GET['ain'];
	if(!empty($ainValue)){
		$sql= $sql." AIN = '$ainValue'";
	}

	$stmt = sqlsrv_query( $conn, $sql );

	//$sql = "SELECT FirstName, LastName FROM SomeTable";

	if( $stmt === false) {
    	die();
	}

	if($stmt){
     	echo "Results:<br>\n";
	}
	else
	{
    	echo "Error in statement execution.\n";
     	die( print_r( sqlsrv_errors(), true));
	}

	session_start();

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	{
		echo $row[0];
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

?>
