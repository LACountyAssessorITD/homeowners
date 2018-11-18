<?php
	session_start();
	include('LDAP/constants.php');
	$message=null;

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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
	<link rel="stylesheet" type="text/css" href="styles/general-style.css">

	<style>
	.row-bottom-margin {
		margin-bottom: -20px;
	}
	.col-right-padding {
    	padding-right: 0px;
	}
	.info-status-grid {
		background-color: #D6EAF8; 
		padding-left: 24px; 
		padding-right: 24px;
	}
	.situs-row-bottom-margin {
		margin-bottom: -15px;
	}
	</style>
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
				<a class="nav-link" href="productivity_report_page.php">Productivity Report</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="scan_claims_page.php">Scan Claims</a>
			</li>
			<li class="nav-item">
				<a id="active-page" class="nav-link" href="create_claim_page.php">Claim</a>
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
				<div class="form-row">
					<!-- personal info row -->
					
					<div class="form-col col-sm-6" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 5px;">
						<div>
							<h5>Personal Information</h5>
						</div>
						<div class="form-row row-bottom-margin">
							<div class="col form-group required" >
								<div class="form-group row">
									<label for="claimant" class="col-sm-3 col-form-label col-form-label-sm">Claimant:</label>
									<div class="col-sm-9">
										<input class="form-control form-control-sm" id="claimant" name="claimant" placeholder="Last, First Middle" type="text">
									</div>
								</div>
							</div>
							<div class="col form-group required">
								<div class="form-group row">
									<label for="claimantSSN" class="col-sm-4 col-form-label col-form-label-sm" 
									style="padding-right: 0;">Claimant SSN:</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm" id="claimantSSN" name="claimantSSN" placeholder="123456789" type="number" min="0" data-bind="value:claimantSSN">
									</div>
								</div>
							</div>
						</div>

						<div class="form-row row-bottom-margin">
							<div class="col form-group required">
								<div class="form-group row">
									<label for="spouse" class="col-sm-3 col-form-label col-form-label-sm">Spouse:</label>
									<div class="col-sm-9">
										<input class="form-control form-control-sm" id="spouse" name="spouse" placeholder="If applicable" type="text">
									</div>
								</div>
							</div>
							<div class="col form-group required">
								<div class="form-group row">
									<label for="spouseSSN" class="col-sm-4 col-form-label col-form-label-sm" style="padding-right: 0px;">Spouse SSN:</label>
									<div class="col-sm-8">
										<input class="form-control form-control-sm" id="spouseSSN" name="spouseSSN" placeholder="123456789" type="number" min="0" data-bind="value:spouseSSN">
									</div>
								</div>
							</div>
						</div>
					</div> <!-- end personal info col -->

					<div class="form-col col-sm-6" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 5px;">
						<div>
							<h5>Claim Status</h5>
						</div>
						
						<div class="form-row row-bottom-margin">
							<div class="col form-group required" >
								<div class="form-group row">
									<label for="chooseStatus" class="col-sm-5 col-form-label col-form-label-sm" style="padding-right: 0px;">Choose Status:</label>
									<div class="col-sm-7">
										<select class="form-control form-control-sm" id="chooseStatus" name="chooseStatus">
											<option value="Claim Received">Claim Received</option>
											<option value="Supervisor Workload">Supervisor Workload</option>
											<option value="Staff Assign">Staff Assign</option>
											<option value="Staff Review Date">Staff Review Date</option>
											<option value="Supervisor Review">Supervisor Review</option>
											<option value="Hold">Hold</option>
											<option value="Case Closed">Case Closed</option>
											<option value="Preprint Sent">Preprint Sent</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col form-group required">
								<div class="form-group row">
									<label for="statusDate" class="col-sm-3 col-form-label col-form-label-sm" value="<?php echo date("Y-m-d"); ?>">Date:</label>
									<div class="col-sm-9">
										<input class="form-control form-control-sm" id="statusDate" name="statusDate" placeholder="1-1-2018" type="date">
									</div>
								</div>
							</div>
						</div>

						<div class="form-row row-bottom-margin">
							<div class="col form-group required">
								<div class="form-group row">
									<label for="assignee" class="col-sm-3 col-form-label col-form-label-sm">Assignee:</label>
									<div class="col-sm-9">
										<input class="form-control form-control-sm" id="assignee" name="assignee" placeholder="Last, First" type="text">
									</div>
								</div>
							</div>
							<div class="col form-group required">
								<div class="form-group row">
									<label for="assignor" class="col-sm-3 col-form-label col-form-label-sm">Assignor:</label>
									<div class="col-sm-9">
										<input class="form-control form-control-sm" id="assignor" name="assignor" placeholder="Last, First" type="text" value="<?php echo $_SESSION["name"]; ?>" >
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<hr class="my-2">

			<div class="form-row">
				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Claim/Property Information</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-6 form-group required">
							<label for="claimID" class="col-form-label col-form-label-sm">ClaimID:</label>
							<input class="form-control form-control-sm" id="claimID" name="claimID" placeholder="1234567" type="text">
						</div>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-12 form-group required">
							<label for="currentAPN" class="col-form-label col-form-label-sm">Current AIN:</label>
							<div class="form-row situs-row-bottom-margin">
								<div class="col-7">
									<input class="form-control form-control-sm" id="currentAPN" name="currentAPN" placeholder="1234567890" type="number" min="0" data-bind="value:currentAPN">
								</div>
								<div class="col">
									<button type="button" id="AINSearchBtn" name="AINSearchBtn" class="btn btn-info mb-2 btn-sm">Search for a match</button>
								</div>
							</div>	
						</div>
					</div>
				</div>

				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Exemption Information</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col form-group required">
							<label for="rollTaxYear" class="col-form-label col-form-label-sm">Roll Tax Year:</label>
							<input class="form-control form-control-sm" id="rollTaxYear" name="rollTaxYear" placeholder="218000" type="number" min="0" data-bind="value:rollTaxYear">
						</div>
						<div class="col form-group required">
							<label for="exemptRE" class="col-form-label col-form-label-sm">ExemptRE:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="exemptRE" name="exemptRE" placeholder="7000" type="number" min="0" data-bind="value:exemptRE">
						</div>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col form-group required">
							<label for="suppTaxYear" class="col-form-label col-form-label-sm">Supp Tax Year:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="suppTaxYear" name="suppTaxYear" placeholder="218000" type="number" min="0" data-bind="value:suppTaxYear">
						</div>
						<div class="col form-group required">
							<label for="exemptRE2" class="col-form-label col-form-label-sm">ExemptRE2:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="exemptRE2" name="exemptRE2" placeholder="7000" type="number" min="0" data-bind="value:exemptRE2">
						</div>
					</div>
				</div>

				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Reasons for Decision</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col form-group required">
							<label for="claimAction" class="col-form-label col-form-label-sm">Claim Action:</label>
							<select class="form-control form-control-sm" id="claimAction" name="claimAction">
								<option value="NA" disabled selected>Select</option>
								<option value="Met">Met</option>
								<option value="Partially Met">Partially Met</option>
								<option value="Denied">Denied</option>
							</select>
						</div>
						<div class="col form-group required">
							<label for="findingReason" class="col-form-label col-form-label-sm">Finding Reason:</label>
							<select class="form-control form-control-sm" id="findingReason" name="findingReason">
								<option value="N/A">N/A</option>
								<option value="Already Claimed Exemption">Already Claimed Exemption</option>
								<option value="Missing SSN">Missing SSN</option>
								<option value="Missing Signature">Missing Signature</option>
								<option value="Incomplete Address">Incomplete Address</option>
								<option value="Other">Other</option>
							</select>
						</div>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col form-group required">
							<label for="otherReason" class="col-form-label col-form-label-sm">Other Reason (If applicable):</label>
							<input class="form-control form-control-sm" id="otherReason" name="otherReason" placeholder="Specify other reason" type="text" disabled="true">
						</div>
					</div>
				</div>
			</div>
			<hr class="my-2">

			<!-- AIN lookup -->
<!-- 			<div class="form-group row p-1">
				<label for="AINSearchInput" class="col-auto col-form-label">
					<h4 id="searchText">Enter AIN here to search for a match:</h4>
				</label>
				<div class="col-9 col-sm-9 col-md-4">
				</div>
				<div class="col-auto">
					<button type="button" id="AINSearchBtn" name="AINSearchBtn" class="btn btn-info mb-2">Search</button>
				</div>
			</div>
 -->
			<div class="alert alert-warning alert-dismissible collapse" role="alert" id="searchAlert">
				<div id="alertMsg">
				</div>
				<button type="button" class="close" data-hide="alert">&times;</button>
			</div>

			<!-- situs info row -->
			<div class="form-row">
				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Situs Information</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-8 form-group required">
							<label for="currentStName" class="col-form-label col-form-label-sm">Street Number and Name:</label>
							<input class="form-control form-control-sm" id="currentStName" name="currentStName" placeholder="123 Any Street" type="text">
						</div>
						<div class="col-4 form-group required" >
							<label for="currentApt" class="col-form-label col-form-label-sm">Apt/Ste/Flr #:</label>
							<input class="form-control form-control-sm" id="currentApt" name="currentApt" placeholder="APT 101" type="text">
						</div>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-6 form-group required">
							<label for="currentCity" class="col-form-label col-form-label-sm">Current City:</label>
							<input class="form-control form-control-sm" id="currentCity" name="currentCity" placeholder="Los Angeles" type="text">
						</div>
						<div class="col-6 form-group required">
							<label for="currentState" class="col-form-label col-form-label-sm">Current State:</label>
							<select class="form-control form-control-sm" id="currentState" name="currentState">
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
						
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-3 form-group required">
							<label for="currentZip" class="col-form-label col-form-label-sm">Current ZIP:</label>
							<input class="form-control form-control-sm" id="currentZip" name="currentZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:currentZip">
						</div>
						<div class="col-9 form-group required">
							<div class="form-row situs-row-bottom-margin">
								<div class="col-6">
									<label for="dateAcquired" class="col-form-label col-form-label-sm">Date Acquired:</label>
									<input class="form-control form-control-sm" id="dateAcquired" name="dateAcquired" placeholder="1/23/2000" type="date">
								</div>
								<div class="col-6">
									<label for="dateOccupied" class="col-form-label col-form-label-sm">Date Occupied:</label>
									<input class="form-control form-control-sm" id="dateOccupied" name="dateOccupied" placeholder="1/23/2000" type="date">
								</div>
							</div>
						</div>
					</div>
				</div> <!-- end situs info col -->

				<!-- begin mailing address col -->
				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Mailing Address</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-8 form-group required">
							<label for="mailingStName" class="col-form-label col-form-label-sm">Street Number and Name:</label>
							<input class="form-control form-control-sm" id="mailingStName" name="mailingStName" placeholder="123 Any Street" type="text" disabled="true">
						</div>
						<div class="col-4 form-group required">
							<label for="mailingApt" class="col-form-label col-form-label-sm">Apt/Ste/Flr #:</label>
							<input class="form-control form-control-sm" id="mailingApt" name="mailingApt" placeholder="APT 101" type="text" disabled="true">
						</div>
					</div>
					<div class="form-row">
						<div class="col-5 form-group required">
							<label for="mailingCity" class="col-form-label col-form-label-sm">City or Town:</label>
							<input class="form-control form-control-sm" id="mailingCity" name="mailingCity" placeholder="Los Angeles" type="text" disabled="true">
						</div>
						<div class="col-4 form-group required">
							<label for="mailingState" class="col-form-label col-form-label-sm">State:</label>
							<select class="form-control form-control-sm" id="mailingState" name="mailingState" disabled="true">
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
							<label for="mailingZip" class="col-form-label col-form-label-sm">ZIP Code:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="mailingZip" name="mailingZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:mailingZip" disabled="true">
						</div>
					</div>
					<div class="col form-check required">
						<input class="form-check-input" type="checkbox" value="" id="enableMailing" name="enableMailing">
						<label  class="form-check-label" for="enableMailing">Check if mailing address is different from situs to enable input</label>
					</div>
				</div> <!-- end mailing col -->

				<!-- begin prior col -->
				<div class="form-col col-sm-4" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
														padding-top: 10px; padding-bottom: 15px;">
					<div>
						<h5>Prior Address (If applicable)</h5>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col form-group required">
							<label for="priorAPN" class="col-form-label col-form-label-sm">Prior APN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="priorAPN" name="priorAPN" placeholder="1234567890" type="number" min="0" data-bind="value:priorAPN">
						</div>
						<div class="col form-group required">
							<label for="dateMovedOut" class="col-form-label col-form-label-sm">Date Moved Out:</label>
							<input class="form-control form-control-sm" id="dateMovedOut" name="dateMovedOut" placeholder="1/23/2000" type="date">
						</div>
					</div>

					<div class="form-row situs-row-bottom-margin">
						<div class="col-8 form-group required">
							<label for="priorStName" class="col-form-label col-form-label-sm">Street Number and Name:</label>
							<input class="form-control form-control-sm" id="priorStName" name="priorStName" placeholder="123 Any Street" type="text">
						</div>
						<div class="col-4 form-group required">
							<label for="priorApt" class="col-form-label col-form-label-sm">Apt/Ste/Flr #:</label>
							<input class="form-control form-control-sm" id="priorApt" name="priorApt" placeholder="APT 101" type="text">
						</div>
					</div>
					<div class="form-row situs-row-bottom-margin">
						<div class="col-5 form-group required">
							<label for="priorCity" class="col-form-label col-form-label-sm">Prior City:</label>
							<input class="form-control form-control-sm" id="priorCity" name="priorCity" placeholder="Los Angeles" type="text">
						</div>
						<div class="col-4 form-group required">
							<label for="priorState" class="col-form-label col-form-label-sm">Prior State:</label>
							<select class="form-control form-control-sm" id="priorState" name="priorState">
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
							<label for="priorZip" class="col-form-label col-form-label-sm">Prior ZIP:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control form-control-sm" id="priorZip" name="priorZip" placeholder="90012" type="number" min="0" max="99999" data-bind="value:priorZip">
						</div>
					</div>
				</div> <!-- end prior row -->
			</div> <!-- end situs row -->
			<hr class="my-2">

			
			<!-- buttons -->
			<div class="form-group text-right p-3">
				<button type="submit" name="save" class="btn btn-danger">Submit</button>
				<button type="reset" class="btn btn-secondary">Reset</button>
			</div>

			</form> <!-- end form -->
		</div> <!-- end col -->
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
	document.getElementById("findingReason").onchange = function() {
		if ($("#findingReason").val() == "Other") {
			document.getElementById("otherReason").disabled = false;
		} else {
			$("#otherReason").val("");
			document.getElementById("otherReason").disabled = true;
		}
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
		var ainValue = document.getElementById("currentAPN").value;

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
					$('#currentZip').val(jsonResponse["situsZip"].substring(0, 5));

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
					$('#currentZip').val('');
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
				$('#currentZip').val('');
			}	
		}
		request.send();


		$('#searchAlert').show();
	};

	// post form with ajax, think this will help staying on same page
	$("#claim-form").on("submit", function() {

		var checkForm = document.getElementById("claim-form");
		var checkFD = new FormData(checkForm);
		var msg = "test";
		$.ajax({
			url: "check_dups.php",
			data: checkFD,
			cache: false,
			processData: false,
			contentType: false,
			type: 'POST',
			success: function (response) {
				let hold = false;
				if (response == "found") {
					if (confirm("Duplicate SSN found for claimant. Click 'OK' to continue submitting the claim or click 'cancel' to put it on hold.")) {
				        hold = false;
				    } else {
				        hold = true;
				    }
				}

				if (hold) {
					$('#chooseStatus').val('Hold');
				}

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
							$('#submitSuccess').html("<strong>Claim successfully created.</strong>");
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
			}
		});

		// $('#submitFail').html(msg);
		// $('#failAlert').show();

/*
		let confirmSubmit = true;
		if (msg > 0) {
			if (confirm("Click 'OK' to continue submitting the claim or click 'cancel' to put it on hold.")) {
		        // ok
		        confirmSubmit = true;
		    } else {
		        // cancel
		        confirmSubmit = false;
		    }
		}

		
*/
		// forgetting to return false will cause page to refresh 
		// and lose control on all prev objects...
		return false;
	});
	function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
  	var a, b, i, val = this.value;
  	/*close any already open lists of autocompleted values*/
  	closeAllLists();
  	if (!val) { return false;}
  	currentFocus = -1;
  	/*create a DIV element that will contain the items (values):*/
  	a = document.createElement("DIV");
  	a.setAttribute("id", this.id + "autocomplete-list");
  	a.setAttribute("class", "autocomplete-items");
  	/*append the DIV element as a child of the autocomplete container:*/
  	this.parentNode.appendChild(a);
  	/*for each item in the array...*/
  	for (i = 0; i < arr.length; i++) {
  		/*check if the item starts with the same letters as the text field value:*/
  		if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
  			/*create a DIV element for each matching element:*/
  			b = document.createElement("DIV");
  			/*make the matching letters bold:*/
  			b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
  			b.innerHTML += arr[i].substr(val.length);
  			/*insert a input field that will hold the current array item's value:*/
  			b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
  			/*execute a function when someone clicks on the item value (DIV element):*/
  			b.addEventListener("click", function(e) {
  				/*insert the value for the autocomplete text field:*/
  				inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
  			a.appendChild(b);
  		}
  	}
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
  	var x = document.getElementById(this.id + "autocomplete-list");
  	if (x) x = x.getElementsByTagName("div");
  	if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
    } else if (e.keyCode == 13) {
    	/*If the ENTER key is pressed, prevent the form from being submitted,*/
    	e.preventDefault();
    	if (currentFocus > -1) {
    		/*and simulate a click on the "active" item:*/
    		if (x) x[currentFocus].click();
    	}
    }
});
  function addActive(x) {
  	/*a function to classify an item as "active":*/
  	if (!x) return false;
  	/*start by removing the "active" class on all items:*/
  	removeActive(x);
  	if (currentFocus >= x.length) currentFocus = 0;
  	if (currentFocus < 0) currentFocus = (x.length - 1);
  	/*add class "autocomplete-active":*/
  	x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
  	/*a function to remove the "active" class from all autocomplete items:*/
  	for (var i = 0; i < x.length; i++) {
  		x[i].classList.remove("autocomplete-active");
  	}
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
    	if (elmnt != x[i] && elmnt != inp) {
    		x[i].parentNode.removeChild(x[i]);
    	}
    }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
	closeAllLists(e.target);
});
}
var users = <?php echo json_encode($phpArray); ?>;
autocomplete(document.getElementById("assignee"), users);
autocomplete(document.getElementById("assignor"), users);
</script>
</body>
</html>
