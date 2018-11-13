<!DOCTYPE html>
<html>
<head>

<meta charset="ISO-8859-1">
<title>Claim History</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="styles/home-style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script>
    $( document ).ready(function() {
        rePlaceholder();
    });
</script>
</head>
<!-- <body onload="rePlaceholder()"> -->
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
    <h1 class="col" style="padding-bottom: 20px;">Claim</h1>
  </div>
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
          <div class="col-2">
          	<p>Claim Receieved:  </p>
          </div>
          <div class="col-2">
          	<div id="claimReceived"></div>
          </div>
          <div class="col-2">
          	<div id="claimReceivedDays"></div>
          </div>
          <div class="col-2">
          	<div id="claimReceivedAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="claimReceivedAssignee"></div> 
          </div>
      </div>
      <div class="form-row">
          <div class="col-2">
          	<p>Supervisor Workload:  </p>
          </div>
          <div class="col-2">
          	<div id="supervisorWorkload"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorWorkloadDays"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorWorkloadAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorWorkloadAssignee"></div> 
          </div>
      </div>
      <div class="form-row">
          <div class="col-2">
          	<p>Staff Assign:  </p>
          </div>
          <div class="col-2">
          	<div id="staffReview"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewDays"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewAssignee"></div> 
          </div>
      </div>
      <div class="form-row">
          <div class="col-2">
          	<p>Staff Review Date:  </p>
          </div>
          <div class="col-2">
          	<div id="staffReviewDate"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewDateDays"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewDateAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="staffReviewDateAssignee"></div> 
          </div>
      </div>
      <div class="form-row">
          <div class="col-2">
          	<p>Supervisor Review:  </p>
          </div>
          <div class="col-2">
          	<div id="supervisorReview"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorReviewDays"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorReviewAssignor"></div>
          </div>
          <div class="col-2">
          	<div id="supervisorReviewAssignee"></div> 
          </div>
      </div>
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
      </div>
  </div>
      <hr class="my-4">
      <h5>Personal Information</h5>
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
              <option value="N/A">N/A</option>
              <option value="Already Claimed Exemption">Already Claimed Exemption</option>
              <option value="Missing SSN">Missing SSN</option>
              <option value="Missing Signature">Missing Signature</option>
              <option value="Incomplete Address">Incomplete Address</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="col form-group required">
            <label for="otherReason">Other Reason (If applicable):</label>
            <input class="form-control" id="otherReason" name="otherReason" placeholder="Specify other reason" type="text" disabled="true">
          </div>
        </div>

        <!-- buttons -->
        <div class="form-group text-right p-3">
          <button type="submit" class="btn btn-danger">Submit</button>
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
      var phpObj;
      $.ajax({
          type: "GET",
          url: "claimID_response.php",
          data:{ claimID: claimID }, 
          success: function(data){
              phpObj=JSON.parse(data);
              populate(phpObj);
              // console.log(phpObj); 
              // console.log(phpObj.claimID);
          }
      })
    }

      function populate(phpObj){
        console.log(phpObj);
        console.log(phpObj.claimID);

        document.getElementById('claimID').value =phpObj.claimID;
        document.getElementById('claimant').value =phpObj.claimant;
        document.getElementById('claimantSSN').value =phpObj.claimantSSN;
        document.getElementById('spouse').value =phpObj.spouse;
        document.getElementById('spouseSSN').value =phpObj.spouseSSN;
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
        document.getElementById('claimReceived').innerHTML = "Date: "+claimReceivedDate;
        document.getElementById('claimReceivedDays').innerHTML = "Days: "+claimReceivedDays;
        document.getElementById('claimReceivedAssignor').innerHTML = "Assignor: "+phpObj.claimReceivedAssignor;
        document.getElementById('claimReceivedAssignee').innerHTML = "Assignee: "+phpObj.claimReceivedAssignee;

        var supervisorWorkloadDate ="";
        var supervisorWorkloadDays ="";
        if(phpObj.supervisorWorkload!=null){
          supervisorWorkloadDate = phpObj.supervisorWorkload.date.substring(0,10)
          supervisorWorkloadDays = days_between(new Date(phpObj.supervisorWorkload.date), new Date());
        }
        document.getElementById('supervisorWorkload').innerHTML = "Date: "+supervisorWorkloadDate;
        document.getElementById('supervisorWorkloadDays').innerHTML = "Days: "+supervisorWorkloadDays;
        document.getElementById('supervisorWorkloadAssignor').innerHTML = "Assignor: "+phpObj.supervisorWorkloadAssignor;
        document.getElementById('supervisorWorkloadAssignee').innerHTML = "Assignee: "+phpObj.supervisorWorkloadAssignee;

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
        document.getElementById('staffReview').innerHTML = "Date: "+assignmentDate;
        document.getElementById('staffReviewDays').innerHTML = "Days: "+assignmentDays;
        document.getElementById('staffReviewAssignor').innerHTML = "Assignor: "+phpObj.staffReviewAssignor;
        document.getElementById('staffReviewAssignee').innerHTML = "Assignee: "+phpObj.staffReviewAssignee;

        var staffReviewDate ="";
        var staffReviewDays ="";
        if(phpObj.staffReviewDate!=null){
          staffReviewDate = phpObj.staffReviewDate.date.substring(0,10)
          staffReviewDays = days_between(new Date(phpObj.staffReviewDate.date), new Date());
        }
        document.getElementById('staffReviewDate').innerHTML = "Date: "+staffReviewDate;
        document.getElementById('staffReviewDateDays').innerHTML = "Days: "+staffReviewDays;
        document.getElementById('staffReviewDateAssignor').innerHTML = "Assignor: "+phpObj.staffReviewDateAssignor;
        document.getElementById('staffReviewDateAssignee').innerHTML = "Assignee: "+phpObj.staffReviewDateAssignee;

        var supervisorReviewDate ="";
        var supervisorReviewDays ="";
        if(phpObj.supervisorReview!=null){
          supervisorReviewDate = phpObj.supervisorReview.date.substring(0,10)
          supervisorReviewDays = days_between(new Date(phpObj.supervisorReview.date), new Date());
        }
        document.getElementById('supervisorReview').innerHTML = "Date: "+supervisorReviewDate;
        document.getElementById('supervisorReviewDays').innerHTML = "Days: "+supervisorReviewDays;
        document.getElementById('supervisorReviewAssignor').innerHTML = "Assignor: "+phpObj.supervisorReviewAssignor;
        document.getElementById('supervisorReviewAssignee').innerHTML = "Assignee: "+phpObj.supervisorReviewAssignee;

        var caseClosedDate ="";
        var caseClosedDays ="";
        if(phpObj.supervisorReview!=null){
          caseClosedDate = phpObj.caseClosed.date.substring(0,10)
          caseClosedDays = days_between(new Date(phpObj.caseClosed.date), new Date());
        }
        document.getElementById('caseClosed').innerHTML = "Date: "+caseClosedDate;
        document.getElementById('caseClosedDays').innerHTML = "Days: "+caseClosedDays;
        document.getElementById('caseClosedAssignor').innerHTML = "Assignor: "+phpObj.caseClosedAssignor;
        document.getElementById('caseClosedAssignee').innerHTML = "Assignee: "+phpObj.caseClosedAssignee;
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
  </script>

</body>
</html>
