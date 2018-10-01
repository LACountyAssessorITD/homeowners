<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<title>Scan Claim Page</title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
	<div class="row">
		<h1 class="col" style="padding-bottom: 20px;">Scan Claims Page</h1>
	</div>
	<div class="row">
		<div class="col" id="form-col">
			<select>
			  <option value="Claim Received">Claim Received</option>
			  <option value="Supervisor Workload">Supervisor Workload</option>
			  <option value="Staff Review">Staff Review</option>
			  <option value="Supervisor Review">Supervisor Review</option>
			  <option value="Hold">Hold</option>
			  <option value="Closed">Closed</option>
			  <option value="Preprint Sent">Preprint Sent</option>
			</select>
			<form id="login-form" action="write_scanned_claims.php" method="post">
				<div class="form-group p-1">
					<div class="form-row">
						<div class="col-8 form-group required">
							<p>Claim IDs:</p>
							<textarea id="claimID" name="claimID" rows="10" cols="50">
							</textarea>
						</div>
					</div>
					<div id="options">
						<button type="submit" class="btn btn-danger">Process</button>
						<div id="reset" class="btn btn-secondary">Reset</div>
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
	$("#Claim_ID").val('');
	console.log("reset");
});
</script>
</body>
</html>
