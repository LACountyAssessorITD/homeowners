<?php
	session_start();
	$_SESSION["name"] = null;
?>
<!doctype html>
<html lang="en">
<head>
	<title>Employee Sign-In</title>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
</head>

<body class="jumbotron d-flex align-items-start">
	<div class="container rounded col-12 col-sm-auto" id="signin-container">
		<div class="row">
			<div class="col">
				<h1 class="text-center" id="signin-text">Employee Sign-In</h1>
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<!-- Please log in below for access -->
					<!-- Invalid login, please try again -->
					<?php
						if (isset($_GET['loginfail']) && $_GET['loginfail']=="true") {
							echo "Invalid login, please try again";
						} else {
							echo "Please log in below for access";
						}
					?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div> <!-- end row -->

		<div class="row">
			<div class="col" id="form-col">
				<div class="login">
					<form action="LDAP/login.php" method="post" enctype="multipart/form-data">
						<div class="formDiv">
							<input class="inputField" type="text" placeholder="Username" name="username"><br>
							<input class="inputField" type="password" placeholder="Password" name="password"><br>
						</div>
						<div class="loginDiv">
							<input type="submit" value="SignUp" name="login">
						</div>	
					</form>
					<div class="message"><?php //echo "Error: Incorrect Username / Password" ?></div>
				</div>
			</div>
		</div> <!-- end row -->
	</div> <!-- end container -->
</body>
</html>
