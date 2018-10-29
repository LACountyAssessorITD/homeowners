<?php
	include('constant.php');
	$serverName = SERVERNAME;
	$uid = UID;
	$pwd = PWD;
	$databaseName = DATABASENAME;
	$connectionInfo = array("UID"=>$uid,
		"PWD"=>$pwd,
		"Database"=>$databaseName);

	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if($conn === false) {
		echo "Could not connect.\n";
		die(print_r( sqlsrv_errors(), true));
	}

	//There's a cleaner way to write this code, and it involves a pretty array, but I needed to write this in a few hours. *I'll go back and fix it later*

	$sql = "UPDATE dbo.claim_table SET ";
	$populated = false; //Represents need for "and" in the SQL statement, and if there is no minimum by the end, there is no need to query the database

	$homeownerName = /*$_GET['homeownerLastname']." ".*/$_GET['claimant'];
	if(!empty($homeownerName)){
		$sql= $sql." claimant = '$homeownerName'";
		$populated = True;
	}
	$homeownerSSN = intval($_GET['claimantSSN']);
	if(!empty($homeownerSSN)){
		if($populated)
			$sql=$sql.", ";
		$sql= $sql." claimantSSN = '$homeownerSSN'";
		$populated = True;
	}
	$spouseName = /*$_GET['spouseLastname']." ".*/$_GET['spouse'];
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
	$propertyAcquired = $_GET['dateAcquired'];
	if(!empty($propertyAcquired)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." dateAcquired = '$propertyAcquired'";
		$populated = True;
	}
	$propertyOccupied = $_GET['dateOccupied'];
	if(!empty($propertyOccupied)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." dateOccupied = '$propertyOccupied'";
		$populated = True;
	}

	$propertyAddress = $_GET['currentStName'];
	if(!empty($propertyAddress)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentStName = '$propertyAddress'";
		$populated = True;
	}
	$propertyApartment = $_GET['currentApt'];
	if(!empty($propertyApartment)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentApt = '$propertyApartment'";
		$populated = True;
	}
	$propertyCity = $_GET['currentCity'];
	if(!empty($propertyCity)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." currentCity = '$propertyCity'";
		$populated = True;
	}
	// $propertyState = $_GET['currentState'];
	// if(!empty($propertyState)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentState = '$propertyState'";
	// 	$populated = True;
	// }
	// $propertyZIP = intval($_GET['propertyZIP']);
	// if(!empty($propertyZIP)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." currentZip = '$propertyZIP'";
	// 	$populated = True;
	// }
//v
	// $mailingStName = $_GET['mailingStName'];
	// if(!empty($mailingStName)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." mailingStName = '$mailingStName'";
	// 	$populated = True;
	// }
	// $mailingApt = $_GET['mailingApt'];
	// if(!empty($mailingApt)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." mailingApt = '$mailingApt'";
	// 	$populated = True;
	// }
	// $mailingCity = $_GET['mailingCity'];
	// if(!empty($mailingCity)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." mailingCity = '$mailingCity'";
	// 	$populated = True;
	// }
	// $mailingState = $_GET['mailingState'];
	// if(!empty($mailingState)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." mailingState = '$mailingState'";
	// 	$populated = True;
	// }
	// $mailingZip = intval($_GET['mailingZip']);
	// if(!empty($mailingZip)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." mailingZip = '$mailingZip'";
	// 	$populated = True;
	// }
	$priorAPN = intval($_GET['priorAPN']);
	if(!empty($priorAPN)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." priorAPN = '$priorAPN'";
		$populated = True;
	}
	$dateMovedOut = intval($_GET['dateMovedOut']);
	if(!empty($dateMovedOut)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." dateMovedOut = '$dateMovedOut'";
		$populated = True;
	}
	$priorStName = $_GET['priorStName'];
	if(!empty($priorStName)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." priorStName = '$priorStName'";
		$populated = True;
	}
	$priorApt = $_GET['priorApt'];
	if(!empty($priorApt)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." priorApt = '$priorApt'";
		$populated = True;
	}
	$priorCity = $_GET['priorCity'];
	if(!empty($priorCity)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." priorCity = '$priorCity'";
		$populated = True;
	}
	// $priorState = $_GET['priorState'];
	// if(!empty($priorState)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." priorState = '$priorState'";
	// 	$populated = True;
	// }
	$priorZip = intval($_GET['priorZip']);
	if(!empty($priorZip)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." priorZip = '$priorZip'";
		$populated = True;
	}
	$rollTaxYear = intval($_GET['rollTaxYear']);
	if(!empty($rollTaxYear)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." rollTaxYear = '$rollTaxYear'";
		$populated = True;
	}
	$exemptRE = intval($_GET['exemptRE']);
	if(!empty($exemptRE)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." exemptRE = '$exemptRE'";
		$populated = True;
	}
	$suppTaxYear = intval($_GET['suppTaxYear']);
	if(!empty($suppTaxYear)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." suppTaxYear = '$suppTaxYear'";
		$populated = True;
	}
	$exemptRE2 = intval($_GET['exemptRE2']);
	if(!empty($exemptRE2)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." exemptRE2 = '$exemptRE2'";
		$populated = True;
	}
	// $claimAction = $_GET['claimAction'];
	// if(!empty($claimAction)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." claimAction = '$claimAction'";
	// 	$populated = True;
	// }
	// $findingReason = $_GET['findingReason'];
	// if(!empty($findingReason)){
	// 	if($populated)
	// 		$sql=$sql." AND ";
	// 	$sql= $sql." findingReason = '$findingReason'";
	// 	$populated = True;
	// }
	$claimReceived = intval($_GET['claimReceived']);
	if(!empty($claimReceived)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." claimReceived = '$claimReceived'";
		$populated = True;
	}
	$supervisorWorkload = intval($_GET['supervisorWorkload']);
	if(!empty($supervisorWorkload)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." supervisorWorkload = '$supervisorWorkload'";
		$populated = True;
	}
	$staffReview = intval($_GET['staffReview']);
	if(!empty($staffReview)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." staffReview = '$staffReview'";
		$populated = True;
	}
	$staffReviewDate = intval($_GET['staffReviewDate']);
	if(!empty($staffReviewDate)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." staffReviewDate = '$staffReviewDate'";
		$populated = True;
	}
	$supervisorReview = intval($_GET['supervisorReview']);
	if(!empty($supervisorReview)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." supervisorReview = '$supervisorReview'";
		$populated = True;
	}
	$caseClosed = intval($_GET['caseClosed']);
	if(!empty($caseClosed)){
		if($populated)
			$sql=$sql." AND ";
		$sql= $sql." caseClosed = '$caseClosed'";
		$populated = True;
	}
	//^



	//grab this from dbo.claims_list TODO
	// $sql_2 = NULL;
	// $exists_AIN = true;
	// $propertyAIN = intval($_GET['currentAPN']);
	// if(!empty($propertyAIN)){
	// 	$sql_2= "SELECT claimID FROM dbo.claim_table WHERE AIN = '$propertyAIN'";
	// }
	// if(!is_null($sql_2)){
	// 	$stmt = sqlsrv_query( $conn, $sql );

	// 	if( $stmt === false) {
	//     	die();
	// 	}else{
	// 		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC);
	// 		if(!$row){
	// 			$exists_AIN = false;
	// 		}else{
	// 			// $exists_AIN=true; //true by default
	// 		}
	// 	}
	// }






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

	$claimNumber = intval($_GET['claimID']);

	if($populated && !empty($claimNumber)){
		$sql= $sql." WHERE claimID = '$claimNumber'";

		// $retval = sqlsrv_query( $sql, $conn );
  //       if(! $retval ) {
  //          die('Could not update data: ');
  //       }else{
  //       	echo "Success";
  //       }

		$result = sqlsrv_query($conn,$sql) or die(sqlsrv_errors());
		echo "Successfully Updated";

	// 	$stmt = sqlsrv_query( $conn, $sql );

	// 	if( $stmt === false) {
	//     	die();
	// 	}
	// 	if($stmt){
	//      	echo "<h5 class='col'>Results:</h5><br>\n";
	// 	}
	// 	else
	// 	{
	//     	echo "Error in statement execution.\n";
	//      	die( print_r( sqlsrv_errors(), true));
	// 	}

	// 	session_start();
	// 	if(is_null($sql_2) || $exists_AIN){
	// 		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	// 		{
	// 			echo "<a href='claim_page.php?claimID=".$row[0]."' class='col-sm-4'>Claim ID#=".$row[0]."</a><a href='person_page.php?claimantSSN=".$row[2]."' class='col-sm-4'>SSN=".$row[2]."</a><a href='property_page.php?AIN=".$row[3]."' class='col-sm-4'>PropertyID=".$row[3]."</a><br>" ;
	// 		}
	// 	}	
	// 	/* Free statement and connection resources. */
	// 	sqlsrv_free_stmt( $stmt);
	}
	sqlsrv_close( $conn);

?>
