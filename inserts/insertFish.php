<?php
    $serverName = "oddquatic-db-server-333.database.windows.net"; 
    $connectionOptions = array(
        "Database" => "oddquatic-resourcedb-333", 
        "Uid" => "CloudSAe6d5ed3e", 
        "PWD" => "xojoannaxo33+" 
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
     die( print_r( sqlsrv_errors(), true));
    }

    $secretKey = "Kongllelujah"; // Secret key to allow for match test
    $realHash = md5($_GET['name'] . $_GET['scale'] . $_GET['color'] . $secretKey); // Make an MD5 hash with the given data - it should match up to the hash

    // If our hash matches, our keys match, and we have verified that the request came from a legitimate client and we can proceed with insertion
    if($realHash == $_GET['hash'] ) { 
        // Set up our statement now that we understand what we're passing in
        $tsql= "INSERT INTO dbo.Fish VALUES (:name, :scale, :color)";
        $getResults= sqlsrv_query($conn, $tsql);
        if ($getResults == FALSE)
            echo (sqlsrv_errors());
    } 
    else{
        echo "Hashes don't match, security breach"
    }