<!-- <html>
<head>
<title>Login Form in PHP with Session</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head> -->
<!-- <body>
	<div class="header">
		<div>Homeowner Fraud</div>
	</div>
	<br>
	<div class="login">
		<form action="login.php" method="post" enctype="multipart/form-data">
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
</body>
</html> -->
<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Form in PHP with Session</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
<h1>Homeowners Fraud</h1>
<div id="login">
<h2>Login Form</h2>
<form action="home.php" method="post">
<label>UserName :</label>
<input id="username" name="username" placeholder="username" type="text">
<label>Password :</label>
<input id="password" name="password" placeholder="**********" type="password">
<input name="submit" type="submit" value=" Login ">
<span></span>
</form>
</div>
</div>
</body>
</html>
