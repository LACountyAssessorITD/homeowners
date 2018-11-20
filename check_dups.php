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

	$encryptedSSN = openssl_encrypt ($_POST['claimantSSN'];, ENCRPYTIONMETHOD, HASH, false, IV);
	$sqlCheck = "SELECT claimID FROM dbo.claim_table WHERE (claimantSSN = (?) )";
	$checkparams = array($encryptedSSN);
	if($conn === false) {
		// echo print_r( sqlsrv_errors(), true);
	}
	$checkResult = sqlsrv_query($conn, $sqlCheck, $checkparams);

	if($checkResult === false || !$checkResult) {
		// echo print_r( sqlsrv_errors(), true);
	}
	$rCount=0;
	while($row = sqlsrv_fetch_array( $checkResult, SQLSRV_FETCH_NUMERIC))
	{
		$rCount++;
	}
	if ($rCount > 0) {
		echo "found";
	} else {
		echo $_POST['claimant'];
	}

	/* Free statement and connection resources. */
	sqlsrv_free_stmt($checkResult);

	sqlsrv_close($conn);
?>