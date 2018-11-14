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

$tsql = "SELECT name FROM temp_table";

$phpArray = array();

$stmt = sqlsrv_query( $conn, $tsql);
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
{
	array_push($phpArray, $row[0]);
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

	$user = null;
	if (isset($_POST['users'])) {
		$user = $_POST['users'];
	}

	if(strcasecmp($option, "Claim Received")==0){
			$claim_query = "INSERT INTO dbo.claim_table
			(claimID, claimReceived, claimReceivedAssignee, claimReceivedAssignor, currStatus)
			VALUES(?,?,?,?,?)";
			foreach($claimID as $item) {
				$claim_params = array((int)$item, date("m.d.y"), $user, $_SESSION["name"], $option);
				/* Execute the query. */
				if($item!=""){
					$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);
				}              
			}
		$message = "processed";
	}
	else if(strcasecmp($option, "Supervisor Workload")==0){
			$date = date("m.d.y");
			$tsql = "UPDATE dbo.claim_table   
         	SET supervisorWorkload = (?), supervisorWorkloadAssignee = (?), supervisorWorkloadAssignor = (?), currStatus = (?) 
         	WHERE claimID = (?)";  

			foreach($claimID as $item) {
				$params = array($date, $user, $_SESSION["name"], $option, $item);
				/* Execute the query. */    
				if($item!=""){              
					$claim_result = sqlsrv_query($conn, $tsql, $params);
				}
			}
		$message = "processed";
	}
	else if(strcasecmp($option, "Staff Review")==0){
		$date = date("m.d.y");
		$tsql = "UPDATE dbo.claim_table   
     	SET staffReview = (?), staffReviewAssignee = (?), staffReviewAssignor = (?), currStatus = (?)
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $option, $item);
			/* Execute the query. */                  
			if($item!=""){              
				$claim_result = sqlsrv_query($conn, $tsql, $params);
			}
		}
		$message = "processed";
	}
	else if(strcasecmp($option, "Staff Review Date")==0){
		$date = date("m.d.y");
		$tsql = "UPDATE dbo.claim_table   
     	SET staffReviewDate = (?), staffReviewDateAssignee = (?), staffReviewDateAssignor = (?), currStatus = (?)
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $option, $item);
			/* Execute the query. */                  
			if($item!=""){              
				$claim_result = sqlsrv_query($conn, $tsql, $params);
			}
		}
		$message = "processed";
	}
	else if(strcasecmp($option, "Supervisor Review")==0){
		$date = date("m.d.y");
		$tsql = "UPDATE dbo.claim_table   
     	SET supervisorReview = (?), supervisorReviewAssignee = (?), supervisorReviewAssignor = (?), currStatus = (?)
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $option, $item);
			/* Execute the query. */                  
			if($item!=""){              
				$claim_result = sqlsrv_query($conn, $tsql, $params);
			}
		}
		$message = "processed";
	}
	else if(strcasecmp($option, "Hold")==0){
    $date = date("m.d.y");
    $tsql = "UPDATE dbo.claim_table   
      SET hold = (?), holdAssignee = (?), holdAssignor = (?), currStatus = (?)
      WHERE claimID = (?)";  

    foreach($claimID as $item) {
      $params = array($date, $user, $_SESSION["name"], $option, $item);
      /* Execute the query. */                  
      if($item!=""){              
        $claim_result = sqlsrv_query($conn, $tsql, $params);
      }
    }
    $message = "processed";
	}
  else if(strcasecmp($option, "Preprint Sent")==0){
    $date = date("m.d.y");
    $tsql = "UPDATE dbo.claim_table   
      SET preprintSent = (?), preprintSentAssignee = (?), preprintSentAssignor = (?), currStatus = (?)
      WHERE claimID = (?)";  

    foreach($claimID as $item) {
      $params = array($date, $user, $_SESSION["name"], $option, $item);
      /* Execute the query. */                  
      if($item!=""){              
        $claim_result = sqlsrv_query($conn, $tsql, $params);
      }
    }
    $message = "processed";
  }
	else if(strcasecmp($option, "Closed")==0){
		$date = date("m.d.y");
		$tsql = "UPDATE dbo.claim_table   
     	SET caseClosed = (?), caseClosedAssignee = (?), caseClosedAssignor = (?), currStatus = (?)
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $option, $item);
			/* Execute the query. */                  
			if($item!=""){
				//update the claim              
				$claim_result = sqlsrv_query($conn, $tsql, $params);

				//get the row corresponding to the claimID in the claim table
				$sql = "SELECT claimID, claimant, mailingStName, mailingApt, mailingCity, mailingState, mailingZip, claimAction, findingReason, rollTaxYear, exemptRE, suppTaxYear, exemptRE2 FROM dbo.claim_table WHERE";
				$sql= $sql." claimID = '$item'";
				$stmt = sqlsrv_query( $conn, $sql );
				while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
				{
					//and insert it into the harvest table since the claim is closed
					$claim_query = "INSERT INTO dbo.harvest_table
					(claimID, claimant, mailingStName, mailingApt, mailingCity, mailingState, mailingZip, claimAction, findingReason, rollTaxYear, exemptRE, suppTaxYear, exemptRE2)
					VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$claim_params = array($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12]);
					$claim_result_new = sqlsrv_query($conn,$claim_query,$claim_params);
				}
			}
		}

		$message = "processed";
	}

	sqlsrv_close($conn);
}    
?>
<!doctype html>
<html lang="en">
<head>
	<title>Scan Claim Page</title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
	<style>
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
</style>
</head>
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

<div class="container">
	<?php 
	if($message){
		echo '<div class="alert alert-success"><strong>Processed!</strong></div>';
		//echo $message;
	}
	?>
<form autocomplete="off" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
  <div class="form-row" style="">
  	<div class="form-group col-md-7" style="margin-top: 20px; padding-left: 24px; padding-right: 24px;
															padding-top: 24px; padding-bottom: 14px;">
  	 	<h1 style="width: 100%;">Scan Claims</h1>
    </div>
    <div class="form-group col-md-5" style="margin-top: 20px; padding-left: 24px; padding-right: 24px;
															padding-top: 24px; padding-bottom: 24px;">
  	 	<div id="add" class="btn btn-success">Add Input</div>
		<button type="submit" name="submit" class="btn btn-danger">Process</button>
		<div id="reset" class="btn btn-secondary">Reset</div>
    </div>
    <div class="form-group col-md-6" style="margin-top: 20px; padding-left: 24px; padding-right: 24px;
															padding-top: 24px; padding-bottom: 24px;">
	    <label for="users">Assign To:</label>
		<div class="autocomplete">
	    	<input class="form-control" id="myUsers" type="text" name="users" placeholder="Type in assignee">
		</div>
    </div>
    <div class="form-group col-md-6" style="margin-top: 20px; padding-left: 24px; padding-right: 24px;
															padding-top: 24px; padding-bottom: 24px;">
		<label for="option">Claim Status:</label>
		<select id="option" name="option" class="form-control">
		  <option disabled selected value>Choose Option</option>
      <option value="Preprint Sent">Preprint Sent</option>
		  <option value="Claim Received">Claim Received</option>
		  <option value="Supervisor Workload">Supervisor Workload</option>
		  <option value="Staff Review">Staff Assign</option>
		  <option value="Staff Review Date">Staff Review Date</option>
		  <option value="Supervisor Review">Supervisor Review</option>
		  <option value="Closed">Closed</option>
      <option value="Hold">Hold</option>
		</select>
    </div>
  </div>
  <hr class="my-2">
  <div class="form-row">
  	<div class="form-group col-md-4">
    </div>
    <div class="form-group col-md-4">
   	    <h2>Claim ID:</h2>
		<div id="items" style="">
			<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" style="display: block; width:100%; margin-top: 5px; border-radius:2px;"/>
		</div>
    </div>
    <div class="form-group col-md-4">
    </div>
  </div>
</form>
</div> <!-- end container -->
<!-- Custom JS -->
<script type="text/javascript">
//when the reset Field button is clicked
$("#reset").click(function () {
	//$("#claimID").val('');
	window.location.reload();
	console.log("reset");
});

$("#add").click(function () {
	console.log("clicked");
//Append a new row of code to the "#items" div
  $("#items").append('<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" style="display: block; width:100%; margin-top: 5px; border-radius:2px;"/>');
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
autocomplete(document.getElementById("myUsers"), users);
</script>
</body>
</html>
