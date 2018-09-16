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

	/* query building */
	$query = "INSERT INTO dbo.claim_table
			(claimant,claimantDOB,claimantSSN,spouse,spouseDOB,spouseSSN,currentAPN,
			dateAcquired,dateOccupied,currentStNum,currentStName,currentCity,currentZip,
			priorAPN,dateMovedOut,priorStNum,priorStName,priorCity,priorZip,rollTaxYear,
			exemptRE,suppTaxYear,exemptRE2,claimAction,findingReason,claimReceived,
			supervisorWorkload,staffReview,staffReviewDate,supervisorReview,caseClosed)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$claim_params = array($_POST['claimant'],$_POST['claimantDOB'],$_POST['claimantSSN'],
			$_POST['spouse'],$_POST['spouseDOB'],$_POST['spouseSSN'],$_POST['currentAPN'],
			$_POST['dateAcquired'],$_POST['dateOccupied'],$_POST['currentStNum'],
			$_POST['currentStName'],$_POST['currentCity'],$_POST['currentZip'],$_POST['priorAPN'],
			$_POST['dateMovedOut'],$_POST['priorStNum'],$_POST['priorStName'],$_POST['priorCity'],
			$_POST['priorZip'],$_POST['rollTaxYear'],$_POST['exemptRE'],$_POST['suppTaxYear'],
			$_POST['exemptRE2'],$_POST['claimAction'],$_POST['findingReason'],
			$_POST['claimReceived'],$_POST['supervisorWorkload'],$_POST['staffReview'],
			$_POST['staffReviewDate'],$_POST['supervisorReview'],$_POST['caseClosed']);     

	/* Execute the query. */                  
	$result = sqlsrv_query($conn,$query,$claim_params);

	if ($result) {
		echo "Submission success.\n";
	}
	else {
		echo "Error in statement execution.\n";
		die( print_r( sqlsrv_errors(), true));
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt($result);
	sqlsrv_close($conn);
?>