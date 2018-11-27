<?php
    session_start();
    include('LDAP/constants.php');
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
    if($_SESSION["name"]==null || $_SESSION["permissions"] == null){
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

    if ($_SESSION["name"]==null) {
        $url = "index.php?loginfail=true";
        header("Location:" . $url);
        exit();
    }
    /* Free statement and connection resources. */
    sqlsrv_free_stmt( $stmt);
    sqlsrv_close( $conn);
    $url = "productivity_report_page.php";
    header("Location:" . $url);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Homeowner Fraud</title>
    <!-- Bootstrap CSS -->
        <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
    <link rel="stylesheet" type="text/css" href="styles/general-style.css">

</head>
<body>
</body>
</html>
