<?php
session_start();
include('constant.php');
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
<!DOCTYPE html>
<html>
<head>

<meta charset="ISO-8859-1">
<title>Claim History</title>
  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <style>
        .navbar-dark .navbar-nav .nav-link {
    color: rgba(255,255,255,.9);
  }
    </style>
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
	.navbar-dark .navbar-nav .nav-link {
		color: rgba(255,255,255,.9);
	}
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
</style>
<script>
    $( document ).ready(function() {
        rePlaceholder();
    });
</script>
</head>
<!-- <body onload="rePlaceholder()"> -->
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
    <div class="col" id="form-col">
      <!-- <form id="login-form"> -->
      <form id="login-form" action="update_claim.php" method="get">
        <div class="form-group p-1">
          <!-- personal info row -->
          <div>
          </div>
        <h5 style="display: inline-block">Status Dates</h5>
        <button type="button" id="historyButton" onclick="toggleHistory()" style="display: inline-block">Show History</button>
  <div id="history" style="display: none;">
  	<hr class="my-4">
     <div class="form-row">
     	<table style='width: 100%'>
     		<tr>
			<th>Status</td>
			<th>Date (Year-Month-Day)</td>
			<th>Days</div></td>
			<th>Assignor</div></td>
			<th>Assignee</div></td>
			</tr>
			<tr>
			<td>Preprint Sent</td>
			<td><div id="preprintSent"></div></td>
			<td><div id="preprintSentDays"></div></td>
			<td><div id="preprintSentAssignor"></div></td>
			<td><div id="preprintSentAssignee"></div></td>
			</tr>
			<tr>
			<td>Claim Receieved</td>
			<td><div id="claimReceived"></div></td>
			<td><div id="claimReceivedDays"></div></td>
			<td><div id="claimReceivedAssignor"></div></td>
			<td><div id="claimReceivedAssignee"></div></td>
			</tr>
			<tr>
			<td>Claim Receieved</td>
			<td><div id="supervisorWorkload"></div></td>
			<td><div id="supervisorWorkloadDays"></div></td>
			<td><div id="supervisorWorkloadAssignor"></div></td>
			<td><div id="supervisorWorkloadAssignee"></div></td>
			</tr>
			<tr>
			<td>Staff Assign</td>
			<td><div id="staffReview"></div></td>
			<td><div id="staffReviewDays"></div></td>
			<td><div id="staffReviewAssignor"></div></td>
			<td><div id="staffReviewAssignee"></div> </td>
			</tr>
			<tr>
			<td>Staff Review Date</td>
			<td><div id="staffReviewDate"></div></td>
			<td><div id="staffReviewDateDays"></div></td>
			<td><div id="staffReviewDateAssignor"></div></td>
			<td><div id="staffReviewDateAssignee"></div> </td>
			</tr>
			<tr>
			<td>Supervisor Review</td>
			<td><div id="supervisorReview"></div></td>
			<td><div id="supervisorReviewDays"></div></td>
			<td><div id="supervisorReviewAssignor"></div></td>
			<td><div id="supervisorReviewAssignee"></div></td>
			</tr>
			<tr>
			<td>Case Closed</td>
			<td><div id="caseClosed"></div></td>
			<td><div id="caseClosedDays"></div></td>
			<td><div id="caseClosedAssignor"></div></td>
			<td><div id="caseClosedAssignee"></div></td>
			</tr>
			<tr>
			<td>Hold</td>
			<td><div id="hold"></div></td>
			<td><div id="holdDays"></div></td>
			<td><div id="holdAssignor"></div></td>
			<td><div id="holdAssignee"></div></td>
			</tr>
		</table>
      </div>
<!--       
      <div class="form-row">
          <div class="col-2">
          	<p>Case Closed:  </p>
          </div>
          <div class="col-2">
          	<div id="caseClosed"></div>
          </div>
          <div class="col-2">
          	<div id="caseClosedDays"></div>
          </div>
          <div class="col-2">
          	<div id="caseClosedAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="caseClosedAssignee"></div> 
          </div>
      </div>
      <div class="form-row">
      </div> -->
  </div>
      <hr class="my-4">
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
										<input class="form-control form-control-sm" id="claimantSSN" name="claimantSSN" placeholder="123456789" type="text" data-bind="value:claimantSSN">
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
										<input class="form-control form-control-sm" id="spouseSSN" name="spouseSSN" placeholder="123456789" type="text" data-bind="value:spouseSSN">
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
											<option value="Staff Review">Staff Assign</option>
											<option value="Staff Review Date">Staff Review Date</option>
											<option value="Supervisor Review">Supervisor Review</option>
											<option value="Case Closed">Case Closed</option>
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
										<input class="form-control form-control-sm" id="assignor" name="assignor" placeholder="Last, First" type="text" value="" >
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
			</div>

			</form> <!-- end form -->
    </div>
  </div> <!-- end row -->
</div> <!-- end container -->





<script>
    function toggleHistory() {
	    var x = document.getElementById("history");
	    if (x.style.display === "none") {
	        x.style.display = "block";
	        document.getElementById("historyButton").innerText="Hide History";

	    } else {
	        x.style.display = "none";
	        document.getElementById("historyButton").innerText="Show History";
	    }
	}	
</script>

  <script>

    document.getElementById("findingReason").onchange = function() {
      if ($("#findingReason").val() == "Other") {
        document.getElementById("otherReason").disabled = false;
      } else {
        $("#otherReason").val("");
        document.getElementById("otherReason").disabled = true;
      }
    }

    function rePlaceholder(){
      var claimID = <?php echo $_GET['claimID']; ?>;
      var permissions = <?php echo $_SESSION['permissions']; ?>;
      var phpObj;
      $.ajax({
          type: "GET",
          url: "claimID_response.php",
          data:{ claimID: claimID }, 
          success: function(data){
              phpObj=JSON.parse(data);
              populate(phpObj,permissions);
              // console.log(phpObj); 
              // console.log(phpObj.claimID);
          }
      })
    }

      function populate(phpObj,permissions){
        console.log(phpObj);
        console.log(phpObj.claimID);
        // console.log(permissions);

        // permissions = 2;

        document.getElementById('claimID').value =phpObj.claimID;
        document.getElementById('claimant').value =phpObj.claimant;
        document.getElementById('spouse').value =phpObj.spouse;

        if(permissions == 2)	document.getElementById('claimantSSN').value = phpObj.claimantSSN;
        else 					document.getElementById('claimantSSN').style.display = "none";;//.value = claimantSSN;//claimantSSN = '*********';

        // document.getElementById('claimantSSN').value = claimantSSN;
        // document.getElementById('claimantSSN').value = phpObj.claimantSSN;


        if(permissions == 2)	document.getElementById('spouseSSN').value = phpObj.spouseSSN;
        else 					document.getElementById('spouseSSN').style.display = "none";;//spouseSSN = '*********';



        // document.getElementById('spouseSSN').value = spouseSSN;
        // document.getElementById('spouseSSN').value = phpObj.spouseSSN;
        document.getElementById('currentAPN').value =phpObj.currentAPN;
        document.getElementById('currentStName').value =phpObj.currentStName;
        document.getElementById('currentCity').value =phpObj.currentCity;
        document.getElementById('currentZip').value =phpObj.currentZip;
        document.getElementById('priorAPN').value =phpObj.priorAPN;
        document.getElementById('priorStName').value =phpObj.priorStName;
        document.getElementById('priorCity').value =phpObj.priorCity;
        document.getElementById('priorZip').value =phpObj.priorZip;
        document.getElementById('rollTaxYear').value =phpObj.rollTaxYear;
        document.getElementById('exemptRE').value =phpObj.exemptRE;
        document.getElementById('suppTaxYear').value =phpObj.suppTaxYear;
        document.getElementById('exemptRE2').value =phpObj.exemptRE2;
        document.getElementById('claimAction').value =phpObj.claimAction;


        let reasonFound = false;
        for (i = 0; i < document.getElementById('findingReason').length; ++i){
            if (document.getElementById('findingReason').options[i].value === phpObj.findingReason){
              reasonFound = true;
              break;
            }
        }
        if (reasonFound && phpObj.findingReason != "Other") {
          document.getElementById('findingReason').value = phpObj.findingReason;
        } else {
          document.getElementById('findingReason').value = "Other";
          document.getElementById("otherReason").disabled = false;
          document.getElementById('otherReason').value = phpObj.findingReason;
        }
        
        

        var claimReceivedDate ="";
        var claimReceivedDays ="";
        if(phpObj.claimReceived!=null){
          claimReceivedDate = phpObj.claimReceived.date.substring(0,10)
          claimReceivedDays = days_between(new Date(phpObj.claimReceived.date), new Date());
        }
        document.getElementById('claimReceived').innerHTML = claimReceivedDate;
        document.getElementById('claimReceivedDays').innerHTML = claimReceivedDays+" days";
        document.getElementById('claimReceivedAssignor').innerHTML = phpObj.claimReceivedAssignor;
        document.getElementById('claimReceivedAssignee').innerHTML = phpObj.claimReceivedAssignee;

        var supervisorWorkloadDate ="";
        var supervisorWorkloadDays ="";
        if(phpObj.supervisorWorkload!=null){
          supervisorWorkloadDate = phpObj.supervisorWorkload.date.substring(0,10)
          supervisorWorkloadDays = days_between(new Date(phpObj.supervisorWorkload.date), new Date());
        }
        document.getElementById('supervisorWorkload').innerHTML = supervisorWorkloadDate;
        document.getElementById('supervisorWorkloadDays').innerHTML = supervisorWorkloadDays+" days";
        document.getElementById('supervisorWorkloadAssignor').innerHTML = phpObj.supervisorWorkloadAssignor;
        document.getElementById('supervisorWorkloadAssignee').innerHTML = phpObj.supervisorWorkloadAssignee;

        var supervisorWorkloadDate ="";
        var supervisorWorkloadDays ="";
        if(phpObj.supervisorWorkload!=null){
          supervisorWorkloadDate = phpObj.supervisorWorkload.date.substring(0,10)
          supervisorWorkloadDays = days_between(new Date(phpObj.supervisorWorkload.date), new Date());
        }

        var assignmentDate ="";
        var assignmentDays ="";
        if(phpObj.staffReview!=null){
          assignmentDate = phpObj.staffReview.date.substring(0,10)
          assignmentDays = days_between(new Date(phpObj.staffReview.date), new Date());
        }
        document.getElementById('staffReview').innerHTML = assignmentDate;
        document.getElementById('staffReviewDays').innerHTML = assignmentDays+" days";
        document.getElementById('staffReviewAssignor').innerHTML = phpObj.staffReviewAssignor;
        document.getElementById('staffReviewAssignee').innerHTML = phpObj.staffReviewAssignee;

        var staffReviewDate ="";
        var staffReviewDays ="";
        if(phpObj.staffReviewDate!=null){
          staffReviewDate = phpObj.staffReviewDate.date.substring(0,10)
          staffReviewDays = days_between(new Date(phpObj.staffReviewDate.date), new Date());
        }
        document.getElementById('staffReviewDate').innerHTML = staffReviewDate;
        document.getElementById('staffReviewDateDays').innerHTML = staffReviewDays+" days";
        document.getElementById('staffReviewDateAssignor').innerHTML = phpObj.staffReviewDateAssignor;
        document.getElementById('staffReviewDateAssignee').innerHTML = phpObj.staffReviewDateAssignee;

        var supervisorReviewDate ="";
        var supervisorReviewDays ="";
        if(phpObj.supervisorReview!=null){
          supervisorReviewDate = phpObj.supervisorReview.date.substring(0,10)
          supervisorReviewDays = days_between(new Date(phpObj.supervisorReview.date), new Date());
        }
        document.getElementById('supervisorReview').innerHTML = supervisorReviewDate;
        document.getElementById('supervisorReviewDays').innerHTML = supervisorReviewDays+" days";
        document.getElementById('supervisorReviewAssignor').innerHTML = phpObj.supervisorReviewAssignor;
        document.getElementById('supervisorReviewAssignee').innerHTML = phpObj.supervisorReviewAssignee;

        var caseClosedDate ="";
        var caseClosedDays ="";
        if(phpObj.supervisorReview!=null){
          caseClosedDate = phpObj.caseClosed.date.substring(0,10)
          caseClosedDays = days_between(new Date(phpObj.caseClosed.date), new Date());
        }
        document.getElementById('caseClosed').innerHTML = caseClosedDate;
        document.getElementById('caseClosedDays').innerHTML = caseClosedDays+" days";
        document.getElementById('caseClosedAssignor').innerHTML = phpObj.caseClosedAssignor;
        document.getElementById('caseClosedAssignee').innerHTML = phpObj.caseClosedAssignee;

        var preprintSentDate ="";
        var preprintSentDays ="";
        if(phpObj.preprintSent!=null){
          preprintSentDate = phpObj.preprintSent.date.substring(0,10)
          preprintSentDays = days_between(new Date(phpObj.preprintSent.date), new Date());
        }
        document.getElementById('preprintSent').innerHTML = preprintSentDate;
        document.getElementById('preprintSentDays').innerHTML = preprintSentDays+" days";
        document.getElementById('preprintSentAssignor').innerHTML = phpObj.preprintSentAssignor;
        document.getElementById('preprintSentAssignee').innerHTML = phpObj.preprintSentAssignee;

        var holdDate ="";
        var holdDays ="";
        if(phpObj.hold!=null){
          holdDate = phpObj.hold.date.substring(0,10)
          holdDays = days_between(new Date(phpObj.hold.date), new Date());
        }
        document.getElementById('hold').innerHTML = holdDate;
        document.getElementById('holdDays').innerHTML = holdDays+" days";
        document.getElementById('holdAssignor').innerHTML = phpObj.holdAssignor;
        document.getElementById('holdAssignee').innerHTML = phpObj.holdAssignee;
      }

      function days_between(date1, date2) {

	    // The number of milliseconds in one day
	    var ONE_DAY = 1000 * 60 * 60 * 24;

	    // Convert both dates to milliseconds
	    var date1_ms = date1.getTime();
	    var date2_ms = date2.getTime();

	    // Calculate the difference in milliseconds
	    var difference_ms = Math.abs(date1_ms - date2_ms);

	    // Convert back to days and return
	    return Math.round(difference_ms/ONE_DAY);

	}
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
