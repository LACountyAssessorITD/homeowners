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

$tsql = "SELECT name FROM temp_table";

$phpArray = array();

$stmt = sqlsrv_query( $conn, $tsql);
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	array_push($phpArray, $row[0]);
}
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
?>
<!doctype html>
<html lang="en">
<head>
	<title>Scan Claim Page</title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="styles/home-style.css">
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
	</style>
</head>
<body>
<ul>
  <li><a href="home_page.php">Home</a></li>
  <li><a href="productivity_report_page.php">Productivity Report</a></li>
  <li><a href="scan_claims_page.php">Scan Claims</a></li>
  <li><a href="create_claim_page.php">Claim</a></li>
  <li><a href="advanced_search_page.php">Advanced Search</a></li>
  <li><a href="index.php">Logout</a></li>
  <li style="float:right" ><form action="claim_page.php" method="get"><input type="text" name="claimID" placeholder="Search by Claim ID..."><input type="submit"></form></li>
</ul>
<div class="container rounded col-12 p-3" id="signin-container">
	<div class="row">
		<h1 class="col" style="padding-bottom: 20px;">Productivity Report</h1>
	</div>
	<div class="row">
		<div class="col-4"></div>
		<div class="col-4">
			<form id="login-form" autocomplete="off" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
			<label for="startDate">Start Date:</label>
			<input class="form-control" id="startDate" name="startDate" placeholder="1/23/2000" type="date">
			<label for="endDate">End Date:</label>
			<input class="form-control" id="endDate" name="endDate" placeholder="1/23/2000" type="date">
			<button type="submit" name="submit" class="btn btn-danger">Get Productivity Report</button>
			</form>
		</div>	
		<div class="col-4">
		</div>
	</div>
	<hr class="my-4">
	<div class="row">
		<div class="col-3"></div>
		<div class="col-3">
			<?php 
				if($startDate){
					echo "<h4>Start</h4><h3>".$startDate."</h3>";
				}
			?>
		</div>
		<div class="col-3">
			<?php 
				if($endDate){
					echo "<h4>End</h4><h3>".$endDate."</h3>";
				}
			?>
		</div>
		<div class="col-3"></div>
	</div>
	<hr class="my-4">
	<div class="row">
		<hr>
		<div class="col-4">
			<h2>Claims by Status</h2>
		</div>
		<div class="col-4">
			<h2>Claims by Appraiser</h2>
			<?php 
				if($startDate && $endDate){
					echo "<table style='width: 100%'>
							<tr>
								<th>Appraiser</th>
								<th>UnWorked</th>
    							<th>Worked</th>
 							 </tr>
 							 <tr>
								<td>-</td>
								<td>-</td>
    							<td>-</td>
 							 </tr>";
					foreach($phpArray as $item) {
						$workedsql = "SELECT claimID
						 FROM dbo.claim_table 
						 WHERE (staffReviewDate >= (?) ) AND (staffReviewDate <= (?) ) AND lower(staffReviewDateAssignee) = (?)";
						$workedparams = array($startDate, $endDate, $item);
						$claim_result_worked = sqlsrv_query($conn, $workedsql, $workedparams);
						$worked=0;
						while($row = sqlsrv_fetch_array( $claim_result_worked, SQLSRV_FETCH_NUMERIC))
						{
							$worked++;
						}

						$tsql = "SELECT claimID
						 FROM dbo.claim_table 
						 WHERE (staffReview >= (?) ) AND (staffReview <= (?) ) AND staffReviewDateAssignee = (?)";
						$params = array($startDate, $endDate, $item);
						$claim_result = sqlsrv_query($conn, $tsql, $params);
						$unWorked=0;
						while( $row = sqlsrv_fetch_array( $claim_result, SQLSRV_FETCH_NUMERIC))
						{
							$unWorked++;
						}

						$totalUnworked=$unWorked-$worked;
					    echo "<tr>"."<td>".$item."</td>"."<td>".$totalUnworked."</td>"."<td>".$worked."</td>"."</tr>";
					}
					echo "</table>";
				}
			?>
			</div>
		<div class="col-4">
			<h2>Claims by Function</h2>
		</div>
	</div>
</div>

</body>
</html>
