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

	$homeownerName = /*$_GET['homeownerLastname']." ".*/$_GET['homeownerFirstname'];
	if(!empty($homeownerName)){
		$sql= $sql." claimant = '$homeownerName'";
		$populated = True;
	}
	$homeownerSSN = intval($_GET['homeownerSSN']);
	if(!empty($homeownerSSN)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." claimantSSN = '$homeownerSSN'";
		$populated = True;
	}
	$spouseName = /*$_GET['spouseLastname']." ".*/$_GET['spouseFirstname'];
	if(!empty($spouseName)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." spouse = '$spouseName'";
		$populated = True;
	}
	$spouseSSN = intval($_GET['spouseSSN']);
	if(!empty($spouseSSN)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." spouseSSN = '$spouseSSN'";
		$populated = True;
	}
	$propertyAcquired = $_GET['propertyAcquired'];
	if(!empty($propertyAcquired)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." dateAcquired = '$propertyAcquired'";
		$populated = True;
	}
	$propertyOccupied = $_GET['propertyOccupied'];
	if(!empty($propertyOccupied)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." dateOccupied = '$propertyOccupied'";
		$populated = True;
	}

	$propertyAddress = $_GET['propertyAddress'];
	if(!empty($propertyAddress)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentStName = '$propertyAddress'";
		$populated = True;
	}
	$propertyApartment = $_GET['propertyApartment'];
	if(!empty($propertyApartment)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentApt = '$propertyApartment'";
		$populated = True;
	}
	$propertyCity = $_GET['propertyCity'];
	if(!empty($propertyCity)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentCity = '$propertyCity'";
		$populated = True;
	}
	$propertyState = $_GET['propertyState'];
	if(!empty($propertyState)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentState = '$propertyState'";
		$populated = True;
	}
	$propertyZIP = intval($_GET['propertyZIP']);
	if(!empty($propertyZIP)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentZip = '$propertyZIP'";
		$populated = True;
	}
	$claimNumber = intval($_GET['claimNumber']);
	if(!empty($claimNumber)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." claimID = '$claimNumber'";
		$populated = True;
	}

	//grab this from dbo.claims_list TODO
	$sql_2 = NULL;
	$exists_AIN = true;
	$propertyAIN = intval($_GET['propertyAIN']);
	if(!empty($propertyAIN)){
		$sql_2= "SELECT claimID FROM dbo.claim_table WHERE AIN = '$propertyAIN'";
	}
	if(!is_null($sql_2)){
		$stmt = sqlsrv_query( $conn, $sql );

		if( $stmt === false) {
	    	die();
		}else{
			$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
			if(!$row){
				$exists_AIN = false;
			}else{
				// $exists_AIN=true; //true by default
			}
		}
	}
	//Unsure/unstated properties in the tables: TODO
	// $propertyVacated = $_GET['propertyVacated'];
	// if($propertyVacated !empty){
	// 	$sql= $sql." claimant = '$propertyVacated'";
	// 	$populated = True;
	// }
	// $taxYear = $_GET['taxYear'];
	// if($taxYear !empty){
	// 	$sql= $sql." claimant = '$taxYear'";
	// 	$populated = True;
	// }

	$stmt = sqlsrv_query( $conn, $sql );

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
	if(is_null($sql_2) || $exists_AIN){
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
		{
			echo "<a href='claim_page.php?claimID=".$row[0]."'>Claim ID#=".$row[0]."</a>____<a href='person_page.php?claimantSSN=".$row[2]."'>SSN=".$row[2]."</a>____<a href='property_page.php?AIN=".$row[3]."'>PropertyID=".$row[3]."</a><br>" ;
		}
	}	
	/* Free statement and connection resources. */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);

?>
