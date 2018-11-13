<?php
include('constant.php');
session_start(); 
$message=null;
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

// appraiser query
$tsql = "SELECT name FROM temp_table";

$phpArray = array();

$stmt = sqlsrv_query( $conn, $tsql);
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	array_push($phpArray, $row[0]);
}

// status
$statusArray = array("Claim Received", "Supervisor Workload", "Staff Review", "Staff Review Date", "Supervisor Review", "Case Closed");

$startDate = null;
$endDate = null;
if(isset($_POST['submit'])){ //check if form was submitted
	if (isset($_POST['startDate'])) {
		$startDate = $_POST['startDate'];
	}
	if (isset($_POST['endDate'])) {
		$endDate = $_POST['endDate'];
	}
	$message = $startDate.$endDate;
	//$claimsAppraiser = null;
}
else{
	$d=mktime(0, 0, 0, 1, 1, date("Y"));
	$startDate = date("Y-m-d", $d);
	$endDate = date("Y-m-d");
}
?>


<!doctype html>
<html lang="en">
<head>
	<title>Scan Claim Page</title>

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
	<style>
	* { box-sizing: border-box; }
	.autocomplete {
		/*the container must be positioned relative:*/
		position: relative;
		display: inline-block;
	}
	.autocomplete-items {
		position: absolute;
		border: 1px solid #d4d4d4;
		border-bottom: none;
		border-top: none;
		z-index: 99;
		/*position the autocomplete items to be the same width as the container:*/
		top: 100%;
		left: 0;
		right: 0;
	}
	.autocomplete-items div {
		padding: 10px;
		cursor: pointer;
		background-color: #fff; 
		border-bottom: 1px solid #d4d4d4; 
	}
	.autocomplete-items div:hover {
		/*when hovering an item:*/
		background-color: #e9e9e9; 
	}
	.autocomplete-active {
		/*when navigating through the items using the arrow keys:*/
		background-color: DodgerBlue !important; 
		color: #ffffff; 
	}	
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	td {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	th {
		color: white;
		border: 1px solid #dddddd;
		background-color: #486F9E;
		text-align: center;
		padding: 8px;
	}

	tr:nth-child(even) {
		background-color: #dddddd;
	}
	    .navbar-dark .navbar-nav .nav-link {
        color: rgba(255,255,255,.9);
    }   
</style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="home_page.php">HOX Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="productivity_report_page.php">Productivity Report</a>
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
	<div class="container rounded col-12 p-3" id="signin-container">
		<div class="row">
<!-- 			<div class="form-col col-sm-6" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 5px;"> -->
			<h1 class="col-4">Productivity Report</h1>
			<div class="col-4">
				<?php 
				if($startDate){
					echo "<h4>Start Date:</h4><h3>".$startDate."</h3>";
				}
				?>
			</div>
			<div class="col-4">
				<?php 
				if($endDate){
					echo "<h4>End Date:</h4><h3>".$endDate."</h3>";
				}
				?>
			</div>
		</div>
		<hr class="my-4">
		<div class="row">
			<hr>
			<div class="col-3" >
				<h2>Report Dates</h2>
				<form id="login-form" autocomplete="off" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
					<label for="startDate">Start Date:</label>
					<input class="form-control" id="startDate" name="startDate" placeholder="1/23/2000" type="date">
					<label for="endDate">End Date:</label>
					<input class="form-control" id="endDate" name="endDate" placeholder="1/23/2000" type="date">
					<br>
					<button type="submit" name="submit" class="btn btn-danger">Get Productivity Report</button>
				</form>
			</div>
			<div class="col">
				<h2>Claims by Status</h2>
				<?php 
				if($startDate && $endDate){
					echo "<table style='width: 100%'>
					<tr>
					<th>ClaimStatus</th>
					<th>Count</th>
					<th>Current</th>
					<th>Late</th>
					</tr>";
					$totalCount = 0;
					$totalCurrCount = 0;
					$totalLateCount = 0;
					$fileStartDate = date("Y-01-01");
					$fileEndDate = date("Y-02-15");
					foreach($statusArray as $status) {
						$currentsql = "SELECT claimID
						FROM dbo.claim_table 
						WHERE (claimReceived >= (?) ) AND (claimReceived <= (?) ) AND (currStatus = (?) )";
						$currentparams = array($fileStartDate, $fileEndDate, $status);
						$currentResult = sqlsrv_query($conn, $currentsql, $currentparams);
						$currentCount=0;
						while($row = sqlsrv_fetch_array( $currentResult, SQLSRV_FETCH_NUMERIC))
						{
							$currentCount++;
						}

						$latesql = "SELECT claimID
						FROM dbo.claim_table 
						WHERE (claimReceived > (?) ) AND (currStatus = (?) )";
						$lateparams = array($fileEndDate, $status);
						$lateResult = sqlsrv_query($conn, $latesql, $lateparams);
						$lateCount=0;
						while( $row = sqlsrv_fetch_array( $lateResult, SQLSRV_FETCH_NUMERIC))
						{
							$lateCount++;
						}

						$count = $currentCount + $lateCount;
						$totalCount += $count;
						$totalCurrCount += $currentCount;
						$totalLateCount += $lateCount;
						echo "<tr>"."<td>".$status."</td>"."<td>".$count."</td>"."<td>".$currentCount."</td>"."<td>".$lateCount."</td>"."</tr>";
					}
					echo "<tr>"."<td style='font-weight:bold'>Total Count</td>"."<td style='font-weight:bold'>".$totalCount."</td>"."<td style='font-weight:bold'>".$totalCurrCount."</td>"."<td style='font-weight:bold'>".$totalLateCount."</td>"."</tr>";
					echo "</table>";
				}
				?>
			</div>
			<div class="col">
				<h2>Claims by Appraiser</h2>
				<?php 
				if($startDate && $endDate){
					echo "<table style='width: 100%'>
					<tr>
					<th>Appraiser</th>
					<th>UnWorked</th>
					<th>Worked</th>
					</tr>";
					$totalUnworked=0;
					$totalWorked=0;
					foreach($phpArray as $item) {
						$workedsql = "SELECT claimID
						FROM dbo.claim_table 
						WHERE (staffReviewDate >= (?) ) AND (staffReviewDate <= (?) ) AND staffReviewDateAssignor = (?)";
						$workedparams = array($startDate, $endDate, $item);
						$claim_result_worked = sqlsrv_query($conn, $workedsql, $workedparams);
						$worked=0;
						while($row = sqlsrv_fetch_array( $claim_result_worked, SQLSRV_FETCH_NUMERIC))
						{
							$worked++;
							$totalWorked++;
						}

						$tsql = "SELECT claimID
						FROM dbo.claim_table 
						WHERE (staffReview >= (?) ) AND (staffReview <= (?) ) AND staffReviewAssignee = (?)";
						$params = array($startDate, $endDate, $item);
						$claim_result = sqlsrv_query($conn, $tsql, $params);
						$unWorked=0;
						while( $row = sqlsrv_fetch_array( $claim_result, SQLSRV_FETCH_NUMERIC))
						{
							$unWorked++;
						}

						$sumUnworked=$unWorked-$worked;
						$totalUnworked=$totalUnworked+$sumUnworked;
						echo "<tr>"."<td>".$item."</td>"."<td>".$sumUnworked."</td>"."<td>".$worked."</td>"."</tr>";
					}
					echo "<tr>"."<td style='font-weight:bold'>Total Volume</td>"."<td>".$totalUnworked."</td>"."<td>".$totalWorked."</td>"."</tr>";
					echo "</table>";
				}
				?>
			</div>

		</div>
	</div>

</body>
</html>
