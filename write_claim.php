<?php
	/* better way to connect without exposing password info? */
	$serverName = "Assessor";
	$uid = "zhdllwyc";
	$pwd = 'A$$essortrain123';
	$databaseName = "homeowner_test";

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

	$claimAction = null;
	if (isset($_POST['claimAction'])) {
		$claimAction = $_POST['claimAction'];
	}

	$findingReason = null;
	if (isset($_POST['findingReason'])) {
		$findingReason = $_POST['findingReason'];
	}

	$spouse = null;
	if (isset($_POST['spouse'])) {
		$spouse = $_POST['spouse'];
	}
	$spouseSSN = null;
	if (isset($_POST['spouseSSN'])) {
		$spouseSSN = $_POST['spouseSSN'];
	}

	/* query building */
	$claim_query = "INSERT INTO dbo.claim_table
			(claimant,claimantSSN,spouse,spouseSSN,currentAPN,dateAcquired,dateOccupied,
			currentStName,currentApt,currentCity,currentState,currentZip,
			mailingStName,mailingApt,mailingCity,mailingState,mailingZip,
			priorAPN,dateMovedOut,priorStName,priorApt,priorCity,priorState,priorZip,
			rollTaxYear,exemptRE,suppTaxYear,exemptRE2,claimAction,findingReason,claimReceived,
			supervisorWorkload,staffReview,staffReviewDate,supervisorReview,caseClosed)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$claim_params = array($_POST['claimant'],$_POST['claimantSSN'],$spouse,$spouseSSN,
			$_POST['currentAPN'],$_POST['dateAcquired'],$_POST['dateOccupied'],$_POST['currentStName'],
			$_POST['currentApt'],$_POST['currentCity'],$_POST['currentState'],$_POST['currentZip'],
			$mailingStName,$mailingApt,$mailingCity,$mailingState,$mailingZip,
			$_POST['priorAPN'],$_POST['dateMovedOut'],$_POST['priorStName'],$_POST['priorApt'],
			$_POST['priorCity'],$priorState,$_POST['priorZip'],$_POST['rollTaxYear'],
			$_POST['exemptRE'],$_POST['suppTaxYear'],$_POST['exemptRE2'],$claimAction,$findingReason,
			$_POST['claimReceived'],$_POST['supervisorWorkload'],$_POST['staffReview'],
			$_POST['staffReviewDate'],$_POST['supervisorReview'],$_POST['caseClosed']);

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


	$claims_list_query = "INSERT INTO dbo.claims_list
			(AIN,claimantSSN)
			VALUES(?,?)";
	$claims_list_params = array($_POST['currentAPN'],$_POST['claimantSSN']);

	/* Execute the query. */                  
	$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);
	$claimant_result = sqlsrv_query($conn,$claimant_query,$claimant_params);
	$property_result = sqlsrv_query($conn,$property_query,$property_params);
	$claims_list_result = sqlsrv_query($conn,$claims_list_query,$claims_list_params);

	// check success
	if ($claim_result && $claimant_result && $property_result && $claims_list_result) {
		echo "Submission success.\n";
	}
	else if (!$claim_result) {
		echo "claim_result error";
		die( print_r( sqlsrv_errors(), true));
	}
	else if (!$claimant_result) {
		echo "claimant_result error";
		die( print_r( sqlsrv_errors(), true));
	}
	else if (!$property_result) {
		echo "property_result error";
		die( print_r( sqlsrv_errors(), true));
	}
	else if (!$claims_list_result) {
		echo "claims_list_result error";
		die( print_r( sqlsrv_errors(), true));
	}


	/* Free statement and connection resources. */
	sqlsrv_free_stmt($claim_result);
	sqlsrv_free_stmt($claimant_result);
	sqlsrv_free_stmt($property_result);
	sqlsrv_free_stmt($claims_list_result);
	sqlsrv_close($conn);
?>