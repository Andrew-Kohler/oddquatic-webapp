<?php
    $serverName = "oddquatic-db-server-333.database.windows.net"; // update me
    $connectionOptions = array(
        "Database" => "oddquatic-resourcedb-333", // update me
        "Uid" => "CloudSAe6d5ed3e", // update me
        "PWD" => "xojoannaxo33+" // update me
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
    }

    $tsql= "SELECT * FROM dbo.Fish";
    $getResults= sqlsrv_query($conn, $tsql);
    if ($getResults == FALSE)
        echo (sqlsrv_errors());
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
     $data = ['FishID' = $row['FishID'], 'FishName' = $row['FishName'], 'FishScale' = $row['FishScale'],'FishColor' = $row['FishColor']]
     header('Content-Type: application/json; charset=utf-8');
     echo json_encode($data);
     //echo ($row['FishName'] . " " . $row['FishScale'] . " " . $row['FishColor'] . PHP_EOL);
    }
    sqlsrv_free_stmt($getResults);

