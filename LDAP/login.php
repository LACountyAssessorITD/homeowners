<?php
include_once "authenticate.php";
include_once "constants.php";
session_start();

	$ldapusername = "laassessor"."\\".$_POST["username"];
	$_SESSION['USERNAME']=$_POST["username"];
	$ldappassword = $_POST["password"];
	$_SESSION['password']=$_POST["password"];

	if (!authenticateUser($ldapusername, $ldappassword)) {
		//echo "<p>Authenticate Failed</p>";
		$_SESSION["logged_in"] = FALSE;
		$url = "../index.php?loginfail=true";
		header("Location:" . $url);
		exit();
	} else {
		// if authencate successfully, get relative info
		$user_name=$_POST["username"];
		$serverName = SERVERNAME;
		$uid = UID;
		$pwd = PWD;
		$databaseName = DATABASENAME;

		$connectionInfo = array( "UID"=>$uid,
		    "PWD"=>$pwd,
		    "Database"=>$databaseName);

		/* Connect using SQL Server Authentication. */
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		$tsql = "SELECT id, username, name, permissions FROM temp_table";

		/* Execute the query. */

		$stmt = sqlsrv_query( $conn, $tsql);

		if ( $stmt )
		{
		}
		else
		{
		    echo "Error in statement execution.\n";
		    die( print_r( sqlsrv_errors(), true));
		}

		/* Iterate through the result set printing a row of data upon each iteration.*/
		//$loggedIn='false';
		if($_SESSION["name"]==null){
		    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
		    {
		        if(strcmp($_POST["username"], $row[1])==0){
		            $_SESSION["name"] = $row[2];
                	$_SESSION["permissions"] = $row[3];
		        }
		    }
		}

		// if login invalid, redirect back to login page
		//  so login page displays errer message
		//commented this out cause im testing single sign on

		if ($_SESSION["name"]==null) {
		    $url = "../index.php?loginfail=true";
		    header("Location:" . $url);
		    //echo "<p>Didn't Find Matching username</p>";
		    exit();
		}
		else{
			$url = "../home_page.php";
			//echo "<p>Everything Worked</p>";
		    header("Location:" . $url);
		    exit();
		}
		/* Free statement and connection resources. */
		sqlsrv_free_stmt( $stmt);
		sqlsrv_close( $conn);
		echo "<h1> You are logged in as ".$_SESSION["name"];
	}
?>
