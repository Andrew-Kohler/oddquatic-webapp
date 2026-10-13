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

    $secretKey = "Kongllelujah"; // Secret key to allow for match test
    $realHash = md5($_POST['username'] . $secretKey); // Make an MD5 hash with the given data - it should match up to the hash

    // If our hash matches, our keys match, and we have verified that the request came from a legitimate client and we can proceed with retrieval
    if($realHash == $_POST['hash'] ) { 
        $params = [$_POST['username']];

        // So first within here, we need to check if the username is actually real. If it's not, we have someone new!
        $tsql = "SELECT UserID
                FROM dbo.Users
                WHERE UserName = ?";
        $getResults= sqlsrv_query($conn, $tsql, $params); 

        if ($getResults == FALSE) { 
            echo (serialize(sqlsrv_errors()));
        }

        else if(sqlsrv_fetch($getResults) == null) // If we find no results, we just add this user to the database 
            {
            $tsql = "INSERT INTO dbo.Users  
                VALUES(?, 0)";
            $getResults= sqlsrv_query($conn, $tsql, $params); // We insert our user into the user list

            if ($getResults == FALSE){
                echo (serialize(sqlsrv_errors()));
            }
            else{ // Then, we get their UID and echo it back
                $tsql = "SELECT UserID
                      FROM dbo.Users
                      WHERE UserName = ?";
                $getResults= sqlsrv_query($conn, $tsql, $params); 

                if ($getResults == FALSE) { 
                    echo (serialize(sqlsrv_errors()));
                }

                // Make the first (and in this case, only) row of the result set available for reading.
                if( sqlsrv_fetch( $getResults ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }

                echo 'NUID' . sqlsrv_get_field( $getResults, 0); // Echo back the first field of the row we found
            }
        }
        else {
                // Same thing just without the extra insertion and get; make the row free to read, and then echo back the ID
                if( sqlsrv_fetch( $getResults ) === false) {
                    die( print_r( sqlsrv_errors(), true));
                }

                echo 'NUID' . sqlsrv_get_field( $getResults, 0); 
        }
    } 
    else{
        echo "Hashes don't match, security breach"; // A little dramatic and not especially useful, but still true!
    }