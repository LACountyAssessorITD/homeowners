<?php
	include('LDAP/constants.php');

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

	$claimAction = null;
	if (isset($_POST['claimAction'])) {
		$claimAction = $_POST['claimAction'];
	}

	// process finding reason
	$findingReason = null;
	if (isset($_POST['findingReason']) && $_POST['findingReason'] != "Other") {
		$findingReason = $_POST['findingReason'];
	} else if ($_POST['findingReason'] === "Other"){
		$findingReason = $_POST['otherReason'];
	}

	// process spouse ssn
	$spouseSSN = null;
	if (isset($_POST['spouseSSN']) && $_POST['spouseSSN']>0) {
		$spouseSSN = openssl_encrypt ($_POST['spouseSSN'], ENCRPYTIONMETHOD, HASH, false, IV);
	}

	// turn all into variables
	$claimant = (empty($_POST['claimant'])) ? null : $_POST['claimant'];
	$claimantSSN = openssl_encrypt ($_POST['claimantSSN'], ENCRPYTIONMETHOD, HASH, false, IV);
	$spouse = (empty($_POST['spouse'])) ? null : $_POST['spouse'];
	$currentAPN = (empty($_POST['currentAPN'])) ? null : $_POST['currentAPN'];
	$dateAcquired = (empty($_POST['dateAcquired'])) ? null : $_POST['dateAcquired'];
	$dateOccupied = (empty($_POST['dateOccupied'])) ? null : $_POST['dateOccupied'];
	$currentStName = (empty($_POST['currentStName'])) ? null : $_POST['currentStName'];
	$currentApt = (empty($_POST['currentApt'])) ? null : $_POST['currentApt'];
	$currentCity = (empty($_POST['currentCity'])) ? null : $_POST['currentCity'];
	$currentState = (empty($_POST['currentState'])) ? null : $_POST['currentState'];
	$currentZip = (empty($_POST['currentZip'])) ? null : $_POST['currentZip'];
	$priorAPN = (empty($_POST['priorAPN'])) ? null : $_POST['priorAPN'];
	$dateMovedOut = (empty($_POST['dateMovedOut'])) ? null : $_POST['dateMovedOut'];
	$priorStName = (empty($_POST['priorStName'])) ? null : $_POST['priorStName'];
	$priorApt = (empty($_POST['priorApt'])) ? null : $_POST['priorApt'];
	$priorCity = (empty($_POST['priorCity'])) ? null : $_POST['priorCity'];
	$priorState = (empty($_POST['priorState'])) ? null : $_POST['priorState'];
	$priorZip = (empty($_POST['priorZip'])) ? null : $_POST['priorZip'];
	$rollTaxYear = (empty($_POST['rollTaxYear'])) ? null : $_POST['rollTaxYear'];
	$exemptRE = (empty($_POST['exemptRE'])) ? null : $_POST['exemptRE'];
	$suppTaxYear = (empty($_POST['suppTaxYear'])) ? null : $_POST['suppTaxYear'];
	$exemptRE2 = (empty($_POST['exemptRE2'])) ? null : $_POST['exemptRE2'];
	$chooseStatus = (empty($_POST['chooseStatus'])) ? null : $_POST['chooseStatus'];
	$statusDate = (empty($_POST['statusDate'])) ? null : $_POST['statusDate'];
	$assignee = (empty($_POST['assignee'])) ? '' : $_POST['assignee'];
	$assignor = (empty($_POST['assignor'])) ? null : $_POST['assignor'];

	// set current addr as mailing addr
	$mailingStName = $currentStName;
	$mailingApt = $currentApt;
	$mailingCity = $currentCity;
	$mailingState = $currentState;
	$mailingZip = $currentZip;

	// if mailing is different then rewrite the values
	if (isset($_POST['enableMailing'])) {
		$mailingStName = $_POST['mailingStName'];
		$mailingApt = $_POST['mailingApt'];
		$mailingCity = $_POST['mailingCity'];
		$mailingState = $_POST['mailingState'];
		$mailingZip = $_POST['mailingZip'];
	}


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
		$sqlUpdate = "UPDATE dbo.claim_table SET claimant = (?),
				claimantSSN = (?), spouse = (?), spouseSSN = (?), 
				currentAPN = (?), dateAcquired = (?), dateOccupied = (?),
				currentStName = (?), currentApt = (?), currentCity = (?), 
				currentState = (?), currentZip = (?), mailingStName = (?), 
				mailingApt = (?), mailingCity = (?), mailingState = (?), 
				mailingZip = (?), priorAPN = (?), dateMovedOut = (?), 
				priorStName = (?), priorApt = (?), priorCity = (?), 
				priorState = (?), priorZip = (?), rollTaxYear = (?), 
				exemptRE = (?), suppTaxYear = (?), exemptRE2 = (?), 
				claimAction = (?), findingReason = (?), currStatus = (?), active = (?)
				WHERE claimID = (?)";
		$sqlUpdateParams = array($claimant, $claimantSSN, $spouse, $spouseSSN, $currentAPN, $dateAcquired, $dateOccupied, $currentStName, $currentApt, $currentCity, $currentState, $currentZip, $mailingStName, $mailingApt, $mailingCity, $mailingState, $mailingZip, $priorAPN, $dateMovedOut, $priorStName, $priorApt, $priorCity, $priorState, $priorZip, $rollTaxYear, $exemptRE, $suppTaxYear, $exemptRE2, $claimAction, $findingReason, $chooseStatus, $active, $claimID);

		// update status accordingly
		$sqlUpdateDate='';
		if (strcasecmp($chooseStatus, "Claim Received")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET claimReceived = (?),
			claimReceivedAssignee = (?),
			claimReceivedAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Supervisor Workload")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET supervisorWorkload = (?),
			supervisorWorkloadAssignee = (?), 
			supervisorWorkloadAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Staff Assign")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET staffReview = (?),
			staffReviewAssignee = (?), 
			staffReviewAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Staff Review Date")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET staffReviewDate = (?),
			staffReviewDateAssignee = (?), 
			staffReviewDateAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Supervisor Review")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET supervisorReview = (?),
			supervisorReviewAssignee = (?), 
			supervisorReviewAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Case Closed")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET caseClosed = (?),
			caseClosedAssignee = (?), 
			caseClosedAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Preprint Sent")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET preprintSent = (?),
			preprintSentAssignee = (?), 
			preprintSentAssignor = (?) WHERE claimID = (?)";
		} else if (strcasecmp($chooseStatus, "Hold")==0) {
			$sqlUpdateDate="UPDATE dbo.claim_table SET hold = (?),
			holdAssignee = (?), 
			holdAssignor = (?) WHERE claimID = (?)";
		}


		$assignParams = array($statusDate, $assignee, $assignor, $claimID);
		sqlsrv_query( $conn, $sqlUpdateDate, $assignParams);

		$stmtUpdate = sqlsrv_query( $conn, $sqlUpdate, $sqlUpdateParams);

		if($stmtUpdate == false || !$stmtUpdate) {
			echo "update statement error\n";
			echo print_r( sqlsrv_errors(), true);
			die( print_r( sqlsrv_errors(), true));
		} else {
			// update success
			echo "update_success";
		}

		sqlsrv_free_stmt($stmtUpdate);

	}

	sqlsrv_close($conn);
?>