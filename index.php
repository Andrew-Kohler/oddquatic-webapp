<?php
    // Connection details for our server - where to find it, which database we want to open, and the username/password for it
    $serverName = "oddquatic-db-server-333.database.windows.net";
    $connectionOptions = array(
        "Database" => "oddquatic-resourcedb-333", 
        "Uid" => "CloudSAe6d5ed3e", 
        "PWD" => "xojoannaxo33+"
    );

    //Establishes the connection, print errors if it's a miss
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
    }

    // Query our SQL server with a select-all statement, echo errors on failure
    $tsql= "SELECT * FROM dbo.Fish";
    $getResults= sqlsrv_query($conn, $tsql);
    if ($getResults == FALSE)
        echo (sqlsrv_errors());

    // Echo back each found row formatted as JSON
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
     $data = ['id' => $row['FishID'], 'name' => $row['FishName'], 'scale' => $row['FishScale'],'color' => $row['FishColor']];
     header('Content-Type: application/json');
     echo json_encode($data) . ','; // Additional formatting to help Unity parse the data
    }

    // Frees the resources we were using to hold the results and prevents getResults from being re-executed in another query
    sqlsrv_free_stmt($getResults);

