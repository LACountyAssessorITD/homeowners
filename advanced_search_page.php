 <?php
	session_start();
?>
 <!DOCTYPE html>
<html>
<head>
	<title>Homeowner Information</title>

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
    <script>
      $(function () {
        $("#advanced-search").on('submit', function (e) {
            //TODO: There should be some error checking to make sure no important fields are empty
          	e.preventDefault();


          	var homeownerFirstname = document.getElementById("homeownerFirstname").value;
          	// var homeownerLastname = document.getElementById("homeownerLastname").value;
          	var homeownerSSN = document.getElementById("homeownerSSN").value;
          	var spouseFirstname = document.getElementById("spouseFirstname").value;
          	// var spouseLastname = document.getElementById("spouseLastname").value;
          	var spouseSSN = document.getElementById("spouseSSN").value;
          	var propertyAIN = document.getElementById("propertyAIN").value;
          	var propertyVacated = document.getElementById("propertyVacated").value;
          	var propertyAcquired = document.getElementById("propertyAcquired").value;
          	var propertyOccupied = document.getElementById("propertyOccupied").value;
          	var propertyAddress = document.getElementById("propertyAddress").value;
          	var propertyApartment = document.getElementById("propertyApartment").value;
          	var propertyCity = document.getElementById("propertyCity").value;
          	var propertyState = document.getElementById("propertyState").value;
          	var propertyZIP = document.getElementById("propertyZIP").value;
          	var claimNumber = document.getElementById("claimNumber").value;
          	var taxYear = document.getElementById("taxYear").value;

          	console.log("Property state: " + propertyState);
          	console.log("Date Acquire: " + propertyAcquired);
          	console.log("Date Occupied:x" + propertyOccupied);




            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "search.php?homeownerFirstname="+homeownerFirstname
                    // + "&homeownerLastname=" + homeownerLastname
                    + "&homeownerSSN=" + homeownerSSN
                    + "&spouseFirstname=" + spouseFirstname
                    // + "&spouseLastname=" + spouseLastname
                    + "&spouseSSN=" + spouseSSN
                    + "&propertyAIN=" + propertyAIN
                    + "&propertyVacated=" + propertyVacated
                    + "&propertyAcquired=" + propertyAcquired
                    + "&propertyOccupied=" + propertyOccupied
                    + "&propertyAddress=" + propertyAddress
                    + "&propertyApartment=" + propertyApartment
                    + "&propertyCity=" + propertyCity
                    + "&propertyState=" + propertyState
                    + "&propertyZIP=" + propertyZIP
                    + "&claimNumber=" + claimNumber
                    + "&taxYear=" + taxYear,
                    true);
            xmlhttp.send();
        });
      });
    </script>

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
				<a class="nav-link" href="create_claim_page.php">Claim</a>
			</li>
			<li class="nav-item">
				<a id="active-page" class="nav-link" href="advanced_search_page.php">Advanced Search</a>
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
	<div class="container rounded col-12" id="signin-container">
		<div class="row">
			<div class="col" id="form-col">
				<form id="advanced-search" action="script">
					<br>

						<div class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 0px;">
							<h3>Advanced Search</h3>
						</div>
					<div class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px; padding-top: 0px; padding-bottom: 5px;">
						<div class="col form-group required">
							<label for="homeownerFirstname" class="col-form-label col-form-label-sm">Homeowner Name:</label>
							<input class="form-control" id="homeownerFirstname" name="homeownerFirstname" placeholder="Last, First Middle" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="homeownerSSN" class="col-form-label col-form-label-sm">SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="homeownerSSN" name="homeownerSSN" placeholder="" type="number" min="0" data-bind="value:homeownerSSN">
						</div>
						<div class="col form-group" >
							<label for="spouseFirstname" class="col-form-label col-form-label-sm">Spouse Name (If applicable):</label>
							<input class="form-control" id="spouseFirstname" name="spouseFirstname" placeholder="Last, First Middle" type="text">
						</div>
						<div class="col-2 form-group">
							<label for="spouseSSN" class="col-form-label col-form-label-sm">Spouse SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="spouseSSN" name="spouseSSN" placeholder="" type="number" min="0" data-bind="value:spouseSSN">
						</div>
					</div>

					<div class="form-row">

					</div>


					<div class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 0px;">
					</div>
					<div class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 0px; padding-bottom: 5px;">
						<div class="col form-group required">
							<label for="propertyAIN" class="col-form-label col-form-label-sm">Current AIN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="propertyAIN" name="propertyAIN" placeholder="" type="number" min="0" max="9999999999" data-bind="value:propertyAIN">
						</div>
						<div class="col form-group required">
							<label for="propertyVacated" class="col-form-label col-form-label-sm">Date Vacated:</label>
							<input class="form-control" id="propertyVacated" name="propertyVacated" placeholder="" type="date">
						</div>
						<div class="col form-group required">
							<label for="propertyAcquired" class="col-form-label col-form-label-sm">Date Acquired:</label>
							<input class="form-control" id="propertyAcquired" name="propertyAcquired" placeholder="" type="date">
						</div>
						<div class="col form-group required">
							<label for="propertyOccupied" class="col-form-label col-form-label-sm">Date Occupied:</label>
							<input class="form-control" id="propertyOccupied" name="propertyOccupied" placeholder="" type="date">
						</div>
					</div>

					<div class="form-row" class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 0px; padding-bottom: 5px;">
						<div class="col-4 form-group required">
							<label for="propertyAddress" class="col-form-label col-form-label-sm">Street Address:</label>
							<input class="form-control" id="propertyAddress" name="propertyAddress" placeholder="" type="text">
						</div>
						<div class="col form-group">
							<label for="propertyApartment" class="col-form-label col-form-label-sm">Apartment:</label>
							<input class="form-control" id="propertyApartment" name="propertyApartment" type="text">
						</div>
						<div class="col form-group required">
							<label for="propertyCity" class="col-form-label col-form-label-sm">City:</label>
							<input class="form-control" id="propertyCity" name="propertyCity" type="text">
						</div>
						<div class="col form-group required">
							<label for="propertyState" class="col-form-label col-form-label-sm">State:</label>
							<input class="form-control" id="propertyState" name="propertyState" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="propertyZIP" class="col-form-label col-form-label-sm">ZIP:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="propertyZIP" name="propertyZIP" type="number" min="0" max="99999" data-bind="value:propertyZIP">
						</div>
					</div>

  					<div class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 10px; padding-bottom: 0px;">
  					</div>

					<div class="form-row" class="form-row" style="background-color: #D6EAF8; padding-left: 24px; padding-right: 24px;
															padding-top: 0px; padding-bottom: 5px;">
						<div class="col form-group required">
							<label for="claimNumber" class="col-form-label col-form-label-sm">Claim Number:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="claimNumber" name="claimNumber" placeholder="" type="number" min="0" max="9999999999" data-bind="claimNumber">
						</div>
						<div class="col form-group required">
							<label for="taxYear" class="col-form-label col-form-label-sm">Tax Year:</label>
							<input class="form-control" id="taxYear" name="taxYear" placeholder="" type="date">
						</div>
					</div>
					<div class="form-group text-left p-3">
						<button type="search" class="btn btn-danger">Search</button>
					</div>
					<!--  -->
				</form> <!-- end form -->
				<div id="search" class="container rounded"></div>
			</div>
		</div> <!-- end row -->
	</div> <!-- end container -->

</body>
</html>
