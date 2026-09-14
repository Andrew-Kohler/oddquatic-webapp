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
     $data = ['id' => $row['FishID'], 'name' => $row['FishName'], 'scale' => $row['FishScale'],'color' => $row['FishColor']];
     header('Content-Type: application/json');
     echo json_encode($data) . ',';
     //echo $data;
    }
    sqlsrv_free_stmt($getResults);

