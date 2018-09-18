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
	$sql = "SELECT claimID, claimant, claimantSSN, currentAPN  FROM dbo.claim_table WHERE claimantSSN = '$homeownerSSN'";
	/*
	$sql = "SELECT homeownerFirstname, homeownerLastname, homeownerSSN, spouseFirstname, spouseLastname,
		spouseSSN, propertyAIN, propertyVacated, propertyAquired, propertyOccupied, propertyAddress,
		propertyApartment, propertyCity, propertyState, propertyZIP, claimNumber, taxYear FROM lookup_table";
	*/
	$stmt = sqlsrv_query( $conn, $sql );

	$sql = "SELECT FirstName, LastName FROM SomeTable";

	if( $stmt === false) {
    	die();
	}

// 	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
//       echo $row['LastName'].", ".$row['FirstName']."<br />";
// 	}

// 	sqlsrv_free_stmt( $stmt);

	if($stmt){
     	echo "Results:<br>\n";
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
		echo "<a href='claimhistory.php?claimID=".$row[0]."'>Claim ID#=".$row[0]."</a>____<a href='personhistory.php?SSN=".$row[2]."'>PersonID=".$row[1]."-".$row[2]."</a>____<a href='propertyhistory.php?AIN=".$row[3]."'>PropertyID=".$row[3]."</a> " ;
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

?>
