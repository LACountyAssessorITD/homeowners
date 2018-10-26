<?php
  $claimID = $_GET['claimID'];
              $serverName = "Assessor";
            $uid = "zhdllwyc";
            $pwd = 'A$$essortrain456';
            $databaseName = "homeowner_test";

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
              caseClosed, caseClosedAssignor, caseClosedAssignee
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
                  $myObj->claimantSSN = $row[2];
                  $myObj->spouse = $row[3];
                  $myObj->spouseSSN = $row[4];
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