<?php
  include('LDAP/constants.php');
  $claimID = $_GET['claimID'];
  $serverName = SERVERNAME;
  $uid = UID;
  $pwd = PWD;
  $databaseName = DATABASENAME;

  $connectionInfo = array( "UID"=>$uid,
      "PWD"=>$pwd,
      "Database"=>$databaseName);

  /* Connect using SQL Server Authentication. */
  $conn = sqlsrv_connect( $serverName, $connectionInfo);

  $tsql = "SELECT claimID, claimant, claimantSSN, spouse, spouseSSN, currentAPN, dateAcquired, dateOccupied, currentStName, currentCity, currentZip, priorAPN, dateMovedOut, priorStName, priorCity, priorZip, rollTaxYear, exemptRE, suppTaxYear, exemptRE2, claimAction, findingReason, claimReceived, claimReceivedAssignor, claimReceivedAssignee,
    supervisorWorkload, supervisorWorkloadAssignor, supervisorWorkloadAssignee,
    staffReview, staffReviewAssignor, staffReviewAssignee, 
    staffReviewDate, staffReviewDateAssignor, staffReviewDateAssignee, 
    supervisorReview, supervisorReviewAssignor, supervisorReviewAssignee,
    caseClosed, caseClosedAssignor, caseClosedAssignee, currStatus, preprintSent, preprintSentAssignor, preprintSentAssignee, hold, holdAssignor, holdAssignee, currentState, dateAcquired, dateOccupied, active, mailingStName, mailingApt, mailingCity, mailingState, mailingZip, currentApt
    FROM claim_table WHERE claimID=".$claimID;

  /* Execute the query. */

  $stmt = sqlsrv_query( $conn, $tsql);
  $myObj = new stdClass();
  if ( $stmt )
  {
    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC))
    {
        $myObj->claimID =$row[0];
        $myObj->claimant = $row[1];
        // $myObj->claimantSSN = $row[2]; //Replace this with a decrpytion fn
        $alpha = openssl_decrypt($row[2], ENCRPYTIONMETHOD, HASH, false, IV);
        $myObj->claimantSSN = $alpha;
        $myObj->spouse = $row[3];
        // $myObj->spouseSSN = $row[4];
        $beta = openssl_decrypt($row[4], ENCRPYTIONMETHOD, HASH, false, IV);
        $myObj->spouseSSN = $beta;
        $myObj->currentAPN = $row[5];
//echo "dateAcquired: ".$row[8];
// echo "dateOccupied: ".$row[9];
        $myObj->currentStName = $row[8];
        $myObj->currentCity = $row[9];
        $myObj->currentZip = $row[10];
        $myObj->priorAPN = $row[11];
//echo "dateMovedOut: ".$row[13];
        $myObj->priorStName = $row[13];
        $myObj->priorCity = $row[14];
        $myObj->priorZip = $row[15];
        $myObj->rollTaxYear = $row[16];
        $myObj->exemptRE = $row[17];
        $myObj->suppTaxYear = $row[18];
        $myObj->exemptRE2 = $row[19];
        $myObj->claimAction = $row[20];
        $myObj->findingReason = $row[21];
        $myObj->claimReceived = $row[22];
        $myObj->claimReceivedAssignor = $row[23];
        $myObj->claimReceivedAssignee = $row[24];
        $myObj->supervisorWorkload = $row[25];
        $myObj->supervisorWorkloadAssignor = $row[26];
        $myObj->supervisorWorkloadAssignee = $row[27];
        $myObj->staffReview = $row[28];
        $myObj->staffReviewAssignor = $row[29];
        $myObj->staffReviewAssignee = $row[30];
        $myObj->staffReviewDate = $row[31];
        $myObj->staffReviewDateAssignor = $row[32];
        $myObj->staffReviewDateAssignee = $row[33];
        $myObj->supervisorReview = $row[34];
        $myObj->supervisorReviewAssignor = $row[35];
        $myObj->supervisorReviewAssignee = $row[36];
        $myObj->caseClosed = $row[37];
        $myObj->caseClosedAssignor = $row[38];
        $myObj->caseClosedAssignee = $row[39];
        $myObj->currStatus = $row[40];
        $myObj->preprintSent = $row[41];
        $myObj->preprintSentAssignor = $row[42];
        $myObj->preprintSentAssignee = $row[43];
        $myObj->hold = $row[44];
        $myObj->holdAssignor = $row[45];
        $myObj->holdAssignee = $row[46];

        $myObj->currentState = $row[47];

        $myObj->dateAcquired = $row[48];
        $myObj->dateOccupied = $row[49];
        $myObj->activeStatus = $row[50];

        $myObj->mailingStName = $row[51];
        $myObj->mailingApt    = $row[52];
        $myObj->mailingCity   = $row[53];
        $myObj->mailingState  = $row[54];
        $myObj->mailingZip    = $row[55];

        $myObj->currentApt    = $row[56];

        // $myObj->currentState = $row[47];

        $myJSON = json_encode($myObj);
        echo $myJSON;
        //echo "var phpObj = ".$myJSON.";";

        //echo "<script>rePlaceholder($myJSON)</script>";
//echo "claimReceived: ".$row[26];
//echo "supervisorWorkload: ".$row[27];
//echo "staffReview: ".$row[28];

        // echo "<script>console.log(claimant);</script>";
    }
  }
  else
  {
      // echo "Error in statement execution.\n";
      die( print_r( sqlsrv_errors(), true));
  }
?>