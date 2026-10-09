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
     //die( print_r( sqlsrv_errors(), true));
        echo 'F';
    }
    else{
        echo 'T';
    }