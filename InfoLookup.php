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

	//There's a cleaner way to write this code, and it involves a pretty array, but I needed to write this in a few hours. *I'll go back and fix it later*

	$sql = "SELECT claimID, claimant, claimantSSN, currentAPN FROM dbo.claim_table WHERE";
	$populated = False; //Represents need for "and" in the SQL statement, and if there is no minimum by the end, there is no need to query the database

	$homeownerName = $_GET['homeownerLastname']." ".$_GET['homeownerFirstname'];
	if(!empty($homeownerName)){
		$sql= $sql." claimant = '$homeownerName'";
		$populated = True;
	}
	// $homeownerSSN = intval($_GET['homeownerSSN']);
	// if(!empty($homeownerSSN)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." claimantSSN = '$homeownerSSN'";
	// 	$populated = True;
	// }
	// $spouseName = $_GET['spouseLastname']." ".$_GET['spouseFirstname'];
	// if(!empty($spouseName)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." spouse = '$spouseName'";
	// 	$populated = True;
	// }
	// $spouseSSN = intval($_GET['spouseSSN']);
	// if(!is_null($spouseSSN)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." spouseSSN = '$spouseSSN'";
	// 	$populated = True;
	// }
	// $propertyAquired = $_GET['propertyAquired'];
	// if(!is_null($propertyAquired)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." dateAquired = '$propertyAquired'";
	// 	$populated = True;
	// }
	// $propertyOccupied = $_GET['propertyOccupied'];
	// if(!is_null($propertyOccupied)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." dateOccupied = '$propertyOccupied'";
	// 	$populated = True;
	// }
	// $propertyAddress = $_GET['propertyAddress'];
	// if(!is_null($propertyAddress)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentStName = '$propertyAddress'";
	// 	$populated = True;
	// }
	// $propertyApartment = $_GET['propertyApartment'];
	// if(!is_null($propertyApartment)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentApt = '$propertyApartment'";
	// 	$populated = True;
	// }
	// $propertyCity = $_GET['propertyCity'];
	// if(!is_null($propertyCity)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentCity = '$propertyCity'";
	// 	$populated = True;
	// }
	// $propertyState = $_GET['propertyState'];
	// if(!is_null($propertyState)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentState = '$propertyState'";
	// 	$populated = True;
	// }
	// $propertyZIP = intval($_GET['propertyZIP']);
	// if(!is_null($propertyZIP)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentZip = '$propertyZIP'";
	// 	$populated = True;
	// }
	// $claimNumber = intval($_GET['claimNumber']);
	// if(!is_null($claimNumber)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." claimID = '$claimNumber'";
	// 	$populated = True;
	// }

	//grab this from dbo.claims_list TODO
	// $propertyAIN = intval($_GET['propertyAIN']);
	// if($propertyAIN !is_null){
	// 	$sql_2= $sql_2." AIN = '$propertyAIN'";
	// 	$populated2 = True;
	// }

	//Unsure/unstated properties in the tables: TODO
	// $propertyVacated = $_GET['propertyVacated'];
	// if($propertyVacated !is_null){
	// 	$sql= $sql." claimant = '$propertyVacated'";
	// 	$populated = True;
	// }
	// $taxYear = $_GET['taxYear'];
	// if($taxYear !is_null){
	// 	$sql= $sql." claimant = '$taxYear'";
	// 	$populated = True;
	// }

	//FOR TESTING PURPOSES: I WILL ONLY USE THE CLAIMANT, AND USE THE CLAIM TABLE FROM WRITE_CLAIM.PHP
	//$sql = "SELECT claimID, claimant, claimantSSN, currentAPN  FROM dbo.claim_table WHERE claimant = '$homeownerName'";
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

	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	{
		echo "<a href='claimhistory.php?claimID=".$row[0]."'>Claim ID#=".$row[0]."</a>____<a href='personhistory.php?claimantSSN=".$row[2]."'>SSN=".$row[2]."</a>____<a href='propertyhistory.php?AIN=".$row[3]."'>PropertyID=".$row[3]."</a> " ;
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

?>
