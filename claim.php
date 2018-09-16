<?php
	session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<title>Claim</title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- Custom CSS -->
	<style type="text/css">
		body {
			background-color: pink;
			background-size: cover;
			background-repeat: no-repeat;
		}

		.jumbotron {
			background-color: #669900;
			padding-top: 32px;
		}

		#signin-container {
			background-color: rgba(245, 245, 245, 0.4);
			padding: 40px;
		}

		#form-col {
		}

		.form-group.required .control-label:after {
			content:" *";
			color:red;
		}

	</style>

	<!-- Custom JS -->
	<!-- TODO: MAKE ALL FIELDS REQUIRED -->
	<!--script type="text/javascript" src="scripts/script.js"></script-->
</head>

<body class="jumbotron">
	<div class="container rounded col-12" id="signin-container">
		<div class="row">
			<div class="col" id="form-col">
				<form id="login-form" action="home.php" method="post">

					<div class="form-row">
						<div class="col form-group required">
							<label for="claimant" class='control-label'>Claimant:</label>
							<input class="form-control" id="claimant" name="claimant" placeholder="Last, First Middle" type="text">
						</div>

						<div class="col form-group required">
							<label for="spouse" class='control-label'>Spouse:</label>
							<input class="form-control" id="spouse" name="spouse" placeholder="Last, First Middle" type="text">
						</div>
					</div>
					

					<hr class="my-4">

					<div class="form-row">
						<div class="col form-group required">
							<label for="currentAPN">Current APN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="currentAPN" name="currentAPN" placeholder="1234567890" type="number" min="0" data-bind="value:currentAPN">
						</div>
					
						<div class="col form-group required">
							<label for="dateAcquired">Date Acquired:</label>
							<input class="form-control" id="dateAcquired" name="dateAcquired" placeholder="1/23/2000" type="date">
						</div>

						<div class="col form-group required">
							<label for="dateOccupied">Date Occupied:</label>
							<input class="form-control" id="dateOccupied" name="dateOccupied" placeholder="1/23/2000" type="date">
						</div>
					</div>

					<div class="form-row">
						<div class="col-4 form-group required">
							<label for="currentStNum">Current St. Number:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="currentStNum" name="currentStNum" placeholder="123" type="number" min="0" data-bind="value:currentStNum">
						</div>

						<div class="col-8 form-group required">
							<label for="currentStName">Current St. Name:</label>
							<input class="form-control" id="currentStName" name="currentStName" placeholder="Any Street" type="text">
						</div>
					</div>

					<div class="form-row">
						<div class="col form-group required">
							<label for="currentCity">Current City:</label>
							<input class="form-control" id="currentCity" name="currentCity" placeholder="Los Angeles" type="text">
						</div>

						<div class="col form-group required">
							<label for="currentZip">Current Zip:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="currentZip" name="currentZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:currentZip">
						</div>
					</div>

  					<hr class="my-4">

  					<div class="form-row">
	  					<div class="col form-group required">
							<label for="priorAPN">Prior APN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="priorAPN" name="priorAPN" placeholder="1234567890" type="number" min="0" data-bind="value:priorAPN">
						</div>

						<div class="col form-group required">
							<label for="dateMovedOut">Date Moved Out:</label>
							<input class="form-control" id="dateMovedOut" name="dateMovedOut" placeholder="1/23/2000" type="date">
						</div>
					</div>

					<div class="form-row">
						<div class="col-4 form-group required">
							<label for="priorStNum">Prior St. Number:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="priorStNum" name="priorStNum" placeholder="123" type="number" min="0" data-bind="value:priorStNum">
						</div>

						<div class="col-8 form-group required">
							<label for="priorStName">Prior St. Name:</label>
							<input class="form-control" id="priorStName" name="priorStName" placeholder="Any Street" type="text">
						</div>
					</div>

					<div class="form-row">
						<div class="col form-group required">
							<label for="priorCity">Prior City:</label>
							<input class="form-control" id="priorCity" name="priorCity" placeholder="Los Angeles" type="text">
						</div>

						<div class="col form-group required">
							<label for="priorZip">Prior Zip:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="priorZip" name="priorZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:priorZip">
						</div>
					</div>

  					<hr class="my-4">

  					<div class="form-row">
	  					<div class="col form-group required">
							<label for="rollTaxYear">Roll Tax Year:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="rollTaxYear" name="rollTaxYear" placeholder="218000" type="number" min="0" data-bind="value:rollTaxYear">
						</div>

						<div class="col form-group required">
							<label for="exemptRE">ExemptRE:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="exemptRE" name="exemptRE" placeholder="7000" type="number" min="0" data-bind="value:exemptRE">
						</div>
					</div>

  					<hr class="my-4">

  					<div class="form-row">
	  					<div class="col form-group required">
							<label for="suppTaxYear">Supp Tax Year:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="suppTaxYear" name="suppTaxYear" placeholder="218000" type="number" min="0" data-bind="value:suppTaxYear">
						</div>

						<div class="col form-group required">
							<label for="exemptRE2">ExemptRE2:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="exemptRE2" name="exemptRE2" placeholder="7000" type="number" min="0" data-bind="value:exemptRE2">
						</div>
					</div>

  					<hr class="my-4">

  					<div class="form-row">
						<div class="col form-group required">
							<label for="claimAction">Claim Action:</label>
							<select class="form-control" id="claimAction" name="claimAction">
								<option>Met</option>
								<option>Partially Met</option>
								<option>Denied</option>
							</select>
						</div>

						<div class="col form-group required">
							<label for="findingReason">Finding Reason:</label>
							<select class="form-control" id="findingReason" name="findingReason">
								<option>Missing SSN</option>
								<option>Missing Signature</option>
								<option>Incomplete Address</option>
								<option>Other</option>
							</select>
						</div>
					</div>

					<hr class="my-4">
					<h5>Status Dates</h5>
					<div class="form-row">
						<div class="col form-group required">
							<label for="claimReceived">Claim Received:</label>
							<input class="form-control" id="claimReceived" name="claimReceived" placeholder="1/1/2018" type="date">
						</div>
						<div class="col form-group required">
							<label for="supervisorWorkload">Supervisor Workload:</label>
							<input class="form-control" id="supervisorWorkload" name="supervisorWorkload" placeholder="1/1/2018" type="date">
						</div>
						<div class="col form-group required">
							<label for="staffReview">Staff Review:</label>
							<input class="form-control" id="staffReview" name="staffReview" placeholder="8/1/2018" type="date">
						</div>
						<div class="col form-group required">
							<label for="staffReviewDate">Staff Review Date:</label>
							<input class="form-control" id="staffReviewDate" name="staffReviewDate" placeholder="1/2/2018" type="date">
						</div>
						<div class="col form-group required">
							<label for="supervisorReview">Supervisor Review:</label>
							<input class="form-control" id="supervisorReview" name="supervisorReview" placeholder="1/3/2018" type="date">
						</div>
						<div class="col form-group required">
							<label for="caseClosed">Case Closed:</label>
							<input class="form-control" id="caseClosed" name="caseClosed" placeholder="1/11/2018" type="date">
						</div>
					</div>

					<!-- buttons -->
					<div class="form-group text-right p-3">
						<button type="submit" class="btn btn-danger">Submit</button>
						<button type="reset" class="btn btn-secondary">Reset</button>
					</div>

				</form> <!-- end form -->
			</div>
		</div> <!-- end row -->
	</div> <!-- end container -->
</body>
</html>
