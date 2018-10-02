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

	$claimID = null;
	if (isset($_POST['claimID'])) {
		$claimID = (int)htmlspecialchars($_POST['claimID']);
	}

	$option = null;
	if (isset($_POST['option'])) {
		$option = $_POST['option'];
		// echo $option;
		// echo strcasecmp($option, "Claim Received");
	}


	if(strcasecmp($option, "Claim Received")==0){
			/* query building */
		$claim_query = "INSERT INTO dbo.claim_table
				(claimID, claimant,claimantSSN,spouse,spouseSSN,currentAPN,dateAcquired,dateOccupied,
				currentStName,currentApt,currentCity,currentState,currentZip,
				mailingStName,mailingApt,mailingCity,mailingState,mailingZip,
				priorAPN,dateMovedOut,priorStName,priorApt,priorCity,priorState,priorZip,
				rollTaxYear,exemptRE,suppTaxYear,exemptRE2,claimAction,findingReason,claimReceived,
				supervisorWorkload,staffReview,staffReviewDate,supervisorReview,caseClosed)
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$claim_params = array($claimID, null, null,null,null,null, null, null, null,null, null, null, null,null, null, null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,date("m.d.y"),null,null,null,null,null);
			/* Execute the query. */                  
		$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);

		// check success
		if ($claim_result) {
			echo "Submission success.\n";
		}
		else if (!$claim_result) {
			echo "claim_result error";
			die( print_r( sqlsrv_errors(), true));
		}


		/* Free statement and connection resources. */
		sqlsrv_free_stmt($claim_result);
	}

	sqlsrv_close($conn);
?>