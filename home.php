<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Homeowner Fraud</title>
    <style type="text/css">
    .wrap { max-width: 720px; margin: 50px auto; padding: 30px 40px; text-align: center; box-shadow: 0 4px 25px -4px #9da5ab; }
    article { text-align: left; padding: 40px; line-height: 150%; }
</style>
</head>
<body>
    <div class="wrap">

        <header>
            <h2>Homeowner Fraud</h2>
            <nav class="menu">
            </nav>
        </header>

        <article>
            <h3>Homeowner Fraud</h3>
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
            if ($loggedIn != "true") {
                $url = "indexv2.php?loginfail=true";
                header("Location:" . $url);
                exit();
            }

            echo "Entered Username: ".$_POST["username"]."<br>\n";
            echo "Entered Password: ".$_POST["password"]."<br>\n";
            echo "Logged In Status= ".$loggedIn."<br>\n";
            /* Free statement and connection resources. */
            sqlsrv_free_stmt( $stmt);
            sqlsrv_close( $conn);
            ?>

        </article>

        <footer><small>&copy;<?php echo date('Y'); ?> Homeowner Fraud.<br>1.0</small></footer>

    </div>
</body>
</html>
