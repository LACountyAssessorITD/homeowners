<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<title>File a HOX Claim</title>

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
	<link rel="stylesheet" type="text/css" href="styles/home-style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">

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
		<h1 class="col" style="padding-bottom: 20px;">Claim</h1>
	</div>
	<div class="alert alert-success alert-dismissible collapse" role="alert" id="successAlert">
		<div id="submitSuccess"> Submission Success
		</div>
		<button type="button" class="close" data-hide="alert">&times;</button>
	</div>
	<div class="alert alert-danger alert-dismissible collapse" role="alert" id="failAlert">
		<div id="submitFail"> Submission Failed
		</div>
		<button type="button" class="close" data-hide="alert">&times;</button>
	</div>
	<div class="row">
		<div class="col" id="form-col">
			<form id="claim-form" method="post" action="">
				<div class="form-group p-1">
					<!-- personal info row -->
					<div>
						<h5>Personal Information</h5>
					</div>
					<div class="form-row">
						<div class="col-2 form-group required">
							<label for="claimID">ClaimID:</label>
							<input class="form-control" id="claimID" name="claimID" placeholder="1234567" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="claimant">Claimant:</label>
							<input class="form-control" id="claimant" name="claimant" placeholder="Last, First Middle" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="claimantSSN" class="control-label">SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="claimantSSN" name="claimantSSN" placeholder="123456789" type="number" min="0" data-bind="value:claimantSSN">
						</div>
						<div class="col-4 form-group required">
							<label for="spouse">Spouse (If applicable):</label>
							<input class="form-control" id="spouse" name="spouse" placeholder="Last, First Middle" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="spouseSSN" class="control-label">Spouse SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="spouseSSN" name="spouseSSN" placeholder="123456789" type="number" min="0" data-bind="value:spouseSSN">
						</div>
					</div>
				</div>
				<hr class="my-4">

				<!-- AIN lookup -->
				<div class="form-group row p-1">
					<label for="AINSearchInput" class="col-auto col-form-label">
						<h4 id="searchText">Enter AIN here to search for a match:</h4>
					</label>
					<div class="col-9 col-sm-9 col-md-4">
						<input class="form-control" id="AINSearchInput" name="AINSearchInput" placeholder="1234567890" type="number" min="0" data-bind="value:AINSearchInput">
						<!--div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fas fa-search"></i></div>
							</div>
							<input class="form-control" id="AINSearchInput" name="AINSearchInput" placeholder="1234567890" type="number" min="0" data-bind="value:AINSearchInput">
						</div-->
					</div>
					<div class="col-auto">
						<button type="button" id="AINSearchBtn" name="AINSearchBtn" class="btn btn-info mb-2">Search</button>
					</div>
				</div>
				<div class="alert alert-warning alert-dismissible collapse" role="alert" id="searchAlert">
					<div id="alertMsg">
					</div>
					<button type="button" class="close" data-hide="alert">&times;</button>
				</div>

				<!-- situs info row -->
				<div class="form-row">
					<div class="form-col col p-2">
						<div>
							<h5>Situs Information</h5>
						</div>
						<div class="form-row">
							<div class="col-9 form-group required">
								<label for="currentStName">Street Number and Name:</label>
								<input class="form-control" id="currentStName" name="currentStName" placeholder="123 Any Street" type="text">
							</div>
							<div class="col-3 form-group required">
								<label for="currentApt">Apt/Ste/Flr #:</label>
								<input class="form-control" id="currentApt" name="currentApt" placeholder="APT 101" type="text">
							</div>
						</div>
						<div class="form-row">
							<div class="col-6 form-group required">
								<label for="currentCity">Current City:</label>
								<input class="form-control" id="currentCity" name="currentCity" placeholder="Los Angeles" type="text">
							</div>
							<div class="col-3 form-group required">
								<label for="currentState">Current State:</label>
								<select class="form-control" id="currentState" name="currentState">
									<option value="NA" disabled selected>Select</option>
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
							</div>
							<div class="col-3 form-group required">
								<label for="currentZip">Current ZIP:</label>
								<!-- TODO: onchange valid number check and formatting -->
								<input class="form-control" id="currentZip" name="currentZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:currentZip">
							</div>
						</div>
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
					</div> <!-- end situs info col -->

					<!-- begin mailing address col -->
					<div class="form-col col p-2">
						<div>
							<h5>Mailing Address</h5>
						</div>
						<div class="form-row">
							<div class="col-9 form-group required">
								<label for="mailingStName">Street Number and Name:</label>
								<input class="form-control" id="mailingStName" name="mailingStName" placeholder="123 Any Street" type="text" disabled="true">
							</div>
							<div class="col-3 form-group required">
								<label for="mailingApt">Apt/Ste/Flr #:</label>
								<input class="form-control" id="mailingApt" name="mailingApt" placeholder="APT 101" type="text" disabled="true">
							</div>
						</div>
						<div class="form-row">
							<div class="col-6 form-group required">
								<label for="mailingCity">City or Town:</label>
								<input class="form-control" id="mailingCity" name="mailingCity" placeholder="Los Angeles" type="text" disabled="true">
							</div>
							<div class="col-3 form-group required">
								<label for="mailingState">State:</label>
								<select class="form-control" id="mailingState" name="mailingState" disabled="true">
									<option value="NA" disabled selected>Select</option>
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
							</div>
							<div class="col-3 form-group required">
								<label for="mailingZip">ZIP Code:</label>
								<!-- TODO: onchange valid number check and formatting -->
								<input class="form-control" id="mailingZip" name="mailingZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:mailingZip" disabled="true">
							</div>
						</div>
						<div class="col form-check required">
							<input class="form-check-input" type="checkbox" value="" id="enableMailing" name="enableMailing">
							<label  class="form-check-label" for="enableMailing">Check if mailing address is different from situs address to enable input</label>
						</div>
					</div> <!-- end mailing col -->
				</div> <!-- end situs row -->
				<hr class="my-4">

				<!-- begin prior info row -->
				<div class="form-row">
					<div class="form-col col p-2"> <!-- begin prior info col -->
						<div>
							<h5>Prior Address (If applicable)</h5>
						</div>
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
							<div class="col-9 form-group required">
								<label for="priorStName">Street Number and Name:</label>
								<input class="form-control" id="priorStName" name="priorStName" placeholder="123 Any Street" type="text">
							</div>
							<div class="col-3 form-group required">
								<label for="priorApt">Apt/Ste/Flr #:</label>
								<input class="form-control" id="priorApt" name="priorApt" placeholder="APT 101" type="text">
							</div>
						</div>
						<div class="form-row">
							<div class="col-6 form-group required">
								<label for="priorCity">Prior City:</label>
								<input class="form-control" id="priorCity" name="priorCity" placeholder="Los Angeles" type="text">
							</div>
							<div class="col-3 form-group required">
								<label for="priorState">Prior State:</label>
								<select class="form-control" id="priorState" name="priorState">
									<option value="N/A" disabled selected>Select</option>
									<option value="AL">Alabama</option>
									<option value="AK">Alaska</option>
									<option value="AZ">Arizona</option>
									<option value="AR">Arkansas</option>
									<option value="CA">California</option>
									<option value="CO">Colorado</option>
									<option value="CT">Connecticut</option>
									<option value="DE">Delaware</option>
									<option value="DC">District Of Columbia</option>
									<option value="FL">Florida</option>
									<option value="GA">Georgia</option>
									<option value="HI">Hawaii</option>
									<option value="ID">Idaho</option>
									<option value="IL">Illinois</option>
									<option value="IN">Indiana</option>
									<option value="IA">Iowa</option>
									<option value="KS">Kansas</option>
									<option value="KY">Kentucky</option>
									<option value="LA">Louisiana</option>
									<option value="ME">Maine</option>
									<option value="MD">Maryland</option>
									<option value="MA">Massachusetts</option>
									<option value="MI">Michigan</option>
									<option value="MN">Minnesota</option>
									<option value="MS">Mississippi</option>
									<option value="MO">Missouri</option>
									<option value="MT">Montana</option>
									<option value="NE">Nebraska</option>
									<option value="NV">Nevada</option>
									<option value="NH">New Hampshire</option>
									<option value="NJ">New Jersey</option>
									<option value="NM">New Mexico</option>
									<option value="NY">New York</option>
									<option value="NC">North Carolina</option>
									<option value="ND">North Dakota</option>
									<option value="OH">Ohio</option>
									<option value="OK">Oklahoma</option>
									<option value="OR">Oregon</option>
									<option value="PA">Pennsylvania</option>
									<option value="RI">Rhode Island</option>
									<option value="SC">South Carolina</option>
									<option value="SD">South Dakota</option>
									<option value="TN">Tennessee</option>
									<option value="TX">Texas</option>
									<option value="UT">Utah</option>
									<option value="VT">Vermont</option>
									<option value="VA">Virginia</option>
									<option value="WA">Washington</option>
									<option value="WV">West Virginia</option>
									<option value="WI">Wisconsin</option>
									<option value="WY">Wyoming</option>
								</select>
							</div>
							<div class="col-3 form-group required">
								<label for="priorZip">Prior ZIP:</label>
								<!-- TODO: onchange valid number check and formatting -->
								<input class="form-control" id="priorZip" name="priorZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:priorZip">
							</div>
						</div>
					</div> <!-- end prior info col -->

					<div class="form-col col p-2"> <!-- begin exempt info col -->
						<div>
							<h5>Exemption Information</h5>
						</div>
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
					</div> <!-- end exempt info col -->
				</div> <!-- end prior info row -->
				<hr class="my-4">

				<div>
					<h5>Reasons for Decision</h5>
				</div>
				<div class="form-row">
					<div class="col form-group required">
						<label for="claimAction">Claim Action:</label>
						<select class="form-control" id="claimAction" name="claimAction">
							<option value="NA" disabled selected>Select</option>
							<option value="Met">Met</option>
							<option value="Partially Met">Partially Met</option>
							<option value="Denied">Denied</option>
						</select>
					</div>
					<div class="col form-group required">
						<label for="findingReason">Finding Reason:</label>
						<select class="form-control" id="findingReason" name="findingReason">
							<option value="NA" disabled selected>Select</option>
							<option value="Missing SSN">Missing SSN</option>
							<option value="Missing Signature">Missing Signature</option>
							<option value="Incomplete Address">Incomplete Address</option>
							<option value="N/A">N/A</option>
							<option value="Other">Other</option>
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
					<button type="submit" name="save" class="btn btn-danger">Submit</button>
					<button type="reset" class="btn btn-secondary">Reset</button>
				</div>

			</form> <!-- end form -->
		</div>
	</div> <!-- end row -->
</div> <!-- end container -->

<!-- Custom JS -->
<script type="text/javascript">
	// enable input for mailing if box is checked
	document.getElementById("enableMailing").onchange = function() {
		document.getElementById("mailingStName").disabled = !this.checked;
		document.getElementById("mailingApt").disabled = !this.checked;
		document.getElementById("mailingCity").disabled = !this.checked;
		document.getElementById("mailingState").disabled = !this.checked;
		document.getElementById("mailingZip").disabled = !this.checked;
	};

	// for re-showing alert
	$(function(){
		$("[data-hide]").on("click", function(){
			$(this).closest("." + $(this).attr("data-hide")).hide();
		});
	});

	// autofill with json callback
	document.getElementById("AINSearchBtn").onclick = function() {
		var failMsg = "No match was found in database."
		var successMsg = "Match found. Homeowner name on file: ";
		var ainValue = document.getElementById("AINSearchInput").value;

		var request = new XMLHttpRequest();
		request.overrideMimeType("application/json");
		request.open("GET", "ainlookup.php?ain="+ainValue,true);

		request.onload = function () {
			// begin accessing JSON data here
			// console.log(this.response);
			if (this.response!=null) {
				var jsonResponse = JSON.parse(this.response);
				console.log(jsonResponse);

				if (jsonResponse["hasData"]=="true") {
					// valid data
					// set form input val to jsonResponse
					// ["4109018003","211060850",7000,"7918"," ","COWAN AVE"," "," ","LOS ANGELES CA","CA","900451139",null,null,null,null,null,null,"SHIKIAR,ANDREW AND"]
					$('#currentAPN').val(jsonResponse["AIN"]);
					//$('#rollTaxYear').val(jsonResponse["RecDate"]);
					//$('#exemptRE').val(jsonResponse["HOXAmount"]);

					var streetAddr = jsonResponse["SitusHouseNo"] + " " + jsonResponse["SitusStreet"];
					$('#currentStName').val(streetAddr);
					$('#currentApt').val(jsonResponse["SitusUnit"]);
					$('#currentCity').val(jsonResponse["SitusCity"]);
					$('#currentState').val(jsonResponse["SitusState"]);
					//$('#currentAPN').val(jsonResponse["OwnerName"]);

					$('#alertMsg').html(successMsg+"<strong>"+jsonResponse["OwnerName"]+"</strong>");
				} else {
					$('#alertMsg').html("<strong>"+failMsg+"</strong>");

					// reset
					$('#currentAPN').val('');
					//$('#rollTaxYear').val('');
					//$('#exemptRE').val('');
					$('#currentStName').val('');
					$('#currentApt').val('');
					$('#currentCity').val('');
					$('#currentState').val('');
				}

			} else {
				$('#alertMsg').html("<strong>"+failMsg+"</strong>");

				// reset
				$('#currentAPN').val('');
				//$('#rollTaxYear').val('');
				//$('#exemptRE').val('');
				$('#currentStName').val('');
				$('#currentApt').val('');
				$('#currentCity').val('');
				$('#currentState').val('');
			}	
		}
		request.send();


		$('#searchAlert').show();
	};

	// post form with ajax, think this will help staying on same page
	$("#claim-form").on("submit", function() {
		var cform = document.getElementById("claim-form");
		var fd = new FormData(cform);
		
		$.ajax({
			url: "write_claim.php",
			data: fd,
			cache: false,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function (response) {
				window.location = "#";
				if (response == "create_success") {
					// show create success msg
					$('#failAlert').hide();
					$('#submitSuccess').html("<strong>Create Claim Success</strong>");
					$('#successAlert').show();
				}
				else if (response == "update_success") {
					// show success msg
					$('#failAlert').hide();
					$('#submitSuccess').html("<strong>Update Success</strong>");
					$('#successAlert').show();
				}
				else {
					// show error msg
					$('#successAlert').hide();
					$('#submitFail').html("Submission failed. <strong>Error: "+response+"</strong>");
					$('#failAlert').show();
				}
			}
		});

		// forgetting to return false will cause page to refresh 
		// and lose control on all prev objects...
    	return false;
	});

</script>
</body>
</html>
