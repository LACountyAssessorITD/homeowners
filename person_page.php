<!DOCTYPE html>
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
  <li><a href="home_page.php">Home</a></li>
  <li><a href="create_claim_page.php">Claim</a></li>
  <li><a href="advanced_search_page.php">Advanced Search</a></li>
  <li><a href="index.php">Logout</a></li>
  <li style="float:right" ><form action="claim_page.php" method="get"><input type="text" name="claimID" placeholder="Search by Claim ID..."><input type="submit"></form></li>
</ul>


<hr>
<h1> Person History </h1>
<?php
	$claimantSSN = $_GET['claimantSSN'];
	            $serverName = "Assessor";
            $uid = "zhdllwyc";
            $pwd = 'A$$essortrain456';
            $databaseName = "homeowner_test";

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
	                echo "Claimant: ".$row[0]."<br>";
	                echo "claimantSSN: ".$row[1]."<br>";
	                echo "spouse: ".$row[2]."<br>";
	                echo "spouseSSN: ".$row[3]."<br>";
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
