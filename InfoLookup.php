<?php
	$serverName = "Assessor";
	$uid = "zhdllwyc";
	$pwd = 'A$$essortrain123';
	$databaseName = "homeowner_test";
	$connectionInfo = array("UID"=>$uid,
		"PWD"=>$pwd,
		"Database"=>$databaseName);
	
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if($conn === false) {
		echo "Could not connect.\n";
		die(print_r( sqlsrv_errors(), true));
	}
	
	
	$homeownerSSN = intval($_GET['homeownerSSN']);;
	//FOR TESTING PURPOSES: I WILL ONLY USE THE CLAIMANT, AND USE THE CLAIM TABLE FROM WRITE_CLAIM.PHP
	$stmt = "SELECT claimantSSN FROM dbo.claim_table WHERE claimantSSN='$homeownerSSN'";
	/*
	$stmt = "SELECT homeownerFirstname, homeownerLastname, homeownerSSN, spouseFirstname, spouseLastname,
		spouseSSN, propertyAIN, propertyVacated, propertyAquired, propertyOccupied, propertyAddress, 
		propertyApartment, propertyCity, propertyState, propertyZIP, claimNumber, taxYear FROM lookup_table";
	*/
	
	if($stmt){
     	echo "Statement executed.<br>\n";
	}
	else
	{
    	echo "Error in statement execution.\n";
     	die( print_r( sqlsrv_errors(), true));
	}
	
	session_start();
	
	
	/* Should just print ssn*/
	
	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	{
		echo "Col1: ".$row[claimantSSN]."\n";
		echo "-----------------<br>\n";
	}
	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
	
	


?>