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

	$encryptedSSN = openssl_encrypt ($_POST['claimantSSN'], ENCRPYTIONMETHOD, HASH, false, IV);


	$sqlCheck = "SELECT claimID FROM dbo.claim_table WHERE (claimID = (?) ) AND (claimantSSN = (?) )";
	$checkParams = array($_POST['claimID'], $encryptedSSN);
	$checkResult = sqlsrv_query($conn, $sqlCheck, $checkParams);
	if($checkResult === false || !$checkResult) {
		// echo print_r( sqlsrv_errors(), true);
	}

	$rCount = 0;
	while ($row = sqlsrv_fetch_array( $checkResult, SQLSRV_FETCH_NUMERIC)) {
		$rCount++;
	}
	if ($rCount > 0) {
		echo "existing_claim";
	} else {
		$ssnCheck = "SELECT claimantSSN FROM dbo.claim_table WHERE (claimantSSN = (?) )";
		$ssnParams = array($encryptedSSN);
		$ssnResult = sqlsrv_query($conn, $ssnCheck, $ssnParams);

		if ($ssnResult === false || !$ssnResult) {
			// echo print_r( sqlsrv_errors(), true);
		}

		$rCount = 0;
		while ($row = sqlsrv_fetch_array($ssnResult, SQLSRV_FETCH_NUMERIC)) {
			$rCount++;
		}
		if ($rCount > 0) {
			echo "found";
		} else {
			echo $encryptedSSN;
		}
		sqlsrv_free_stmt($ssnResult);
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt($checkResult);
	sqlsrv_close($conn);
?>
