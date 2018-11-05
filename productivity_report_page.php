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
sqlsrv_close($conn);  
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
	<?php 
	if($message){
		echo '<div class="alert alert-success"><strong>Processed!</strong></div>';
		//echo $message;
	}
	?>
	<div class="row">
		<h1 class="col" style="padding-bottom: 20px;">Productivity Report</h1>
	</div>
	<div class="row">
		<div class="col" id="form-col">
			<form id="login-form" autocomplete="off" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
			</form>
		</div>
	</div>
</div>

</body>
</html>
