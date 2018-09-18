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

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="styles/home-style.css">

	<!-- Custom JS -->
	<!--script type="text/javascript" src="scripts/script.js"></script-->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script>
      $(function () {
        $('form').on('submit', function (e) {
            //TODO: There should be some error checking to make sure no important fields are empty
          	e.preventDefault();

          	var homeownerFirstname = document.getElementById("homeownerFirstname").value;
          	var homeownerLastname = document.getElementById("homeownerLastname").value;
          	var homeownerSSN = document.getElementById("homeownerSSN").value;
          	var spouseFirstname = document.getElementById("spouseFirstname").value;
          	var spouseLastname = document.getElementById("spouseLastname").value;
          	var spouseSSN = document.getElementById("spouseSSN").value;
          	var propertyAIN = document.getElementById("propertyAIN").value;
          	var propertyVacated = document.getElementById("propertyVacated").value;
          	var propertyAquired = document.getElementById("propertyAquired").value;
          	var propertyOccupied = document.getElementById("propertyOccupied").value;
          	var propertyAddress = document.getElementById("propertyAddress").value;
          	var propertyApartment = document.getElementById("propertyApartment").value;
          	var propertyCity = document.getElementById("propertyCity").value;
          	var propertyState = document.getElementById("propertyState").value;
          	var propertyZIP = document.getElementById("propertyZIP").value;
          	var claimNumber = document.getElementById("claimNumber").value;
          	var taxYear = document.getElementById("taxYear").value;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("infoLookup").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "InfoLookup.php?homeownerFirstname="+homeownerFirstname
                    + "&homeownerLastname=" + homeownerLastname
                    + "&homeownerSSN=" + homeownerSSN
                    + "&spouseFirstname=" + spouseFirstname
                    + "&spouseLastname=" + spouseLastname
                    + "&spouseSSN=" + spouseSSN
                    + "&propertyAIN=" + propertyAIN
                    + "&propertyVacated=" + propertyVacated
                    + "&propertyAquired=" + propertyAquired
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
<ul>
  <li><a href="home.php">Home</a></li>
  <li><a href="claim.php">Claim</a></li>
  <li><a href="HomeownerInformation.php">Advanced Search</a></li>
  <li><a href="indexv2.php">Logout</a></li>
</ul>
	<div class="container rounded col-12" id="signin-container">
		<div class="row">
			<div class="col" id="form-col">
				<form id="login-form" action="script">	<!--action="home.php" method="post">-->
					<br>
					<h1>Advanced Search</h1>
					<div class="form-row">
						<div class="col form-group required">
							<label for="homeownerFirstname">Homeowner First Name:</label>
							<input class="form-control" id="homeownerFirstname" name="homeownerFirstname" placeholder="First Name" type="text">
						</div>
						<div class="col form-group required">
							<label for="homeownerLastname" class="control-label">Homeowner Last Name:</label>
							<input class="form-control" id="homeownerLastname" name="homeownerLastname" placeholder="Last Name" type="text">
						</div>
						<div class="col form-group required">
							<label for="homeownerSSN" class="control-label">SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="homeownerSSN" name="homeownerSSN" placeholder="123456789" type="number" min="0" data-bind="value:homeownerSSN">
						</div>
					</div>

					<h6>Spouse/Partner Information (If applicable)</h5>
					<div class="form-row">
						<div class="col form-group">
							<label for="spouseFirstname">Spouse First Name:</label>
							<input class="form-control" id="spouseFirstname" name="spouseFirstname" placeholder="First Name" type="text">
						</div>
						<div class="col form-group">
							<label for="spouseLastname" class="control-label">Spouse Last Name:</label>
							<input class="form-control" id="spouseLastname" name="spouseLastname" placeholder="Last Name" type="text">
						</div>
						<div class="col form-group">
							<label for="spouseSSN" class="control-label">SSN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="spouseSSN" name="spouseSSN" placeholder="123456789" type="number" min="0" data-bind="value:spouseSSN">
						</div>
					</div>

					<!--  -->

					<hr class="my-4">

					<h5>Property Information</h5>
					<div class="form-row">
						<div class="col form-group required">
							<label for="propertyAIN">Current AIN:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="propertyAIN" name="propertyAIN" placeholder="1234567890" type="number" min="0" max="9999999999" data-bind="value:propertyAIN">
						</div>
						<div class="col form-group required">
							<label for="propertyVacated">Date Vacated:</label>
							<input class="form-control" id="propertyVacated" name="propertyVacated" placeholder="1/23/2000" type="date">
						</div>
						<div class="col form-group required">
							<label for="propertyAquired">Date Aquired:</label>
							<input class="form-control" id="propertyAquired" name="propertyAquired" placeholder="1/23/2000" type="date">
						</div>
						<div class="col form-group required">
							<label for="propertyOccupied">Date Occupied:</label>
							<input class="form-control" id="propertyOccupied" name="propertyOccupied" placeholder="1/23/2000" type="date">
						</div>
					</div>

					<div class="form-row">
						<div class="col-8 form-group required">
							<label for="propertyAddress">Street Address:</label>
							<input class="form-control" id="propertyAddress" name="propertyAddress" placeholder="245 Anystreet Rd." type="text">
						</div>
						<div class="col form-group">
							<label for="propertyApartment">Apartment:</label>
							<input class="form-control" id="propertyApartment" name="propertyApartment" type="text">
						</div>
					</div>

					<div class="form-row">
						<div class="col form-group required">
							<label for="propertyCity">City:</label>
							<input class="form-control" id="propertyCity" name="propertyCity" type="text">
						</div>
						<div class="col form-group required">
							<label for="propertyState">State:</label>
							<input class="form-control" id="propertyState" name="propertyState" type="text">
						</div>
						<div class="col-2 form-group required">
							<label for="propertyZIP">ZIP:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="propertyZIP" name="propertyZIP" type="number" min="0" max="99999" data-bind="value:propertyZIP">
						</div>

					</div>

					<!--  -->

  					<hr class="my-4">
  					<h5>Claim Information</h5>

					<div class="form-row">
						<div class="col form-group required">
							<label for="claimNumber">Claim Number:</label>
							<!-- TODO: onchange valid number check and formatting -->
							<input class="form-control" id="claimNumber" name="claimNumber" placeholder="1234567890" type="number" min="0" max="9999999999" data-bind="claimNumber">
						</div>
						<div class="col form-group required">
							<label for="taxYear">Tax Year:</label>
							<input class="form-control" id="taxYear" name="taxYear" placeholder="1/23/2000" type="date">
						</div>
					</div>
					<div class="form-group text-left p-3">
						<button type="search" class="btn btn-danger">Search</button>
					</div>
					<!--  -->
				</form> <!-- end form -->
				<div id="infoLookup"></div>
			</div>
		</div> <!-- end row -->
	</div> <!-- end container -->

</body>
</html>
