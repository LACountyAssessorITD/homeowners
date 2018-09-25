<!-- <!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Claim History</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="styles/home-style.css">
</head>
<body>
  <ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="claim.php">Claim</a></li>
  <li><a href="HomeownerInformation.php">Advanced Search</a></li>
  <li><a href="indexv2.php">Logout</a></li>
</ul>


<hr>
<h1> Claim History </h1>
<?php
	$claimID = $_GET['claimID'];
	            $serverName = "Assessor";
            $uid = "zhdllwyc";
            $pwd = 'A$$essortrain123';
            $databaseName = "homeowner_test";

            $connectionInfo = array( "UID"=>$uid,
                "PWD"=>$pwd,
                "Database"=>$databaseName);

            /* Connect using SQL Server Authentication. */
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

            $tsql = "SELECT claimID, claimant, claimantSSN, spouse, spouseSSN, currentAPN, dateAcquired, dateOccupied, currentStName, currentCity, currentZip, priorAPN, dateMovedOut, priorStName, priorCity, priorZip, rollTaxYear, exemptRE, suppTaxYear, exemptRE2, claimAction, findingReason, claimReceived, supervisorWorkload, staffReview, staffReviewDate, supervisorReview, caseClosed FROM claim_table WHERE claimID=".$claimID;

            /* Execute the query. */

            $stmt = sqlsrv_query( $conn, $tsql);

            if ( $stmt )
            {
            	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	            {
	                echo "claimID: ".$row[0]."<br>";
	                echo "claimant: ".$row[1]."<br>";
	                echo "claimantSSN: ".$row[2]."<br>";
	                echo "spouse: ".$row[3]."<br>";
	                echo "spouseSSN: ".$row[4]."<br>";
                  echo "currentAPN: ".$row[5]."<br>";
                  //echo "dateAcquired: ".$row[8]."<br>";
                  //echo "dateOccupied: ".$row[9]."<br>";
                  echo "currentStName: ".$row[8]."<br>";
                  echo "currentCity: ".$row[9]."<br>";
                  echo "currentZip: ".$row[10]."<br>";
                  echo "priorAPN: ".$row[11]."<br>";
                  //echo "dateMovedOut: ".$row[13]."<br>";
                  echo "priorStName: ".$row[13]."<br>";
                  echo "priorCity: ".$row[14]."<br>";
                  echo "priorZip: ".$row[15]."<br>";
                  echo "rollTaxYear: ".$row[16]."<br>";
                  echo "exemptRE: ".$row[17]."<br>";
                  echo "suppTaxYear: ".$row[18]."<br>";
                  echo "exemptRE2: ".$row[19]."<br>";
                  echo "claimAction: ".$row[20]."<br>";
                  echo "findingReason: ".$row[21]."<br>";
                  //echo "claimReceived: ".$row[26]."<br>";
                  //echo "supervisorWorkload: ".$row[27]."<br>";
                  //echo "staffReview: ".$row[28]."<br>";
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
