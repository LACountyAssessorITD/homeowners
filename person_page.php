<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Claim History</title>
  	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
  <link rel="stylesheet" type="text/css" href="styles/general-style.css">

</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="productivity_report_page.php">HOX Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a id="active-page" class="nav-link" href="productivity_report_page.php">Productivity Report</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="scan_claims_page.php">Scan Claims</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create_claim_page.php">Claim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="advanced_search_page.php">Advanced Search</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Logout</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="claim_page.php" method="get">
            <input class="form-control mr-sm-2" type="text" name="claimID" placeholder="Search by Claim ID..." aria-label="Search" >
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>
<hr>
<h1> Person History </h1>
<?php
include('constant.php');
include('LDAP/constants.php');
			$claimantSSN = $_GET['claimantSSN'];
    		// $claimantSSN  = openssl_encrypt ($homeownerSSN, ENCRPYTIONMETHOD, HASH, true, IV);
	        $serverName = SERVERNAME;
            $uid = UID;
            $pwd = PWD;
            $databaseName = DATABASENAME;

            $connectionInfo = array( "UID"=>$uid,
                "PWD"=>$pwd,
                "Database"=>$databaseName);

            // /* Connect using SQL Server Authentication. */
             $conn = sqlsrv_connect( $serverName, $connectionInfo);

            $tsql = "SELECT claimant, claimantSSN, spouse, spouseSSN, mailingStName, mailingApt, mailingCity, mailingState, mailingZip FROM claimant_table WHERE claimantSSN=".$claimantSSN;

            // /* Execute the query. */

            $stmt = sqlsrv_query( $conn, $tsql);

            if ( $stmt )
            {
            	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	            {

                  $ssn =        openssl_decrypt($row[1], ENCRPYTIONMETHOD, HASH, false, IV);
                  $ssnSpouse =  openssl_decrypt($row[3], ENCRPYTIONMETHOD, HASH, false, IV);
	                echo "Claimant: ".$row[0]."<br>";
	                // echo "claimantSSN: ".$row[1]."<br>";
                  echo "claimantSSN: ".$ssn."<br>";
	                echo "spouse: ".$row[2]."<br>";
	                // echo "spouseSSN: ".$row[3]."<br>";
                  echo "spouseSSN: ".$ssnSpouse."<br>";
	                echo "mailingStName: ".$row[4]."<br>";
	                echo "mailingApt: ".$row[5]."<br>";
	                echo "mailingCity: ".$row[6]."<br>";
	                echo "mailingState: ".$row[7]."<br>";
	                echo "mailingZip: ".$row[8]."<br>";
	            }
            }
            else
            {
                echo "Error in statement execution.\n";
                die( print_r( sqlsrv_errors(), true));
            }
?>

<hr>

</body>
</html>
