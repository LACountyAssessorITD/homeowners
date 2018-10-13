<?php
session_start(); 
$message=null;
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
			(claimID, claimReceived, claimReceivedAssignee, claimReceivedAssignor)
			VALUES(?,?,?,?)";
			foreach($claimID as $item) {
				$claim_params = array((int)$item, date("m.d.y"), $user, $_SESSION["name"]);
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
         	SET supervisorWorkload = (?), supervisorWorkloadAssignee = (?), supervisorWorkloadAssignor = (?) 
         	WHERE claimID = (?)";  

			foreach($claimID as $item) {
				$params = array($date, $user, $_SESSION["name"], $item);
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
     	SET staffReview = (?), staffReviewAssignee = (?), staffReviewAssignor = (?)  
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $item);
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
     	SET staffReviewDate = (?), staffReviewDateAssignee = (?), staffReviewDateAssignor = (?)  
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $item);
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
     	SET supervisorReview = (?), supervisorReviewAssignee = (?), supervisorReviewAssignor = (?)   
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $item);
			/* Execute the query. */                  
			if($item!=""){              
				$claim_result = sqlsrv_query($conn, $tsql, $params);
			}
		}
		$message = "processed";
	}
	else if(strcasecmp($option, "Hold")==0){
	}
	else if(strcasecmp($option, "Closed")==0){
		$date = date("m.d.y");
		$tsql = "UPDATE dbo.claim_table   
     	SET caseClosed = (?), caseClosedAssignee = (?), caseClosedAssignor = (?)   
     	WHERE claimID = (?)";  

		foreach($claimID as $item) {
			$params = array($date, $user, $_SESSION["name"], $item);
			/* Execute the query. */                  
			if($item!=""){              
				$claim_result = sqlsrv_query($conn, $tsql, $params);
			}
		}

		$sql = "SELECT claimID, mailingStName, mailingApt, mailingCity, mailingState, mailingZip, claimAction, findingReason, rollTaxYear, exemptRE, suppTaxYear, exemptRE2 FROM dbo.claim_table WHERE";
		$sql= $sql." claimID = '$item'";

		$claim_query = "INSERT INTO dbo.harvest_table
			(claimID, mailingStName, mailingApt, mailingCity, mailingState, mailingZip, claimAction, findingReason, rollTaxYear, exemptRE, suppTaxYear, exemptRE2)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
			foreach($claimID as $item) {
				$claim_params = array((int)$item, date("m.d.y"), $user, $_SESSION["name"]);
				/* Execute the query. */
				if($item!=""){
					$claim_result = sqlsrv_query($conn,$claim_query,$claim_params);
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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="styles/home-style.css">
	<style>
	* { box-sizing: border-box; }
body {
  font: 16px Arial; 
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input {
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
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
	</style>
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
		//echo $message;
	}
	?>
	<div class="row">
		<h1 class="col" style="padding-bottom: 20px;">Scan Claims</h1>
	</div>
	<div class="row">
		<div class="col" id="form-col">
			<form id="login-form" autocomplete="off" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
				<div class="col-2 form-group required">
					<br>
					<span>Assign To:</span>
					<div class="autocomplete" style="width:300px;">
				    <input id="myUsers" type="text" name="users" placeholder="-- type in a user to assign to -- ">
				  </div>
				</div>
				<span>Claim Status:</span>
				<select id="option" name="option">
				  <option disabled selected value> -- select an option -- </option>
				  <option value="Claim Received">Claim Received</option>
				  <option value="Supervisor Workload">Supervisor Workload</option>
				  <option value="Staff Review">Staff Review</option>
				  <option value="Staff Review Date">Staff Review Date</option>
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
							<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" style="display: block;"/>
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
	window.location.reload();
	console.log("reset");
});

$("#add").click(function () {
	console.log("clicked");
//Append a new row of code to the "#items" div
  $("#items").append('<input class="inputs" name="claimID[]" type="text" maxlength="7" class="inputs" style="display: block;"/>');
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
