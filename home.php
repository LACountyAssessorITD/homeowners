<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Homeowner Fraud</title>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover {
    background-color: #111;
}
</style>
</head>
<body>
    <ul>
  <li><a href="claim.php">Claim</a></li>
  <li><a href="HomeownerInformation.php">Search Page</a></li>
  <li><a href="indexv2.php">Logout</a></li>
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

            $tsql = "SELECT id, username, password FROM temp_table";

            /* Execute the query. */

            $stmt = sqlsrv_query( $conn, $tsql);

            if ( $stmt )
            {
                // echo "You are Logged in!<br>\n";
            }
            else
            {
                echo "Error in statement execution.\n";
                die( print_r( sqlsrv_errors(), true));
            }

            /* Iterate through the result set printing a row of data upon each iteration.*/
            $loggedIn='false';
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
            {
                // echo "Col1: ".$row[0]."\n";
                // echo "Col2: ".$row[1]."\n";
                // echo "Col3: ".$row[2]."<br>\n";
                // echo "-----------------<br>\n";
                if(strcmp($_POST["username"], $row[1])==0){
                    if(strcmp($_POST["password"], $row[2])==0){
                        $loggedIn='true';
                    }
                }
            }

            // if login invalid, redirect back to login page
            //  so login page displays errer message
            //commented this out cause im testing single sign on

            if ($loggedIn != "true") {
                $url = "indexv2.php?loginfail=true";
                header("Location:" . $url);
                exit();
            }


            //echo "Entered Username: ".$_POST["username"]."<br>\n";
            //echo "Entered Password: ".$_POST["password"]."<br>\n";
            //echo "Logged In Status= ".$loggedIn."<br>\n";
            /* Free statement and connection resources. */
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $conn);
            ?>

    </div>
</body>
</html>
