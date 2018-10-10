<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Homeowner Fraud</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/home-style.css">
</head>
<body>
<ul>
  <li><a href="home_page.php">Home</a></li>
  <li><a href="scan_claims_page.php">Scan Claims</a></li>
  <li><a href="create_claim_page.php">Claim</a></li>
  <li><a href="advanced_search_page.php">Advanced Search</a></li>
  <li><a href="index.php">Logout</a></li>
</ul>
            <?php
            $serverName = "Assessor";
            $uid = "zhdllwyc";
            $pwd = 'A$$essortrain123';
            $databaseName = "homeowner_test";

            $connectionInfo = array( "UID"=>$uid,
                "PWD"=>$pwd,
                "Database"=>$databaseName);

            /* Connect using SQL Server Authentication. */
            $conn = sqlsrv_connect( $serverName, $connectionInfo);

            $tsql = "SELECT id, username, password, name FROM temp_table";

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
                        if(strcmp($_POST["password"], $row[2])==0){
                            $_SESSION["name"] = $row[3];
                            //$loggedIn=$row[3];
                        }
                    }
                }
            }

            // if login invalid, redirect back to login page
            //  so login page displays errer message
            //commented this out cause im testing single sign on

            if ($_SESSION["name"]==null) {
                $url = "index.php?loginfail=true";
                header("Location:" . $url);
                exit();
            }
            /* Free statement and connection resources. */
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $conn);
            echo "<h1> You are logged in as ".$_SESSION["name"];
            ?>

    </div>
</body>
</html>
