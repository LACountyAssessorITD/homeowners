<?php
	include('constant.php');
	/* better way to connect without exposing password info? */
	$serverName = SERVERNAME;
	$uid = UID;
	$pwd = PWD;
	$databaseName = DATABASENAME;

	$connectionInfo = array( "UID"=>$uid,
		"PWD"=>$pwd,
		"Database"=>$databaseName);

	/* Connect using SQL Server Authentication. */
	$conn = sqlsrv_connect( $serverName, $connectionInfo);

	if($conn === false) {
		echo "Could not connect.\n";
		die(print_r( sqlsrv_errors(), true));
	}

	// set current addr as mailing addr
	$mailingStName = $_POST['currentStName'];
	$mailingApt = $_POST['currentApt'];
	$mailingCity = $_POST['currentCity'];
	$mailingState = $_POST['currentState'];
	$mailingZip = $_POST['currentZip'];

	// if mailing is different then rewrite the values
	if (isset($_POST['enableMailing'])) {
		$mailingStName = $_POST['mailingStName'];
		$mailingApt = $_POST['mailingApt'];
		$mailingCity = $_POST['mailingCity'];
		$mailingState = $_POST['mailingState'];
		$mailingZip = $_POST['mailingZip'];
	}

	$priorState = null;
	if (isset($_POST['priorState'])) {
		$priorState = $_POST['priorState'];
	}

	$priorApt = null;
	if (isset($_POST['priorApt'])) {
		$priorApt = $_POST['priorApt'];
	}

	$currentApt = null;
	if (isset($_POST['currentApt'])) {
		$currentApt = $_POST['currentApt'];
	}

	$claimAction = null;
	if (isset($_POST['claimAction'])) {
		$claimAction = $_POST['claimAction'];
	}

	$findingReason = null;
	if (isset($_POST['findingReason']) && $_POST['findingReason'] != "Other") {
		$findingReason = $_POST['findingReason'];
	} else if ($_POST['findingReason'] === "Other"){
		$findingReason = $_POST['otherReason'];
	}

	$spouse = null;
	if (isset($_POST['spouse'])) {
		$spouse = $_POST['spouse'];
	} else {
		$spouse = null;
	}
	$spouseSSN = null;
	if (isset($_POST['spouseSSN'])) {
		$spouseSSN = 0;
	}


	// turn all into variables
	$claimant = $_POST['claimant'];
	$claimantSSN = $_POST['claimantSSN'];
	$currentAPN = $_POST['currentAPN'];
	$dateAcquired = $_POST['dateAcquired'];
	$dateOccupied = $_POST['dateOccupied'];
	$currentStName = $_POST['currentStName'];
	$currentCity = $_POST['currentCity'];
	$currentState = $_POST['currentState'];
	$currentZip = $_POST['currentZip'];
	$priorAPN = $_POST['priorAPN'];
	$dateMovedOut = $_POST['dateMovedOut'];
	$priorStName = $_POST['priorStName'];
	$priorCity = $_POST['priorCity'];
	$priorZip = $_POST['priorZip'];
	$rollTaxYear = $_POST['rollTaxYear'];
	$exemptRE = $_POST['exemptRE'];
	$suppTaxYear = $_POST['suppTaxYear'];
	$exemptRE2 = $_POST['exemptRE2'];
	$chooseStatus = $_POST['chooseStatus'];
	$statusDate = $_POST['statusDate'];
	$assignee = $_POST['assignee'];
	$assignor = $_POST['assignor'];


	// check if ain exists
	$sqlSelect = "SELECT * FROM dbo.claim_table WHERE ";
	$claimID = $_POST['claimID'];
	if(!empty($claimID)){
		$sqlSelect = $sqlSelect." claimID = '$claimID'";
	}
	$stmtSelect = sqlsrv_query( $conn, $sqlSelect );
	if($stmtSelect === false || !$stmtSelect) {
		echo "select statement error\n";
		echo print_r( sqlsrv_errors(), true);
		die( print_r( sqlsrv_errors(), true));
	}
	$rowMatch = sqlsrv_fetch_array( $stmtSelect, SQLSRV_FETCH_NUMERIC);


	// update if record exists
	if ($rowMatch != null) {
		$sqlUpdate = "UPDATE dbo.claim_table SET claimant = '$claimant',
				claimantSSN = '$claimantSSN', spouse = '$spouse', spouseSSN = '$spouseSSN', 
				currentAPN = '$currentAPN', dateAcquired = '$dateAcquired', dateOccupied = '$dateOccupied',
				currentStName = '$currentStName', currentApt = '$currentApt', currentCity = '$currentCity', 
				currentState = '$currentState', currentZip = '$currentZip', mailingStName = '$mailingStName', 
				mailingApt = '$mailingApt', mailingCity = '$mailingCity', mailingState = '$mailingState', 
				mailingZip = '$mailingZip', priorAPN = '$priorAPN', dateMovedOut = '$dateMovedOut', 
				priorStName = '$priorStName', priorApt = '$priorApt', priorCity = '$priorCity', 
				priorState = '$priorState', priorZip = '$priorZip', rollTaxYear = '$rollTaxYear', 
				exemptRE = '$exemptRE', suppTaxYear = '$suppTaxYear', exemptRE2 = '$exemptRE2', 
				claimAction = '$claimAction', findingReason = '$findingReason'
				WHERE claimID = '$claimID'";

		// update status accordingly
		if ($chooseStatus === "Claim Received") {
			"UPDATE dbo.claim_table SET claimReceived = '$statusDate',
			claimReceivedAssignee = '$assignee',
			claimReceivedAssignor = '$assignor' WHERE claimID = '$claimID'";
		} else if ($chooseStatus === "Supervisor Workload") {
			"UPDATE dbo.claim_table SET supervisorWorkload = '$statusDate',
			supervisorWorkloadAssignee = '$assignee', 
			supervisorWorkloadAssignor = '$assignor' WHERE claimID = '$claimID'";
		} else if ($chooseStatus === "Staff Review") {
			"UPDATE dbo.claim_table SET staffReview = '$statusDate',
			staffReviewAssignee = '$assignee', 
			staffReviewAssignor = '$assignor' WHERE claimID = '$claimID'";
		} else if ($chooseStatus === "Staff Review Date") {
			"UPDATE dbo.claim_table SET staffReviewDate = '$statusDate',
			staffReviewDateAssignee = '$assignee', 
			staffReviewDateAssignor = '$assignor' WHERE claimID = '$claimID'";
		} else if ($chooseStatus === "Supervisor Review") {
			"UPDATE dbo.claim_table SET supervisorReview = '$statusDate',
			supervisorReviewAssignee = '$assignee', 
			supervisorReviewAssignor = '$assignor' WHERE claimID = '$claimID'";
		} else if ($chooseStatus === "Case Closed") {
			"UPDATE dbo.claim_table SET caseClosed = '$statusDate',
			caseClosedAssignee = '$assignee', 
			caseClosedAssignor = '$assignor' WHERE claimID = '$claimID'";
		}

		$stmtUpdate = sqlsrv_query( $conn, $sqlUpdate );
		if($stmtUpdate === false || !$stmtUpdate) {
			echo "update statement error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		} else {
			// update success
			echo "update_success";
		}

		sqlsrv_free_stmt($stmtUpdate);

	}
	// create entry if record is new
	else {
		/* query building */
		$claim_query = "INSERT INTO dbo.claim_table
				(claimID, claimant,claimantSSN,spouse,spouseSSN,currentAPN,dateAcquired,dateOccupied,
				currentStName,currentApt,currentCity,currentState,currentZip,
				mailingStName,mailingApt,mailingCity,mailingState,mailingZip,
				priorAPN,dateMovedOut,priorStName,priorApt,priorCity,priorState,priorZip,
				rollTaxYear,exemptRE,suppTaxYear,exemptRE2,claimAction,findingReason,
				claimReceived,claimReceivedAssignee,claimReceivedAssignor,
				supervisorWorkload,supervisorWorkloadAssignee,supervisorWorkloadAssignor,
				staffReview,staffReviewAssignee,staffReviewAssignor,
				staffReviewDate,staffReviewDateAssignee,staffReviewDateAssignor,
				supervisorReview,supervisorReviewAssignee,supervisorReviewAssignor,
				caseClosed,caseClosedAssignee,caseClosedAssignor)
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$claim_params = array($_POST['claimID'],$_POST['claimant'],$_POST['claimantSSN'],$spouse,$spouseSSN,
				$_POST['currentAPN'],$_POST['dateAcquired'],$_POST['dateOccupied'],$_POST['currentStName'],
				$_POST['currentApt'],$_POST['currentCity'],$_POST['currentState'],$_POST['currentZip'],
				$mailingStName,$mailingApt,$mailingCity,$mailingState,$mailingZip,
				$_POST['priorAPN'],$_POST['dateMovedOut'],$_POST['priorStName'],$_POST['priorApt'],
				$_POST['priorCity'],$priorState,$_POST['priorZip'],$_POST['rollTaxYear'],
				$_POST['exemptRE'],$_POST['suppTaxYear'],$_POST['exemptRE2'],$claimAction,$findingReason,
				$_POST['statusDate'],$_POST['assignee'],$_POST['assignor'],
				null, null, null,
				null, null, null,
				null, null, null,
				null, null, null,
				null, null, null);

		$claimant_query = "INSERT INTO dbo.claimant_table
				(claimant,claimantSSN,spouse,spouseSSN,
				mailingStName,mailingApt,mailingCity,mailingState,mailingZip)
				VALUES(?,?,?,?,?,?,?,?,?)";
		$claimant_params = array($_POST['claimant'],$_POST['claimantSSN'],$spouse,$spouseSSN,
				$mailingStName,$mailingApt,$mailingCity,$mailingState,$mailingZip);


		$property_query = "INSERT INTO dbo.property_table
				(AIN,streetName,apt,city,state,zip,ownerName,ownerSSN,dateAcquired,dateOccupied,dateMovedOut)
				VALUES(?,?,?,?,?,?,?,?,?,?,?)";
		$property_params = array($_POST['currentAPN'],$_POST['currentStName'],$_POST['currentApt'],$_POST['currentCity'],
				$_POST['currentState'],$_POST['currentZip'],$_POST['claimant'],$_POST['claimantSSN'],
				$_POST['dateAcquired'],$_POST['dateOccupied'],null);

/*
		$claims_list_query = "INSERT INTO dbo.claims_list
				(claimID, AIN,claimantSSN)
				VALUES(?, ?,?)";
		$claims_list_params = array($_POST['claimID'], $_POST['currentAPN'],$_POST['claimantSSN']);
*/
		/* Execute the query. */                  
		$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);
		$claimant_result = sqlsrv_query($conn,$claimant_query,$claimant_params);
		$property_result = sqlsrv_query($conn,$property_query,$property_params);
//		$claims_list_result = sqlsrv_query($conn,$claims_list_query,$claims_list_params);

		// check success
		if ($claim_result && $claimant_result && $property_result) {
			echo "create_success";
		}
		else if (!$claim_result) {
			echo "claim_result error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		}
		else if (!$claimant_result) {
			echo "claimant_result error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		}
		else if (!$property_result) {
			echo "property_result error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		}
/*
		else if (!$claims_list_result) {
			echo "claims_list_result error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		}
*/

		/* Free statement and connection resources. */
		sqlsrv_free_stmt($claim_result);
		sqlsrv_free_stmt($claimant_result);
		sqlsrv_free_stmt($property_result);
		//sqlsrv_free_stmt($claims_list_result);
	}

	sqlsrv_close($conn);
?>