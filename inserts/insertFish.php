<?php

    register_shutdown_function(function () {
    $last_error = error_get_last();
    if ($last_error && in_array($last_error['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_CORE_ERROR]))
        header('HTTP/1.1 500 Terrible Internal Server Error', TRUE, 500);
    });

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
    $realHash = md5($_POST['name'] . $_POST['scale'] . $_POST['color'] . $secretKey); // Make an MD5 hash with the given data - it should match up to the hash

    // If our hash matches, our keys match, and we have verified that the request came from a legitimate client and we can proceed with insertion
    if($realHash == $_POST['hash'] ) { 
        $params = [$_POST['name'], $_POST['scale'], $_POST['color']]
        // Set up our statement now that we understand what we're passing in
        $tsql= "INSERT INTO dbo.Fish VALUES (?,?,?)";
        $getResults= sqlsrv_query($conn, $tsql, $params);
        if ($getResults == FALSE)
            echo (serialize(sqlsrv_errors()));
    } 
    else{
        echo "Hashes don't match, security breach";
    }