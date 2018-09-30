<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="styles/home-style.css">
</head>
<body>
  <ul>
  <li><a href="home_page.php">Home</a></li>
  <li><a href="create_claim_page.php">Claim</a></li>
  <li><a href="advanced_search_page.php">Advanced Search</a></li>
  <li><a href="index.php">Logout</a></li>
</ul>


<hr>
<h1> Property History </h1>
<?php
	$AIN = $_GET['AIN'];
	            $serverName = "Assessor";
            $uid = "zhdllwyc";
            $pwd = 'A$$essortrain123';
            $databaseName = "homeowner_test";

            $connectionInfo = array( "UID"=>$uid,
                "PWD"=>$pwd,
                "Database"=>$databaseName);

            /* Connect using SQL Server Authentication. */
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

            $tsql = "SELECT AIN, Street_Number, Street_Name, City, State, Zip, Suffix, Suite, Direction FROM temp_property_table WHERE AIN=".$AIN;

            /* Execute the query. */

            $stmt = sqlsrv_query( $conn, $tsql);

            if ( $stmt )
            {
            	while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
	            {
	                echo "".$row[1]."\n";
	                echo " ".$row[2]."\n".$row[6];
	                echo ",".$row[3]."\n";
	                echo ",".$row[4]."\n";
	                echo ",".$row[5]."<br><br><hr>";
	                echo "AIN: ".$row[0]."<br>";
	                echo "Street_Number: ".$row[1]."<br>";
	                echo "Street_Name: ".$row[2]."<br>";
	                echo "City: ".$row[3]."<br>";
	                echo "State: ".$row[4]."<br>";
	                echo "Zip: ".$row[5]."<br>";
	                echo "Suffix: ".$row[6]."<br>";
	            }
            }
            else
            {
                echo "Error in statement execution.\n";
                die( print_r( sqlsrv_errors(), true));
            }
?>

<hr>

</body>
</html>
