<?php
session_start(); 
$message=null;
function dynamic_select($the_array, $element_name, $label = '', $init_value = '') {
    $menu = '';
    if ($label != '') $menu .= '
    	<label for="'.$element_name.'">'.$label.'</label>';
    $menu .= '
    	<select name="'.$element_name.'" id="'.$element_name.'">';
    if (empty($_REQUEST[$element_name])) {
        $curr_val = $init_value;
    } else {
        $curr_val = $_REQUEST[$element_name];
    }
    foreach ($the_array as $key => $value) {
        $menu .= '
			<option value="'.$key.'"';
        if ($key == $curr_val) $menu .= ' selected="selected"';
        $menu .= '>'.$value.'</option>';
    }
    $menu .= '
    	</select>';
    return $menu;
}
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

$tsql = "SELECT name FROM temp_table";

$array = array();

$stmt = sqlsrv_query( $conn, $tsql);
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
     $array[$row[0]]=$row[0];
}
if(isset($_POST['submit'])){ //check if form was submitted

	$option = null;
	if (isset($_POST['option'])) {
		$option = $_POST['option'];
	}

	$claimID = null;
	if (isset($_POST['claimID'])) {
		$claimID = $_POST['claimID'];

	}

	if(strcasecmp($option, "Claim Received")==0){
			$claim_query = "INSERT INTO dbo.claim_table
			(claimID, claimant,claimantSSN,spouse,spouseSSN,currentAPN,dateAcquired,dateOccupied,
			currentStName,currentApt,currentCity,currentState,currentZip,
			mailingStName,mailingApt,mailingCity,mailingState,mailingZip,
			priorAPN,dateMovedOut,priorStName,priorApt,priorCity,priorState,priorZip,
			rollTaxYear,exemptRE,suppTaxYear,exemptRE2,claimAction,findingReason,claimReceived,
			supervisorWorkload,staffReview,staffReviewDate,supervisorReview,caseClosed)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			foreach($claimID as $item) {
				$claim_params = array((int)$item, null, null,null,null,null, null, null, null,null, null, null, null,null, null, null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,date("m.d.y"),null,null,null,null,null);
				/* Execute the query. */                  
				$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);
			}
	}

	sqlsrv_close($conn);
  	$message = "Processed";
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


</head>
<body>
<ul>
  <li><a href="home_page.php">Home</a></li>
  <li><a href="scan_claims_page.php">Scan Claims</a></li>
  <li><a href="create_claim_page.php">Claim</a></li>
  <li><a href="advanced_search_page.php">Advanced Search</a></li>
  <li><a href="index.php">Logout</a></li>
</ul>
<div class="container rounded col-12 p-3" id="signin-container">
	<?php 
	if($message){
		echo '<div class="alert alert-success"><strong>Processed!</strong></div>';
	}
	?>
	<div class="row">
		<h1 class="col" style="padding-bottom: 20px;">Scan Claims</h1>
	</div>
	<div class="row">
		<div class="col" id="form-col">
			<form id="login-form" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
				<div class="col-2 form-group required">
					<br>
					<span>Assign To:</span>
					<?php echo dynamic_select($array, 'users', ''); ?>
				</div>
				<span>Claim Status:</span>
				<select id="option" name="option">
				  <option disabled selected value> -- select an option -- </option>
				  <option value="Claim Received">Claim Received</option>
				  <option value="Supervisor Workload">Supervisor Workload</option>
				  <option value="Staff Review">Staff Review</option>
				  <option value="Supervisor Review">Supervisor Review</option>
				  <option value="Hold">Hold</option>
				  <option value="Closed">Closed</option>
				  <option value="Preprint Sent">Preprint Sent</option>
				</select>
				<br>
				<hr>
				<br>
				<div>
					<div id="add" class="btn btn-success">Add Input</div>
					<button type="submit" name="submit" class="btn btn-danger">Process</button>
					<div id="reset" class="btn btn-secondary">Reset</div>
				</div>
				<hr>
				<h1>Claim ID:</h1>
				<div class="form-group p-1">
					<div class="form-row">
						<div class="col-4 form-group required" id="items">
							<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" />
						</div>
					</div>
				</div>
			</form>
		</div>
	</div> <!-- end row -->
</div> <!-- end container -->
<!-- Custom JS -->
<script type="text/javascript">
//when the reset Field button is clicked
$("#reset").click(function () {
	//$("#claimID").val('');
	console.log("reset");
});

$("#add").click(function () {
	console.log("clicked");
//Append a new row of code to the "#items" div
  $("#items").append('<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" />');
  $(".inputs").keyup(function () {
    if (this.value.length == this.maxLength) {
    	$(this).next('.inputs').focus();
	}
});
});


$(".inputs").keyup(function () {
    if (this.value.length == this.maxLength) {
    	$(this).next('.inputs').focus();
	}
});

$(document).on("keypress", "form", function(event) { 
    return event.keyCode != 13;
});
</script>
</body>
</html>
